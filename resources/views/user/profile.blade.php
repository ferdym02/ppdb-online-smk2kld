@extends('user.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white">User Profile</div>
            
                <div class="card-body text-center">
                    <!-- Alert Sukses -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
            
                    <!-- Alert Error -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
            
                    <!-- Foto Calon Siswa -->
                    @if($pendaftar && $pendaftar->foto_calon_siswa)
                        <img src="{{ asset('storage/' . $pendaftar->foto_calon_siswa) }}" 
                            class="img-thumbnail mb-3" 
                            alt="User Profile Picture" 
                            width="150" height="150">
                    @endif

                    
                    <!-- NISN dan Asal Sekolah -->
                    <div class="d-flex justify-content-center">
                        <table style="border-collapse: collapse;">
                            <tr style="border-bottom: 1px solid #ddd;">
                                <th style="text-align: left; padding-right: 10px; padding-bottom: 8px;">Nama</th>
                                <td style="text-align: left; padding-bottom: 8px;">: {{ $user->name }}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <th style="text-align: left; padding-right: 10px; padding-bottom: 8px;">Email</th>
                                <td style="text-align: left; padding-bottom: 8px;">: {{ $user->email }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tombol Edit Password -->
                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editPasswordModal">
                        Edit Password
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Edit Password -->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPasswordModalLabel">Edit Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.update.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
