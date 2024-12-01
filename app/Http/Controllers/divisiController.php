<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class divisiController extends Controller
{
    // Menampilkan halaman daftar divisi
    public function index()
    {
        $perusahaan = Perusahaan::all();
        $divisi = Divisi::with('perusahaan')->get(); // Include perusahaan data
        return view('divisi', compact('perusahaan', 'divisi'));
    }

    // Menambah data divisi baru
    public function addDivisi(Request $request)
    {
        $validatedData = $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id',
            'nama_divisi' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        Divisi::create($validatedData);

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil ditambahkan!');
    }

    // Menampilkan form edit divisi
    public function editDivisi($id)
    {
        $divisi = Divisi::findOrFail($id);
        $perusahaan = Perusahaan::all();

        return view('editDivisi', compact('divisi', 'perusahaan'));
    }

    // Memperbarui data divisi
    public function updateDivisi(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id',
            'nama_divisi' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        $divisi = Divisi::findOrFail($id);
        $divisi->update($validatedData);

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil diperbarui!');
    }

    // Menghapus data divisi
    public function deleteDivisi($id)
    {
        $divisi = Divisi::findOrFail($id);
        $divisi->delete();

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil dihapus!');
    }
}
