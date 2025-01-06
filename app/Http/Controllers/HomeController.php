<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolProfile;
use App\Models\Jurusan;
use App\Models\Jadwal;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jurusans = Jurusan::all();
        $profile = SchoolProfile::first();
        $jadwals = Jadwal::all();
        return view('home', compact('profile', 'jurusans', 'jadwals'));
    }
}
