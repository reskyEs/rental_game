<?php

namespace App\Http\Controllers;
use App\Models\Akun;

use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index()
{


    $user = auth()->user();

    return view('customer.navbar.topbar', compact('user'));
}

}




