<div class="card mb-4" style="padding: 20px;">
    <div class=" card-header pb-0">
        <h6>Input Alamat PKL</h6>
    </div>
    <br>
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Lokasi</th>
                <th>Persetujuan</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($lokasi as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->latitude }}</td>
                <td>{{ $data->longitude }}</td>
                <td>{{ $data->address }}</td>
                <td>
                    <!-- Tombol Lihat Rute -->
                    <form action="{{ route('lokasi_backup.restore', $data->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-primary btn-sm" type="submit" onclick="return confirm('Apakah Anda yakin ingin merestore data ini?')">Restore</button>
                    </form>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('lokasi_backup.destroy', $data->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>