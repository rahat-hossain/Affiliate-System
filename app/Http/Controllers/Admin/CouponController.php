<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponValidation;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $coupons = Coupon::all();
        $users = User::where('type', '=', 'user')->get();
        return view('backend.coupon.index',compact('users', 'coupons'));
    }



    function couponInsert(Request $request)
    {
//        dd($request->all());
        //form validation
        $request->validate([
            'title' => 'required',
            'code' => 'required|unique:coupons,code',
            'value' => 'required',
            'validity_date' => 'required|date',
            'validity_time' => 'required',
            'for' => 'required',
        ]);

        $coupon_validity = $request->validity_date." ".$request->validity_time.":00";
        if(Str::endsWith($request->value, '%'))
        {
            if (Str::before($request->value, '%') < 100)
            {
                $main_value = Str::before($request->value, '%');
                if(is_numeric($main_value))
                {
                    //insert when value will be %
                    Coupon::insert([
                        'title' => $request->title,
                        'code' => $request->code,
                        'value' => $request->value,
                        'expire_date' => $coupon_validity,
                        'for' => $request->for ?? '0',
                        'created_at' => Carbon::now(),
                    ]);
                }
                else
                {
                    return back()->withErrors('Coupon value must be numeric');
                }
            }
            else
            {
                return back()->withErrors('Coupon % must be less then 100');
            }
        }
        else
        {
            $main_value = Str::before($request->value, '%');
            if(is_numeric($main_value))
            {
                //insert when value will be flat amount
                Coupon::insert([
                    'title' => $request->title,
                    'code' => $request->code,
                    'value' => $request->value,
                    'expire_date' => $coupon_validity,
                    'for' => $request->for ?? '0',
                    'created_at' => Carbon::now(),
                ]);
            }
            else
            {
                return back()->withErrors('Coupon value must be numeric');
            }
        }
        return back()->with('status', 'Coupon Created successfully!!');
    }





    function couponEdit($coupon_id)
    {
        $users = User::where('type', '=', 'user')->get();
        $coupon_info = Coupon::findOrFail($coupon_id);
        return view('backend.coupon.edit', compact('coupon_info', 'users'));
    }






    function couponUpdate(Request $request, $id)
    {
        //form validation
        $request->validate([
            'title' => 'required',
            'code' => 'required',
            'value' => 'required',
            'validity_date' => 'required|date',
            'validity_time' => 'required',
            'for' => 'required',
        ]);

        $coupon_validity = $request->validity_date." ".$request->validity_time;
        if(Str::endsWith($request->value, '%'))
        {
            if (Str::before($request->value, '%') < 100)
            {
                $main_value = Str::before($request->value, '%');
                if(is_numeric($main_value))
                {
                    //insert when value will be %
                    Coupon::findOrFail($request->id)->update([
                        'title' => $request->title,
                        'code' => $request->code,
                        'value' => $request->value,
                        'expire_date' => $coupon_validity,
                        'for' => $request->for,
                    ]);
                }
                else
                {
                    return back()->withErrors('Coupon value must be numeric');
                }
            }
            else
            {
                return back()->withErrors('Coupon % must be less then 100');
            }
        }
        else
        {
            $main_value = Str::before($request->value, '%');
            if(is_numeric($main_value))
            {
                //insert when value will be flat amount
                Coupon::findOrFail($request->id)->update([
                    'title' => $request->title,
                    'code' => $request->code,
                    'value' => $request->value,
                    'expire_date' => $coupon_validity,
                    'for' => $request->for,
                ]);
            }
            else
            {
                return back()->withErrors('Coupon value must be numeric');
            }
        }
        return redirect('admin/coupon')->withEditstatus('Coupon Edited successfully!!');
    }




    function couponDelete($coupon_id)
    {
        Coupon::findOrFail($coupon_id)->delete();
        return back()->with('deletestatus', 'Coupon deleted successfully!!');
    }

}
