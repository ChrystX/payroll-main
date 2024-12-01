@extends('layouts.main')
@section('title', 'Payment Account Management')

@section('content')

<!-- Button to trigger add modal -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPaymentAccountModal">
    Add New Payment Account
</button>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Payment Accounts Table -->
<h4>Payment Accounts</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Account ID</th>
            <th>Perusahaan</th>
            <th>Account Name</th>
            <th>Account Number</th>
            <th>Balance</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($sumberDanas as $account)
            <tr>
                <td>{{ $account->id }}</td>
                <td>{{ $account->perusahaan->nama_perusahaan }}</td>
                <td>{{ $account->accountname }}</td>
                <td>{{ $account->no_rekening }}</td>
                <td>{{ number_format($account->saldo, 2) }}</td>
                <td>
                    <!-- Edit Button -->
                    <button
                        type="button"
                        class="btn btn-warning btn-sm"
                        data-toggle="modal"
                        data-target="#editPaymentAccountModal{{ $account->id }}">
                        Edit
                    </button>

                    <!-- Delete Button -->
                    <form
                        action="{{ route('deleteSumberDana', $account->id) }}"
                        method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editPaymentAccountModal{{ $account->id }}" tabindex="-1" role="dialog" aria-labelledby="editPaymentAccountModalLabel{{ $account->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPaymentAccountModalLabel{{ $account->id }}">Edit Payment Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('updateSumberDana', $account->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="editPerusahaanDropdown{{ $account->id }}">Perusahaan:</label>
                                    <select
                                        id="editPerusahaanDropdown{{ $account->id }}"
                                        name="id_perusahaan"
                                        class="form-control @error('id_perusahaan') is-invalid @enderror"
                                        required>
                                        @foreach ($perusahaanList as $perusahaan)
                                            <option
                                                value="{{ $perusahaan->id }}"
                                                {{ $account->id_perusahaan == $perusahaan->id ? 'selected' : '' }}>
                                                {{ $perusahaan->nama_perusahaan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="editAccountName{{ $account->id }}">Account Name:</label>
                                    <input
                                        type="text"
                                        id="editAccountName{{ $account->id }}"
                                        name="accountname"
                                        class="form-control"
                                        value="{{ $account->accountname }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="editAccountNumber{{ $account->id }}">Account Number:</label>
                                    <input
                                        type="text"
                                        id="editAccountNumber{{ $account->id }}"
                                        name="no_rekening"
                                        class="form-control"
                                        value="{{ $account->no_rekening }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="editSaldo{{ $account->id }}">Balance:</label>
                                    <input
                                        type="number"
                                        id="editSaldo{{ $account->id }}"
                                        name="saldo"
                                        class="form-control"
                                        value="{{ $account->saldo }}"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Account</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <tr>
                <td colspan="6" class="text-center">No payment accounts available.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Add Modal -->
<div class="modal fade" id="addPaymentAccountModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentAccountModalLabel">Add Payment Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('addSumberDana') }}">
                    @csrf
                    <div class="form-group">
                        <label for="perusahaanDropdown">Perusahaan:</label>
                        <select
                            id="perusahaanDropdown"
                            name="id_perusahaan"
                            class="form-control @error('id_perusahaan') is-invalid @enderror"
                            required>
                            <option value="" selected disabled>Pilih Perusahaan</option>
                            @foreach ($perusahaanList as $perusahaan)
                                <option value="{{ $perusahaan->id }}">{{ $perusahaan->nama_perusahaan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="accountName">Account Name:</label>
                        <input
                            type="text"
                            id="accountName"
                            name="accountname"
                            class="form-control"
                            placeholder="Enter account name"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="accountNumber">Account Number:</label>
                        <input
                            type="text"
                            id="accountNumber"
                            name="no_rekening"
                            class="form-control"
                            placeholder="Enter account number"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="saldo">Balance:</label>
                        <input
                            type="number"
                            id="saldo"
                            name="saldo"
                            class="form-control"
                            step="0.01"
                            placeholder="Enter balance"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Account</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
