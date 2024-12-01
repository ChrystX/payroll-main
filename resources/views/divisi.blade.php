@extends('layouts.main')
@section('title', 'Divisi Management')

@section('content')

<!-- Button to trigger registration modal -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addDivisiModal">
    Register New Divisi
</button>

<!-- Success Message -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Divisi Data Table -->
<h4>Divisi List</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nama Divisi</th>
            <th>Perusahaan</th>
            <th>Gaji Pokok</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($divisi as $data)
            <tr>
                <td>{{ $data->nama_divisi }}</td>
                <td>{{ $data->perusahaan->nama_perusahaan }}</td>
                <td>{{ number_format($data->gaji_pokok, 2) }}</td>
                <td>
                    <!-- Edit Button -->
                    <button
                        type="button"
                        class="btn btn-warning btn-sm"
                        data-toggle="modal"
                        data-target="#editDivisiModal{{ $data->id }}">
                        Edit
                    </button>

                    <!-- Delete Button -->
                    <form action="{{ route('deleteDivisi', $data->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editDivisiModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="editDivisiModalLabel{{ $data->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDivisiModalLabel{{ $data->id }}">Edit Divisi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('updateDivisi', $data->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="editNamaDivisi{{ $data->id }}">Nama Divisi:</label>
                                    <input
                                        type="text"
                                        id="editNamaDivisi{{ $data->id }}"
                                        name="nama_divisi"
                                        class="form-control @error('nama_divisi') is-invalid @enderror"
                                        value="{{ old('nama_divisi', $data->nama_divisi) }}"
                                        required
                                    >
                                    @error('nama_divisi')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editPerusahaanDropdown{{ $data->id }}">Perusahaan:</label>
                                    <select
                                        id="editPerusahaanDropdown{{ $data->id }}"
                                        name="id_perusahaan"
                                        class="form-control @error('id_perusahaan') is-invalid @enderror"
                                        required
                                    >
                                        @foreach ($perusahaan as $p)
                                            <option value="{{ $p->id }}" {{ $data->id_perusahaan == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama_perusahaan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_perusahaan')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="editGajiPokok{{ $data->id }}">Gaji Pokok:</label>
                                    <input
                                        type="number"
                                        id="editGajiPokok{{ $data->id }}"
                                        name="gaji_pokok"
                                        class="form-control @error('gaji_pokok') is-invalid @enderror"
                                        value="{{ old('gaji_pokok', $data->gaji_pokok) }}"
                                        required
                                    >
                                    @error('gaji_pokok')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Update Divisi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <tr>
                <td colspan="4" class="text-center">No divisi data available.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Add Modal -->
<div class="modal fade" id="addDivisiModal" tabindex="-1" role="dialog" aria-labelledby="addDivisiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDivisiModalLabel">Register New Divisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('addDivisi') }}">
                    @csrf
                    <div class="form-group">
                        <label for="namaDivisi">Nama Divisi:</label>
                        <input
                            type="text"
                            id="namaDivisi"
                            name="nama_divisi"
                            class="form-control @error('nama_divisi') is-invalid @enderror"
                            placeholder="Nama Divisi"
                            value="{{ old('nama_divisi') }}"
                            required
                        >
                        @error('nama_divisi')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="perusahaanDropdown">Perusahaan:</label>
                        <select
                            id="perusahaanDropdown"
                            name="id_perusahaan"
                            class="form-control @error('id_perusahaan') is-invalid @enderror"
                            required
                        >
                            <option value="" selected disabled>Pilih Perusahaan</option>
                            @foreach ($perusahaan as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_perusahaan }}</option>
                            @endforeach
                        </select>
                        @error('id_perusahaan')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gajiPokok">Gaji Pokok:</label>
                        <input
                            type="number"
                            id="gajiPokok"
                            name="gaji_pokok"
                            class="form-control @error('gaji_pokok') is-invalid @enderror"
                            placeholder="Gaji Pokok"
                            value="{{ old('gaji_pokok') }}"
                            required
                        >
                        @error('gaji_pokok')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Register Divisi</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
