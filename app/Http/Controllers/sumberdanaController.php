<?php

namespace App\Http\Controllers;

use App\Models\sumberdana;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class sumberdanaController extends Controller
{
    /**
     * Display the list of Sumber Dana and the form to add new one.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all sumber dana and perusahaan for dropdown
        $sumberDanas = sumberdana::with('perusahaan')->get();
        $perusahaanList = Perusahaan::all();

        return view('paymentaccount', compact('sumberDanas', 'perusahaanList'));
    }

    /**
     * Store a new Sumber Dana.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSumberDana(Request $request)
    {
        // Validate input
        $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id',
            'no_rekening' => 'required|string|max:50',
            'saldo' => 'required|numeric',
        ]);

        // Create new sumber dana
        sumberdana::create($request->all());

        return redirect()->route('paymentaccount')->with('success', 'Sumber Dana berhasil ditambahkan!');
    }

    /**
     * Edit a Sumber Dana.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function editSumberDana($id)
    {
        $sumberDana = sumberdana::findOrFail($id);
        $perusahaanList = Perusahaan::all();

        return view('editPaymentAccount', compact('sumberDana', 'perusahaanList'));
    }

    /**
     * Update the Sumber Dana.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSumberDana(Request $request, $id)
    {
        $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id',
            'no_rekening' => 'required|string|max:50',
            'saldo' => 'required|numeric',
        ]);

        $sumberDana = sumberdana::findOrFail($id);
        $sumberDana->update($request->all());

        return redirect()->route('paymentaccount')->with('success', 'Sumber Dana berhasil diperbarui!');
    }

    /**
     * Delete a Sumber Dana.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSumberDana($id)
    {
        $sumberDana = sumberdana::findOrFail($id);
        $sumberDana->delete();

        return redirect()->route('paymentaccount')->with('success', 'Sumber Dana berhasil dihapus!');
    }
}
