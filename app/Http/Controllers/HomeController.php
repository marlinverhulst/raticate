<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user()->name;
        if(Auth::user()->isAdmin()){
            return view('admin.index', compact('user'));
        }
        if(Auth::user()->isTechnician()){
            return view('tech.index', compact('user'));

        }

        else return view('home');
    }
}
