<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class transaksiController extends Controller
{
        // Display all transactions
        public function index()
        {
            $transaksi = Transaksi::with(['jadwal', 'pekerja'])->get();
            return view('transaksi.index', compact('transaksi'));
        }
    
        // Display a specific transaction
        public function show($id)
        {
            $transaksi = Transaksi::with(['jadwal', 'pekerja'])->findOrFail($id);
            return view('transaksi.show', compact('transaksi'));
        }
}
