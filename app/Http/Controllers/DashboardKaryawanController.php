<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardKaryawanController extends Controller
{
    public function index()
    {
        return view('karyawan.dashboard');
    }
}
