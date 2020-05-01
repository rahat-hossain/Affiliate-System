<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Invoice;
use App\InvoiceDetail;
use App\Package;
use App\Setting;
use Carbon\Carbon;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index($id, $coupon_code = "")
    {
        if ($coupon_code == "")
        {
            $coupon_discount_amount = 0;
            $settings = Setting::all();
            $packages = Package::findOrFail($id);
            return view('frontend.packageBuy.index', compact('packages', 'settings', 'coupon_discount_amount', 'coupon_code'));
        }
        else
        {
            $coupon_expire_date = Coupon::where('code', $coupon_code)->first()->expire_date ?? '';
            $current_time = Carbon::now();

            if (empty($coupon_expire_date))
            {
                return back()->withErrors('Invalid Coupon!');
            }

            if ($coupon_expire_date >= $current_time)
            {

                $coupon_code_for = Coupon::where('code', $coupon_code)->first()->for ?? '';
                if(Auth()->user()->id == $coupon_code_for || $coupon_code_for == 0)
                {
                    if (Coupon::where('code', $coupon_code)->first())
                    {
                        $coupon_discount_amount = Coupon::where('code', $coupon_code)->first()->value;
                    }
                    else
                    {
                        return back()->withErrors('Invalid Coupon!');
                    }
                    $settings = Setting::all();
                    $packages = Package::findOrFail($id);
                    return view('frontend.packageBuy.index', compact('packages', 'settings', 'coupon_discount_amount', 'coupon_code'));
                }
                else
                {
                    return back()->withErrors('Invalid Coupon!');
                }



            }
            else
            {
                return back()->withErrors('Coupon Expired!');
            }
        }
    }


    function doubleCoupon($id, $coupon_code1, $coupon_code2)
    {
        return back()->withErrors(" '".$coupon_code1."' " . 'Coupon Already Applied !');
    }


    function shipping_address($id)
    {
        $packages = Package::findOrFail($id);
        return view('frontend.packageBuy.shipping_address', compact('packages'));
    }

    public function packageStore(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'coupon_code' => 'nullable|string',
            'coupon_discount_amount' => 'nullable|string',
            'product_id' => 'required|integer',
            'package_id' => 'required|integer',
            'unit_price' => 'required|numeric',
            'cash_discount' => 'required|numeric',
            'quantity' => 'required|numeric',
            'shipping_charge' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'alternate_phone' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
        ]);


        $user = User::where(['id' => \auth()->id()])->first();
        if ($user)
        {
            // update user
            $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);
            $user->relationToProfile()->update([
                'name' => $request->name,
                'email' => $request->email,
                'alternate_phone' => $request->alternate_phone,
                'address' => $request->address,
            ]);
            // end update user

            $invoice = Invoice::create([
                'user_id' =>$user->id,
                'shipping_cost' => $request->shipping_charge,
                'coupon_code' => $request->coupon_code,
                'coupon_amount' => $request->coupon_discount_amount,
                'payment_status' => 1,
                'payment_method' => $request->payment_method,
            ]);

            InvoiceDetail::create([
                'invoice_id' =>$invoice->id,
                'package_id' =>$request->package_id,
                'product_id' =>$request->product_id,
                'unit_price' =>$request->unit_price,
                'quantity' =>$request->quantity,
                'cash_discount' => $request->cash_discount,
                'vat_tax' => $request->tax_percentage,
            ]);
            return redirect()->route('order.thanks');
        }
        else
        {
            return redirect('login');
        }

    }

    public function orderThanks()
    {
        return view('frontend.packageBuy.thanks');
    }



    function updateQuantity($quantity)
    {
        return redirect()->back()->with('quantity', $quantity);
    }




}
