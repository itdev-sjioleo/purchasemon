@extends('layout')

@section('title', 'Manajemen User')

@section('styles')
    <style>
        body {
            font-size: .9rem;
        }
        table {
            font-size: .85rem;
        }
        .action-btns .btn {
            margin-right: 4px;
        }
    </style>
@endsection

@section('content')
    <div class="card" style="max-width: 1400px; margin: 0 auto;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold mb-0">Daftar Pengguna</h3>
            <div class="card-tools ml-auto">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-create-user">
                    <i class="fas fa-user-plus mr-1"></i> Tambah User
                </button>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table id="table-users" class="table table-bordered table-striped" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Dibuat Pada</th>
                        <th style="width: 220px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $u)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $u->name }}</strong>
                                @if($u->username === 'admin')
                                    <span class="badge badge-success ml-1">Admin</span>
                                @endif
                            </td>
                            <td><code>{{ $u->username }}</code></td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->created_at ? $u->created_at->format('d/m/Y H:i') : '-' }}</td>
                            <td class="text-center action-btns">
                                <button type="button" 
                                    class="btn btn-warning btn-sm btn-edit" 
                                    title="Edit Profil"
                                    data-id="{{ $u->id }}"
                                    data-name="{{ $u->name }}"
                                    data-username="{{ $u->username }}"
                                    data-email="{{ $u->email }}"
                                    data-url="{{ route('users.update', $u->id) }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <button type="button" 
                                    class="btn btn-info btn-sm btn-reset-password" 
                                    title="Reset Password"
                                    data-id="{{ $u->id }}"
                                    data-username="{{ $u->username }}"
                                    data-url="{{ route('users.reset-password', $u->id) }}">
                                    <i class="fas fa-key"></i> Reset
                                </button>

                                @if($u->username !== 'admin' && auth()->id() !== $u->id)
                                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" title="Hapus User" data-username="{{ $u->username }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="modal-create-user" tabindex="-1" role="dialog" aria-labelledby="modalCreateUserLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="modalCreateUserLabel">
                            <i class="fas fa-user-plus mr-1"></i> Tambah User Baru
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create_name">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="create_name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="create_username">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="create_username" name="username" value="{{ old('username') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="create_email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="create_email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="create_password">Password (Minimal 6 karakter) <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="create_password" name="password" minlength="6" required>
                        </div>
                        <div class="form-group">
                            <label for="create_password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="create_password_confirmation" name="password_confirmation" minlength="6" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog" aria-labelledby="modalEditUserLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form-edit-user" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="modalEditUserLabel">
                            <i class="fas fa-edit mr-1"></i> Edit User
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_username">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Reset Password -->
    <div class="modal fade" id="modal-reset-password" tabindex="-1" role="dialog" aria-labelledby="modalResetPasswordLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form-reset-password" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="modalResetPasswordLabel">
                            <i class="fas fa-key mr-1"></i> Reset Password User
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Reset password untuk user: <strong id="reset_user_label" class="text-primary"></strong></p>
                        <div class="form-group">
                            <label for="reset_new_password">Password Baru (Minimal 6 karakter) <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="reset_new_password" name="password" minlength="6" required>
                        </div>
                        <div class="form-group">
                            <label for="reset_new_password_confirmation">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="reset_new_password_confirmation" name="password_confirmation" minlength="6" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Simpan Password Baru</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#table-users').DataTable({
                pageLength: 25,
                responsive: true,
                order: [[1, 'asc']]
            });

            // Handle klik tombol Edit
            $('.btn-edit').on('click', function() {
                const name = $(this).data('name');
                const username = $(this).data('username');
                const email = $(this).data('email');
                const url = $(this).data('url');

                $('#edit_name').val(name);
                $('#edit_username').val(username);
                $('#edit_email').val(email);
                $('#form-edit-user').attr('action', url);

                $('#modal-edit-user').modal('show');
            });

            // Handle klik tombol Reset Password
            $('.btn-reset-password').on('click', function() {
                const username = $(this).data('username');
                const url = $(this).data('url');

                $('#reset_user_label').text(username);
                $('#reset_new_password').val('');
                $('#reset_new_password_confirmation').val('');
                $('#form-reset-password').attr('action', url);

                $('#modal-reset-password').modal('show');
            });

            // Handle konfirmasi Hapus User
            $('.btn-delete').on('click', function() {
                const username = $(this).data('username');
                const form = $(this).closest('form');

                if (confirm('Apakah Anda yakin ingin menghapus user "' + username + '"?')) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
