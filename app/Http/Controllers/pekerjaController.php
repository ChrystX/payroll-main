<?php

namespace App\Http\Controllers;

use App\Models\Pekerja;
use App\Models\Divisi;
use Illuminate\Http\Request;

class pekerjaController extends Controller
{
    /**
     * Menampilkan daftar pekerja
     */
    public function index()
    {
        $pekerja = Pekerja::with('divisi')->get(); // Include relasi divisi
        $divisi = Divisi::all(); // Data divisi untuk form
        return view('workerdata', compact('pekerja', 'divisi'));
    }

    /**
     * Menambah pekerja baru
     */
    public function addPekerja(Request $request)
    {
        $validatedData = $request->validate([
            'id_divisi' => 'required|exists:divisi,id',
            'nama_pekerja' => 'required|string|max:255',
            'nama_bank' => 'required|string|max:10',
            'rekening_pekerja' => 'required|string|max:50',
        ]);

        Pekerja::create($validatedData);

        return redirect()->route('workerdata')->with('success', 'Pekerja berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit pekerja
     */
    public function editPekerja($id)
    {
        $pekerja = Pekerja::findOrFail($id);
        $divisi = Divisi::all(); // Data divisi untuk dropdown
        return view('editWorker', compact('pekerja', 'divisi'));
    }

    /**
     * Memperbarui data pekerja
     */
    public function updatePekerja(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_divisi' => 'required|exists:divisi,id',
            'nama_pekerja' => 'required|string|max:255',
            'nama_bank' => 'required|string|max:10',
            'rekening_pekerja' => 'required|string|max:50',
        ]);

        $pekerja = Pekerja::findOrFail($id);
        $pekerja->update($validatedData);

        return redirect()->route('workerdata')->with('success', 'Pekerja berhasil diperbarui!');
    }

    /**
     * Menghapus data pekerja
     */
    public function deletePekerja($id)
    {
        $pekerja = Pekerja::findOrFail($id);
        $pekerja->delete();

        return redirect()->route('workerdata')->with('success', 'Pekerja berhasil dihapus!');
    }
}
