<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    function index()
    {
       // $data = ['title' => 'Dashboard'];
		
		return view('admin.dashboard');
    }
}
