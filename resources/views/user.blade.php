<div class="container-fluid py-4" style="margin-top: 60px;">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4" style="padding: 20px;">
                <div class="col-6">
                    <button class="btn bg-gradient-dark mb-0" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add New User
                    </button>
                    <button class="btn bg-gradient-dark mb-0" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                        <i class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Murid
                    </button>
                </div>
                <br>
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->username }}</td>
                            <td>{{ $data->level }}</td>

                            <td>
                                <a href="{{ route('detail', $data->id_user) }}">
                                    <button class="btn btn-danger">
                                        <i class="now-ui-icons ui-1_check"></i> Detail
                                    </button>
                                </a>
                                <form action="{{ route('user.destroy', $data->id_user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            <td>
                            <td>
                                <form action="{{ route('user.resetPassword', $data->id_user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Apakah Anda yakin ingin mereset password ke 1?')">Reset Password</button>
                                </form>
                            </td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk Menambah Pengguna -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('t_user') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <select class="form-select" id="level" name="level" required>
                            <option value="Murid">Murid</option>
                            <option value="Guru">Guru</option>
                            <option value="Kajur">Kajur</option>
                            <option value="Kepala Sekolah">Kepala Sekolah</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk Menambah Murid -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Tambah Murid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('t_murid') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="murid_kelas" class="form-label">Nis</label>
                        <input type="text" class="form-control" id="murid_kelas" name="nis" required>
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" required>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="jurusan" name="jurusan" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>