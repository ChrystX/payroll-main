<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Transaksi;
use App\Models\Pekerja;
use App\Models\sumberdana;
use DB;

class jadwalController extends Controller
{
 // Display the transaction page and handle payment processing
 public function index()
 {
     // Fetch the schedule and transaction data
     $sumberdana = SumberDana::all();
     $transactions = Transaksi::with(['pekerja', 'sumberdana', 'jadwal'])->get();
     $pendingJadwal = Jadwal::where('status', 'pending')->first();
 
     return view('transaction', compact('transactions', 'sumberdana', 'pendingJadwal'));  // Pass pendingJadwal to the view
 }
 
 public function cancel($id)
{
    $jadwal = Jadwal::findOrFail($id);
    $jadwal->delete();

    return redirect()->route('transaction')->with('success', 'Pending payment schedule cancelled successfully.');
}

 public function store(Request $request)
 {
     // Validate the incoming request
     $request->validate([
         'payment_account' => 'required|exists:sumber_dana,id',  // Ensure the payment account exists
         'payment_date' => 'required|date',  // Ensure the payment date is provided
     ]);
 
     // Create a new Jadwal entry based on the request data
     $jadwal = new Jadwal();
     $jadwal->payment_account = $request->input('payment_account');  // Foreign key to sumberdana table
     $jadwal->selected_date = $request->input('payment_date');  // Payment date
     $jadwal->status = 'pending';  // Default status is 'pending'
     $jadwal->save();  // Save the jadwal entry
 
     // Redirect back or to a success page
     return redirect()->route('transaction')->with('success', 'Payment schedule created successfully.');
 }
 
 // Process payments based on the schedule ID
 public function processPayments($jadwalId)
 {
     // Fetch the jadwal by ID
     $jadwal = Jadwal::findOrFail($jadwalId);
 
     // Check if the schedule is pending and the selected date is today's date
     if ($jadwal->status == 'pending' && $jadwal->selected_date == today()->toDateString()) {
         // Fetch the payment account (SumberDana)
         $sumberDana = $jadwal->sumberDana;  // Assuming there is a relationship to SumberDana
 
         // Check if the payment account has enough balance
         if ($sumberDana->saldo < 0) {
             return back()->with('error', 'Insufficient balance in the payment account.');
         }
 
         // Fetch the workers associated with this schedule
         $pekerjas = Pekerja::whereHas('divisi', function ($query) use ($sumberDana) {
             $query->where('id_perusahaan', $sumberDana->id_perusahaan);
         })->with('divisi')->get();
 
         DB::beginTransaction();  // Begin transaction for atomicity
 
         try {
             foreach ($pekerjas as $pekerja) {
                 // Get the nominal for the worker (e.g., salary amount)
                 $nominal = $pekerja->divisi->gaji_pokok;
 
                 // Check if there is enough balance for the worker
                 if ($sumberDana->saldo < $nominal) {
                     // Mark as failed if insufficient balance
                     Transaksi::create([
                         'id_jadwal' => $jadwal->id,
                         'id_pekerja' => $pekerja->id,
                         'tgl_byr' => today(),
                         'wkt_byr' => now()->toTimeString(),
                         'nominal' => $nominal,
                         'status' => 'failed',
                     ]);
                     continue;  // Skip this worker and move to the next
                 }
 
                 // Proceed with deduction
                 $sumberDana->saldo -= $nominal;  // Deduct the amount from balance
                 $sumberDana->save();  // Save the updated balance
 
                 // Create a successful transaction entry
                 Transaksi::create([
                     'id_jadwal' => $jadwal->id,
                     'id_pekerja' => $pekerja->id,
                     'tgl_byr' => today(),
                     'wkt_byr' => now()->toTimeString(),
                     'nominal' => $nominal,
                     'status' => 'completed',
                 ]);
             }
 
             // Mark the jadwal as completed
             $jadwal->status = 'completed';
             $jadwal->save();
 
             DB::commit();  // Commit the transaction if all payments are successful
 
             return redirect()->route('transaction')->with('success', 'Payments processed successfully!');
         } catch (\Exception $e) {
             DB::rollBack();  // Rollback if any error occurs
             return back()->with('error', 'An error occurred while processing payments.');
         }
     }
 
     return back()->with('error', 'No payments scheduled for today.');
 }
 
