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
        $profile->call_center = array_filter([
            $profile->call_center_1,
            $profile->call_center_2
        ]);
        $jadwals = Jadwal::all();
        return view('home', compact('profile', 'jurusans', 'jadwals'));
    }
}
