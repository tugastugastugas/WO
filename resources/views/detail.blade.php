<div class="container-fluid py-4" style="margin-top: 60px;">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4" style="padding: 20px;">
                <h4 class="card-title">Detail User</h4>

                <form action="{{ route('update.user') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama User</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="username" value="{{ $user->username }}">
                    </div>

                    @if($user->level === 'Murid')
                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" value="{{ $user->nis }}">
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $user->kelas }}">
                    </div>
                    <div class="form-group">
                        <label for="jurusan">Jurusan</label>
                        <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ $user->jurusan }}">
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control" name="level">
                            <option value="{{ $user->level }}" selected>{{ $user->level }}</option>
                            @foreach ($levels as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="id" value="{{ $user->id_user }}">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>