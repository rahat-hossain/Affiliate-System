<?php

namespace App\Http\Controllers\Admin;

use App\DiscountRules;
use App\Http\Requests\DiscountruleValidation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DiscountruleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $discountrules = DiscountRules::all();
        return view('backend.discountrule.index', compact('discountrules'));
    }

    function discountruleInsert(DiscountruleValidation $request)
    {
//        DiscountRules::create($request->except('_token'));
            DiscountRules::insert([
            'discount_unit' => $request->discount_unit,
            'min' => $request->min,
            'max' => $request->max,
            'percentage' => $request->percentage,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);
        return back()->with('status', 'Discount rules insert successfully!!');
    }

    function discountruleEdit($discountrule_id)
    {
        $discountrule_info =  DiscountRules::findorFail($discountrule_id);
        return view('backend.discountrule.edit' , compact('discountrule_info'));
    }

    function discountruleUpdate(Request $request, $id)
    {
        DiscountRules::findOrFail($request->id)->update([
            'discount_unit' => $request->discount_unit,
            'min' => $request->min,
            'max' => $request->max,
            'percentage' => $request->percentage,
        ]);
        return redirect('admin/discountrule')->withEditstatus('Discount rules Edited successfully!!');
    }

    function discountruleDelete($discountrule_id)
    {
        DiscountRules::findOrFail($discountrule_id)->delete();
        return back()->with('deletestatus', 'Discount rules deleted successfully!!');
    }

    function active($discountrule_id)
    {
        DiscountRules::where('id',$discountrule_id)->update([
            'status' => '0',
        ]);
        return back();
    }

    function deactive($discountrule_id)
    {
        DiscountRules::where('id',$discountrule_id)->update([
            'status' => '1',
        ]);
        return back();
    }
}
