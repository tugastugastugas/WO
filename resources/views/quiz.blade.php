<div class="container-fluid py-4" style="margin-top: 60px;">
    <div class="row">
        <div class="col-12">
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzes as $quiz)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $quiz->kolom1 }}</td>
                            <td>{{ $quiz->kolom2 }}</td>
                            <td>
                                <a href="">
                                    <button class="btn btn-primary btn-sm">Lihat Rute</button>
                                </a>
                                <a href="" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <br>

                <div class=" card-body px-0 pt-0 pb-2">

                    <form method="POST" action="{{ route('quiz.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">kolom1</label>
                            <input type="text" class="form-control" id="kolom1" name="kolom1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">kolom2</label>
                            <input type="text" class="form-control" id="kolom2" name="kolom2">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>