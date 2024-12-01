@extends('layouts.main')

@section('title', 'Manage Worker Data')

@section('content')
<!-- Button to trigger add worker modal -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addWorkerModal">
    Add New Worker
</button>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Table for Worker Data -->
<h4>Worker Data</h4>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Division</th>
                <th>Bank Name</th>
                <th>Bank Account</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pekerja as $worker)
                <tr>
                    <td>{{ $worker->id }}</td>
                    <td>{{ $worker->nama_pekerja }}</td>
                    <td>{{ $worker->divisi->nama_divisi ?? 'N/A' }}</td>
                    <td>{{ $worker->nama_bank }}</td>
                    <td>{{ $worker->rekening_pekerja }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button
                            type="button"
                            class="btn btn-sm btn-warning me-2"
                            data-toggle="modal"
                            data-target="#editWorkerModal{{ $worker->id }}">
                            Edit
                        </button>
                        <!-- Delete Button -->
                        <form action="{{ route('deletePekerja', $worker->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Worker Modal -->
                <div class="modal fade" id="editWorkerModal{{ $worker->id }}" tabindex="-1" aria-labelledby="editWorkerLabel{{ $worker->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editWorkerLabel{{ $worker->id }}">Edit Worker</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('updatePekerja', $worker->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="editWorkerName{{ $worker->id }}">Name</label>
                                        <input
                                            type="text"
                                            id="editWorkerName{{ $worker->id }}"
                                            name="nama_pekerja"
                                            class="form-control"
                                            value="{{ old('nama_pekerja', $worker->nama_pekerja) }}"
                                            required
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="editWorkerDivisi{{ $worker->id }}">Division</label>
                                        <select id="editWorkerDivisi{{ $worker->id }}" name="id_divisi" class="form-control" required>
                                            @foreach ($divisi as $d)
                                                <option value="{{ $d->id }}" {{ $d->id == $worker->id_divisi ? 'selected' : '' }}>
                                                    {{ $d->nama_divisi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editWorkerBank{{ $worker->id }}">Bank Name</label>
                                        <select id="editWorkerBank{{ $worker->id }}" name="nama_bank" class="form-control">
                                            <option value="Bank A" {{ $worker->nama_bank === 'Bank A' ? 'selected' : '' }}>Bank A</option>
                                            <option value="Bank B" {{ $worker->nama_bank === 'Bank B' ? 'selected' : '' }}>Bank B</option>
                                            <option value="Bank C" {{ $worker->nama_bank === 'Bank C' ? 'selected' : '' }}>Bank C</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editWorkerAccount{{ $worker->id }}">Bank Account</label>
                                        <input
                                            type="text"
                                            id="editWorkerAccount{{ $worker->id }}"
                                            name="rekening_pekerja"
                                            class="form-control"
                                            value="{{ old('rekening_pekerja', $worker->rekening_pekerja) }}"
                                            required
                                        >
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No workers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Worker Modal -->
<div class="modal fade" id="addWorkerModal" tabindex="-1" aria-labelledby="addWorkerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWorkerLabel">Add New Worker</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('addPekerja') }}">
                    @csrf
                    <div class="form-group">
                        <label for="addWorkerName">Name</label>
                        <input
                            type="text"
                            id="addWorkerName"
                            name="nama_pekerja"
                            class="form-control"
                            placeholder="Worker Name"
                            required
                        >
                    </div>
                    <div class="form-group">
                        <label for="addWorkerDivisi">Division</label>
                        <select id="addWorkerDivisi" name="id_divisi" class="form-control" required>
                            <option value="" selected disabled>Select Division</option>
                            @foreach ($divisi as $d)
                                <option value="{{ $d->id }}">{{ $d->nama_divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="addWorkerBank">Bank Name</label>
                        <select id="addWorkerBank" name="nama_bank" class="form-control">
                            <option value="Bank A">Bank A</option>
                            <option value="Bank B">Bank B</option>
                            <option value="Bank C">Bank C</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="addWorkerAccount">Bank Account</label>
                        <input
                            type="text"
                            id="addWorkerAccount"
                            name="rekening_pekerja"
                            class="form-control"
                            placeholder="Bank Account Number"
                            required
                        >
                    </div>
                    <button type="submit" class="btn btn-primary">Add Worker</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
