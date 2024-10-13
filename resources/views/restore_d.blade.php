<div class="container-fluid py-4" style="margin-top: 60px;">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4" style="padding: 20px;">
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
                        @foreach($trashedUsers as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->username }}</td>
                            <td>{{ $data->level }}</td>

                            <td>
                                <form action="{{ route('restoreUser', $data->id_user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Restore</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('user.destroy', $data->id_user) }}" method="POST" style="display:inline;">
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
        </div>
    </div>
</div>