<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{
    /**
     * Display a listing of the admin users.
     */
    public function index()
    {
        $admins = Admin::with('perusahaan')->get();
        $perusahaan = Perusahaan::all();

        return view('admin', compact('admins', 'perusahaan'));
    }

    /**
     * Store a newly created admin user.
     */
    public function addAdmin(Request $request)
    {
        // dd($request->all()); // Debug data yang dikirim
        $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id',
            'username' => 'required|string|max:30|unique:admin,username',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|max:20',
        ]);

        Admin::create([
            'id_perusahaan' => $request->id_perusahaan,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin created successfully!');
    }


    /**
     * Show the form for editing the specified admin user.
     */
    public function editAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $perusahaan = Perusahaan::all();

        return view('admin.edit', compact('admin', 'perusahaan'));
    }

    /**
     * Update the specified admin user in storage.
     */
    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id',
            'username' => 'required|string|max:30|unique:admin,username,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|string|max:20',
        ]);

        $admin->update([
            'id_perusahaan' => $request->id_perusahaan,
            'username' => $request->username,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin updated successfully!');
    }

    /**
     * Remove the specified admin user from storage.
     */
    public function deleteAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'Admin deleted successfully!');
    }
}