 public function testPayment(Request $request)
 {
     // For testing, we'll just simulate a payment and show success/failure
     try {
         // Choose a random jadwal (schedule) and a random pekerja (worker)
         $jadwal = Jadwal::first(); // Replace with your own logic
         $sumberDana = $jadwal->sumberDana;

         if ($sumberDana->saldo <= 0) {
             return back()->with('error', 'Insufficient balance to process test payment.');
         }

         // Simulate deducting an amount for the test payment
         $nominal = 100000; // Example amount for the test
         if ($sumberDana->saldo >= $nominal) {
             $sumberDana->saldo -= $nominal;
             $sumberDana->save();

             Transaksi::create([
                 'id_jadwal' => $jadwal->id,
                 'id_pekerja' => $jadwal->pekerjas->first()->id, // Assuming there's at least one pekerja
                 'tgl_byr' => today(),
                 'wkt_byr' => now()->toTimeString(),
                 'nominal' => $nominal,
                 'status' => 'completed',
             ]);

             return back()->with('success', 'Test payment successful!');
         } else {
             return back()->with('error', 'Test payment failed due to insufficient balance.');
         }
     } catch (\Exception $e) {
         return back()->with('error', 'An error occurred while testing the payment.');
     }
 }

 public function processPaymentsForCompany(Request $request)
 {
     $companyId = $request->input('company_id');
     \Log::info("Processing payments for company ID: {$companyId}");
 
     try {
         // Adjusted query to join divisi and fetch pekerja based on id_perusahaan
         $pekerjas = Pekerja::whereHas('divisi', function ($query) use ($companyId) {
             $query->where('id_perusahaan', $companyId);
         })->with('divisi')->get();
         \Log::info("Fetched pekerjas: ", $pekerjas->toArray());
         
         $sumberDana = SumberDana::where('id_perusahaan', $companyId)->first();
         \Log::info("Fetched sumberDana: ", $sumberDana ? $sumberDana->toArray() : []);
 
         if ($pekerjas->isEmpty() || !$sumberDana) {
             \Log::info('No pekerja or sumberdana found for this company.');
             return back()->with('error', 'No pekerja or sumberdana found for this company.');
         }
 
         // Explicitly fetch the first jadwal and log it
         $jadwal = Jadwal::first();
         if (!$jadwal) {
             \Log::error('No jadwal found in the database.');
             return back()->with('error', 'No jadwal found in the database.');
         }
         \Log::info("Fetched jadwal: ", $jadwal->toArray());
 
         DB::beginTransaction(); // Start transaction for atomicity
 
         foreach ($pekerjas as $pekerja) {
             // Get the pekerja's salary (gaji_pokok)
             $nominal = $pekerja->divisi->gaji_pokok;
             \Log::info("Processing payment for pekerja ID: {$pekerja->id}, nominal: {$nominal}");
 
             if ($sumberDana->saldo >= $nominal) {
                 $sumberDana->saldo -= $nominal;
                 $sumberDana->save();
 
                 Transaksi::create([
                     'id_pekerja' => $pekerja->id,
                     'id_payment_account' => $sumberDana->id,
                     'tgl_byr' => today(),
                     'wkt_byr' => now()->toTimeString(),
                     'nominal' => $nominal,
                     'status' => 'completed',
                     'id_jadwal' => $jadwal->id, // Use the first jadwal's ID
                 ]);
 
                 \Log::info("Transaction completed for pekerja ID: {$pekerja->id}");
             } else {
                 // Mark as failed if insufficient balance
                 Transaksi::create([
                     'id_pekerja' => $pekerja->id,
                     'id_payment_account' => $sumberDana->id,
                     'tgl_byr' => today(),
                     'wkt_byr' => now()->toTimeString(),
                     'nominal' => $nominal,
                     'status' => 'failed',
                     'id_jadwal' => $jadwal->id, // Use the first jadwal's ID
                 ]);
 
                 \Log::info("Transaction failed for pekerja ID: {$pekerja->id} due to insufficient balance.");
             }
         }
 
         DB::commit(); // Commit the transaction if all payments are successful
         \Log::info('All payments processed successfully for the company.');
         return redirect()->route('transaction')->with('success', 'All payments processed successfully for the company.');
     } catch (\Exception $e) {
         DB::rollBack(); // Rollback if any error occurs
         \Log::error('An error occurred while processing payments: ' . $e->getMessage());
         return back()->with('error', 'An error occurred while processing payments: ' . $e->getMessage());
     }
 }
 
}
