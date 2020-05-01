<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileValidation;
use App\Marketing;
use App\Package;
use App\Product;
use App\Profile;
use App\User;
use Illuminate\Http\Request;

class FrontendController extends Controller
{


//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    function index()
    {
        $packages = Package::all();
        $products = Product::where('status', '=', 1)->get();
        return view('frontend.welcome', compact('products', 'packages'));
    }

    public function userProfile()
    {
        $myRefararId= Marketing::where('new_user_id', auth()->id())->first();
        if($myRefararId)
        {
            $refarar_name = User::where('id', $myRefararId->refered_user_id)->first()->name;
        }
        $refarar_name  = $refarar_name ?? 'N/A';

        return view('frontend.user_profile.index', compact('refarar_name'));
    }

}
