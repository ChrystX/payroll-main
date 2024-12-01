@extends('layouts.main')

@section('title', 'Initiate Payment')

@section('content')
<!-- Initiate Payment Form -->
<div class="form-container">
    @if($pendingJadwal)
        <p>There is a pending payment schedule for {{ $pendingJadwal->selected_date }}.</p>
        <form action="{{ route('jadwal.cancel', $pendingJadwal->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Cancel Pending Payment Schedule</button>
        </form>
    @else
        <form action="{{ route('jadwal.store') }}" method="POST">
            @csrf
            <div class="row mb-2">
                <div class="col-md-4">
                    <label for="accountName">Payment Source Account</label>
                    <div class="btn-group w-100">
                        <select id="sourceAccount" name="payment_account" class="form-select btn btn-primary dropdown-toggle">
                            <option value="">Select an account</option>
                            @foreach ($sumberdana as $account)
                                <option value="{{ $account->id }}">{{ $account->accountname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="paymentDate">Payment Date</label>
                    <input type="date" id="paymentDate" name="payment_date" class="form-control" required />
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Payment Schedule</button>
        </form>
    @endif
</div>

<hr />

<!-- Countdown Timer -->
@if($pendingJadwal)
<div class="countdown-container">
    <h3>Next Payment Schedule: {{ $pendingJadwal->selected_date }}</h3>
    <div id="countdown"></div>
</div>
@endif

<hr />

<!-- Transaction History Table -->
<h3>Transaction History</h3>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Target Account</th>
                <th>Name</th>
                <th>Source Account</th>
                <th>Date</th>
                <th>Nominal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->pekerja->rekening_pekerja ?? 'N/A' }}</td>
                    <td>{{ $transaction->pekerja->nama_pekerja ?? 'N/A' }}</td>
                    <td>{{ $transaction->sumberDana->no_rekening ?? 'N/A' }}</td>
                    <td>{{ $transaction->tgl_byr }}</td>
                    <td>Rp {{ number_format($transaction->nominal, 2) }}</td>
                    <td>
                        <span class="badge {{ $transaction->status == 'completed' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
@if($pendingJadwal)
    var countDownDate = new Date("{{ $pendingJadwal->selected_date }}T00:00:00").getTime();
    var countdownfunction = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById("countdown").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
        if (distance < 0) {
            clearInterval(countdownfunction);
            document.getElementById("countdown").innerHTML = "EXPIRED";
        }
    }, 1000);
@endif
</script>

@endsection
