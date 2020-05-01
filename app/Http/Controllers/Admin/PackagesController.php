<?php

namespace App\Http\Controllers\Admin;

use App\DiscountRules;
use App\Http\Requests\PackagesValidation;
use App\Package;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PackagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $products = Product::where('status', '=', 1)->get();
        $discountrules = DiscountRules::where('status', '=', 1)->get();
        $packages = Package::all();
        return view('backend.packages.index', compact('products', 'discountrules', 'packages'));
    }

    function packagesInsert(PackagesValidation $request)
    {
        Package::insert([
            'product_id' => explode('.', $request->product_id)[0],
            'discount_rule_id' => explode('.', $request->discount_rule_id)[0],
            'tax_percentage' => $request->tax_percentage,
            'price' => $request->price,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('status', 'Packages insert successfully!!');
    }

    function packagesEdit($packages_id)
    {
        $products = Product::all();
        $discountrules = DiscountRules::all();
        $packages_info = Package::findOrFail($packages_id);
        return view('backend.packages.edit', compact('packages_info', 'products', 'discountrules'));
    }

    function packagesUpdate(Request $request, $id)
    {
        Package::findOrFail($request->id)->update([
            'product_id' => $request->product_id,
            'discount_rule_id' => $request->discount_rule_id,
            'price' => $request->price,
        ]);
        return redirect('admin/packages')->withEditstatus('Packages Edited successfully!!');
    }

    function packagesDelete($packages_id)
    {
        Package::findOrFail($packages_id)->delete();
        return back()->with('deletestatus', 'Packages deleted successfully!!');
    }
}
