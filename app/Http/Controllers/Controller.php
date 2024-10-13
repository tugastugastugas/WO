<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use App\Models\M_PKL;
use App\Models\Lokasi;
use App\Models\Lokasi_backup;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dashboard()
    {
        echo view('header');
        echo view('menu');
        echo view('dashboard');
        echo view('footer');
    }

    public function login()
    {
        echo view('login');
    }

    public function aksi_login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'backup_captcha' => 'required_if:backup_captcha,!=,null',
        ]);

        Log::info('Login attempt', $request->all());
        Log::info('Session ID: ' . session_id());
        Log::info('Session values: ' . json_encode(session()->all())); // Cek semua session

        if ($request->filled('backup_captcha')) {
            $sessionCaptcha = Session::get('captcha');
            // Menggunakan facade Session

            Log::info('User backup captcha input: ' . $request->backup_captcha);
            Log::info('Session captcha value: ' . $sessionCaptcha);

            if ($request->backup_captcha !== $sessionCaptcha) {
                Log::warning('Invalid CAPTCHA input by user: ' . $request->backup_captcha);
                return back()->withErrors(['backup_captcha' => 'Invalid CAPTCHA'])->withInput();
            }
        }

        $user = User::where('username', $request->username)->first();

        if ($user) {
            Log::info('User found: ' . $user->username);
        } else {
            Log::warning('User not found for username: ' . $request->username);
        }

        if ($user && md5($request->password, $user->password)) {
            Session::put('id', $user->id_user);
            Session::put('level', $user->level);
            Log::info('Login successful for user: ' . $user->username);
            return redirect()->route('dashboard')->with('success', 'Login successful');
        } else {
            Log::warning('Login failed for username: ' . $request->username);
            return back()->withErrors(['loginError' => 'Invalid username or password'])->withInput();
        }
    }




    // Method untuk logout
    public function logout()
    {
        Session::flush(); // Hapus semua session
        return redirect()->route('login')->with('success', 'Logout successful');
    }

    public function data()
    {
        $lokasi = Lokasi::all();
        echo view('header');
        echo view('menu');
        echo view('data', compact('lokasi'));
        echo view('footer');
    }



    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'kolom1' => 'required',
            'kolom2' => 'required',
        ]);

        // Simpan data ke tabel quiz
        $quiz = new M_PKL();
        $quiz->kolom1 = $request->input('kolom1');
        $quiz->kolom2 = $request->input('kolom2');
        $quiz->save();

        // Redirect ke halaman lain
        return redirect()->route('quiz');
    }
    public function quiz()
    {
        $quizzes = M_PKL::all();
        echo view('header');
        echo view('menu');
        echo view('quiz', compact('quizzes'));
        echo view('footer');
    }

    public function SimpanLokasi(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required',
        ]);

        // Ambil id_user dari session
        $id_user = session('id');

        // Cek apakah data lokasi untuk user tersebut sudah ada
        $location = Lokasi::where('id_user', $id_user)->first();

        if ($location) {
            // Backup data lama sebelum diupdate ke tabel lokasi_backup
            DB::table('lokasi_backup')->insert([
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'address' => $location->address,
                'id_user' => $location->id_user,
                'created_at' => $location->created_at,
                'updated_at' => $location->updated_at,
            ]);

            // Jika sudah ada, lakukan update
            $location->latitude = $request->input('latitude');
            $location->longitude = $request->input('longitude');
            $location->address = $request->input('address');
            $location->save();

            // Redirect ke halaman lain dengan pesan sukses edit
            return redirect()->route('input_alamat')->with('success', 'Data lokasi berhasil diperbarui');
        } else {
            // Jika belum ada, lakukan penyimpanan baru
            $location = new Lokasi();
            $location->latitude = $request->input('latitude');
            $location->longitude = $request->input('longitude');
            $location->address = $request->input('address');
            $location->id_user = $id_user;
            $location->save();

            // Redirect ke halaman lain dengan pesan sukses tambah
            return redirect()->route('input_alamat')->with('success', 'Data lokasi berhasil disimpan');
        }
    }




    public function input_alamat()
    {
        $id_user = session('id'); // Ambil id user dari session
        $lokasi = Lokasi::where('id_user', $id_user)->get(); // Filter lokasi berdasarkan id_user
        echo view('header');
        echo view('menu');
        echo view('input_alamat', compact('lokasi'));
        echo view('footer');
    }

    public function destroy($id)
    {
        // Cari data lokasi berdasarkan ID
        $lokasi = Lokasi::findOrFail($id);

        // Hapus data lokasi
        $lokasi->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('input_alamat')->with('success', 'Data lokasi berhasil dihapus');
    }

    public function register()
    {

        echo view('register');
        echo view('footer');
    }



    public function tambah_akun(Request $request)
    {
        try {
            // Validasi inputan
            $request->validate([
                'username' => 'required',
                'password' => 'required',
                'nis' => 'required',
                'kelas' => 'required',
                'jurusan' => 'required',
                // 'level' => 'required', // Hapus validasi untuk level karena tidak akan diisi oleh pengguna
            ]);

            // Simpan data ke tabel user
            $user = new User(); // Ubah variabel dari $quiz menjadi $user untuk kejelasan
            $user->username = $request->input('username');
            $user->password = md5($request->input('password')); // Enkripsi password
            $user->nis = $request->input('nis');
            $user->kelas = $request->input('kelas');
            $user->jurusan = $request->input('jurusan');
            $user->level = 'Murid'; // Tetapkan level ke "Murid"

            // Simpan ke database
            $user->save();

            // Redirect ke halaman lain
            return redirect()->route('login')->with('success', 'Akun berhasil ditambahkan.'); // Menambahkan flash message untuk feedback
        } catch (\Exception $e) {
            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan akun. Silakan coba lagi.']);
        }
    }


    public function user()
    {
        $user = User::all();
        echo view('header');
        echo view('menu');
        echo view('User', compact('user'));
        echo view('footer');
    }

    public function t_user(Request $request)
    {
        try {
            // Validasi inputan
            $request->validate([
                'username' => 'required',
                'password' => 'required',
                'level' => 'required',
            ]);

            // Simpan data ke tabel user
            $user = new User(); // Ubah variabel dari $quiz menjadi $user untuk kejelasan
            $user->username = $request->input('username');
            $user->password = md5($request->input('password')); // Enkripsi password
            $user->level = $request->input('level');

            // Simpan ke database
            $user->save();

            // Redirect ke halaman lain
            return redirect()->back()->withErrors(['msg' => 'Berhasil Menambahkan Akun.']);
        } catch (\Exception $e) {
            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan akun. Silakan coba lagi.']);
        }
    }

    public function t_murid(Request $request)
    {
        try {
            // Validasi inputan
            $request->validate([
                'username' => 'required',
                'password' => 'required',
                'nis' => 'required',
                'kelas' => 'required',
                'jurusan' => 'required',
                // 'level' => 'required', // Hapus validasi untuk level karena tidak akan diisi oleh pengguna
            ]);

            // Simpan data ke tabel user
            $user = new User(); // Ubah variabel dari $quiz menjadi $user untuk kejelasan
            $user->username = $request->input('username');
            $user->password = md5($request->input('password')); // Enkripsi password
            $user->nis = $request->input('nis');
            $user->kelas = $request->input('kelas');
            $user->jurusan = $request->input('jurusan');
            $user->level = 'Murid'; // Tetapkan level ke "Murid"

            // Simpan ke database
            $user->save();

            // Redirect ke halaman lain
            return redirect()->back()->withErrors(['msg' => 'Berhasil Menambahkan Akun.']);
        } catch (\Exception $e) {
            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan akun. Silakan coba lagi.']);
        }
    }

    public function user_destroy($id)
    {
        // Cari data user berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus data user (soft delete)
        $user->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('user')->with('success', 'Data user berhasil dihapus');
    }


    public function resetPassword($id)
    {
        try {
            // Mencari pengguna berdasarkan ID
            $user = User::findOrFail($id);

            // Mengatur ulang password ke '1'
            $user->password = md5('1'); // Enkripsi password

            // Simpan perubahan ke database
            $user->save();

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Password berhasil direset menjadi 1.');
        } catch (\Exception $e) {
            // Log kesalahan
            Log::error('Gagal mereset password: ' . $e->getMessage());

            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal mereset password. Silakan coba lagi.']);
        }
    }

    public function detail($id)
    {
        // Mencari pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Mendapatkan daftar level (jika diperlukan)
        $levels = ['Murid', 'Guru', 'Kajur', 'Kepala Sekolah']; // Ubah sesuai kebutuhan Anda

        // Mengembalikan view dengan data pengguna dan level
        echo view('header');
        echo view('menu');
        echo view('detail', compact('user', 'levels'));
        echo view('footer');
    }

    public function updateDetail(Request $request)
    {
        try {
            // Validasi inputan
            $request->validate([
                'username' => 'required',
                'level' => 'required',
                // Validasi lain sesuai kebutuhan
            ]);

            // Mencari pengguna berdasarkan ID
            $user = User::findOrFail($request->input('id'));

            // Memperbarui data pengguna
            $user->username = $request->input('username');
            $user->level = $request->input('level');

            // Jika pengguna adalah Murid, perbarui NIS, Kelas, dan Jurusan
            if ($user->level === 'Murid') {
                $user->nis = $request->input('nis');
                $user->kelas = $request->input('kelas');
                $user->jurusan = $request->input('jurusan');
            }

            // Simpan perubahan ke database
            $user->save();

            // Redirect dengan pesan sukses
            return redirect()->route('detail', $user->id_user)->with('success', 'Detail pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log kesalahan
            Log::error('Gagal memperbarui detail pengguna: ' . $e->getMessage());

            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui detail pengguna. Silakan coba lagi.']);
        }
    }


    public function restore_e()
    {
        $lokasi = Lokasi_backup::all();

        // Mengembalikan view dengan data pengguna dan level
        echo view('header');
        echo view('menu');
        echo view('restore_e', compact('lokasi'));
        echo view('footer');
    }

    public function lokasi_backup_destroy($id)
    {
        // Cari data lokasi berdasarkan ID
        $lokasi = Lokasi_backup::findOrFail($id);

        // Hapus data lokasi
        $lokasi->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('restore_e')->with('success', 'Data lokasi berhasil dihapus');
    }

    public function restore($id)
    {
        // Cari data di tabel lokasi_backup berdasarkan ID
        $backup = Lokasi_backup::findOrFail($id);

        // Cek apakah sudah ada data di tabel lokasi untuk user ini
        $existingLocation = Lokasi::where('id_user', $backup->id_user)->first();

        if ($existingLocation) {
            // Jika ada, update data yang ada
            $existingLocation->latitude = $backup->latitude;
            $existingLocation->longitude = $backup->longitude;
            $existingLocation->address = $backup->address;
            $existingLocation->save();
        } else {
            // Jika tidak ada, buat data baru
            Lokasi::create([
                'latitude' => $backup->latitude,
                'longitude' => $backup->longitude,
                'address' => $backup->address,
                'id_user' => $backup->id_user,
                'created_at' => $backup->created_at,
                'updated_at' => $backup->updated_at,
            ]);
        }

        // Redirect ke halaman input_alamat dengan pesan sukses
        return redirect()->route('input_alamat')->with('success', 'Data berhasil di-restore');
    }

    public function restore_d()
    {
        $trashedUsers = User::onlyTrashed()->get(); // Ambil semua user yang dihapus

        // Mengembalikan view dengan data pengguna dan level
        echo view('header');
        echo view('menu');
        echo view('restore_d', compact('trashedUsers'));
        echo view('footer');
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore(); // Kembalikan user

        return redirect()->route('user')->with('success', 'Data user berhasil dikembalikan');
    }
}
