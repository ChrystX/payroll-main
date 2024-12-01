@extends('layouts.main')
@section('title', 'Admin Management')

@section('content')

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Admin Registration Button -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addAdminModal">
        Register New Admin
    </button>

    <!-- Admin Data Table -->
    <h4>Admin List</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Company</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($admins as $admin)
                <tr>
                    <td>{{ $admin->username }}</td>
                    <td>{{ $admin->role }}</td>
                    <td>{{ $admin->perusahaan->nama_perusahaan ?? 'Admin Bank' }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editAdminModal{{ $admin->id }}">
                            Edit
                        </button>

                        <!-- Delete Button -->
                        <form action="{{ route('deleteAdmin', $admin->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this admin?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editAdminModal{{ $admin->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editAdminModalLabel{{ $admin->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editAdminModalLabel{{ $admin->id }}">Edit Admin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('updateAdmin', $admin->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="editUsername{{ $admin->id }}">Username:</label>
                                        <input type="text" id="editUsername{{ $admin->id }}" name="username"
                                            class="form-control" value="{{ old('username', $admin->username) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editRole{{ $admin->id }}">Role:</label>
                                        <select id="editRole{{ $admin->id }}" name="role" class="form-control"
                                            {{ $admin->role == 'Admin Bank' ? 'disabled' : '' }} required>
                                            <option value="Super Admin"
                                                {{ $admin->role == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="Admin Bank"
                                                {{ $admin->role == 'Admin Bank' ? 'selected' : '' }}>Admin Bank</option>
                                            <option value="Admin Payroll"
                                                {{ $admin->role == 'Admin Payroll' ? 'selected' : '' }}>Admin Payroll
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editCompany{{ $admin->id }}">Company:</label>
                                        <select id="editCompany{{ $admin->id }}" name="id_perusahaan"
                                            class="form-control" {{ $admin->role == 'Admin Bank' ? 'disabled' : '' }}
                                            required>
                                            <option value="" selected disabled>Select Company</option>
                                            @foreach ($perusahaan as $company)
                                                <option value="{{ $company->id }}"
                                                    {{ $admin->id_perusahaan == $company->id ? 'selected' : '' }}>
                                                    {{ $company->nama_perusahaan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Password Change Section -->
                                    <div class="form-group">
                                        <label for="editPassword">New Password:</label>
                                        <input type="password" id="editPassword" name="password" class="form-control"
                                            placeholder="Leave blank if you don't want to change the password">
                                    </div>
                                    <div class="form-group">
                                        <label for="editPasswordConfirmation">Confirm New Password:</label>
                                        <input type="password" id="editPasswordConfirmation" name="password_confirmation"
                                            class="form-control" placeholder="Confirm the new password">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Admin</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <tr>
                    <td colspan="5" class="text-center">No admin data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Add Modal -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel">Register New Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('addAdmin') }}">
                        @csrf
                        <div class="form-group">
                            <label for="addUsername">Username:</label>
                            <input type="text" id="addUsername" name="username" class="form-control"
                                placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label for="addPassword">Password:</label>
                            <input type="password" id="addPassword" name="password" class="form-control"
                                placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="addPasswordConfirmation">Confirm Password:</label>
                            <input type="password" id="addPasswordConfirmation" name="password_confirmation"
                                class="form-control" placeholder="Confirm Password" required>
                        </div>
                        <div class="form-group">
                            <label for="addRole">Role:</label>
                            <select id="addRole" name="role" class="form-control" required>
                                <option value="Super Admin">Super Admin</option>
                                <option value="Admin Payroll">Admin Payroll</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addCompany">Company:</label>
                            <select id="addCompany" name="id_perusahaan" class="form-control" required>
                                <option value="" selected disabled>Select Company</option>
                                @foreach ($perusahaan as $company)
                                    <option value="{{ $company->id }}">{{ $company->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Register Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
