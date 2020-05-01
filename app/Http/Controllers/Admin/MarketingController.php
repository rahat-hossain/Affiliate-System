<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Marketing;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $marketings = Marketing::all();
        return view('backend.marketing.index', compact('marketings'));
    }
}
