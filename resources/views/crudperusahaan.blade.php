@extends('layouts.main')
@section('title', 'Perusahaan Management')

@section('content')

<!-- Button to trigger registration modal -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#registerModal">
    Register New Perusahaan
</button>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Perusahaan Data Table -->
<h4>Perusahaan List</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nama Perusahaan</th>
            <th>Alamat</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Dynamic perusahaan data -->
        @forelse ($perusahaan as $data)
            <tr>
                <td>{{ $data->nama_perusahaan }}</td>
                <td>{{ $data->alamat }}</td>
                <td>
                    <!-- Edit Button -->
                    <button
                        type="button"
                        class="btn btn-warning btn-sm"
                        data-toggle="modal"
                        data-target="#editModal{{ $data->id }}">
                        Edit
                    </button>

                    <!-- Delete Button -->
                    <form action="{{ route('deletePerusahaan', $data->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $data->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $data->id }}">Edit Perusahaan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('updatePerusahaan', $data->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="editNamaPerusahaan{{ $data->id }}">Nama Perusahaan:</label>
                                    <input
                                        type="text"
                                        id="editNamaPerusahaan{{ $data->id }}"
                                        name="nama_perusahaan"
                                        class="form-control @error('nama_perusahaan') is-invalid @enderror"
                                        value="{{ old('nama_perusahaan', $data->nama_perusahaan) }}"
                                        required
                                    >
                                    @error('nama_perusahaan')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editAlamatPerusahaan{{ $data->id }}">Alamat:</label>
                                    <input
                                        type="text"
                                        id="editAlamatPerusahaan{{ $data->id }}"
                                        name="alamat"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        value="{{ old('alamat', $data->alamat) }}"
                                        required
                                    >
                                    @error('alamat')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Update Perusahaan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <tr>
                <td colspan="3" class="text-center">No perusahaan data available.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register New Perusahaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('addPerusahaan') }}">
                    @csrf
                    <div class="form-group">
                        <label for="namaPerusahaan">Nama Perusahaan:</label>
                        <input
                            type="text"
                            id="namaPerusahaan"
                            name="nama_perusahaan"
                            class="form-control @error('nama_perusahaan') is-invalid @enderror"
                            placeholder="Nama Perusahaan"
                            value="{{ old('nama_perusahaan') }}"
                            required
                        >
                        @error('nama_perusahaan')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="alamatPerusahaan">Alamat:</label>
                        <input
                            type="text"
                            id="alamatPerusahaan"
                            name="alamat"
                            class="form-control @error('alamat') is-invalid @enderror"
                            placeholder="Alamat"
                            value="{{ old('alamat') }}"
                            required
                        >
                        @error('alamat')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Register Perusahaan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
