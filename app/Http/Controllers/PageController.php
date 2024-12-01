<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    // public function pa()
    // {
    //     return view('paymentaccount');
    // }

    // public function worker()
    // {
    //     return view('workerdata');
    // }

    public function transaction()
    {
        return view('transaction');
    }

    public function logbook()
    {
        return view('logbook');
    }

    // public function admin()
    // {
    //     return view('admin');
    // }

    // public function crudper()
    // {
    //     return view('crudperusahaan');
    // }

    public function divisi()
    {
        return view('divisi');
    }
}
