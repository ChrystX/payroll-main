<?php

namespace App\Http\Controllers;

use App\Models\perusahaan;
use Illuminate\Http\Request;

class perusaanController extends Controller
{
    public function index()
    {
        $perusahaan = perusahaan::all();
        return view('crudperusahaan', ['perusahaan' => $perusahaan]);
    }

    public function addPerusahaan(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        // Tambah data ke database
        perusahaan::create($validatedData);

        // Redirect atau kirim response
        return redirect()->route('crudperusahaan')->with('success', 'Perusahaan berhasil ditambahkan!');
    }

    public function editPerusahaan($id)
    {
        $perusahaan = perusahaan::findOrFail($id); // Correctly fetch a single record by ID
        return view('crudperusahaan', compact('perusahaan')); // Pass it to the view
    }


    public function updatePerusahaan(Request $request, $id)
{
    $validatedData = $request->validate([
        'nama_perusahaan' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
    ]);

    $perusahaan = perusahaan::findOrFail($id); // Find the record to update
    $perusahaan->update($validatedData); // Save changes to the database

    return redirect()->route('crudperusahaan')->with('success', 'Perusahaan berhasil diupdate!');
}



    public function deletePerusahaan($id)
    {
        // Cari perusahaan berdasarkan id dan hapus
        $perusahaan = perusahaan::findOrFail($id);
        $perusahaan->delete();

        return redirect()->route('crudperusahaan')->with('success', 'Perusahaan berhasil dihapus!');
    }
}
