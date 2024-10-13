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
                                <button class="btn btn-primary btn-sm"
                                    onclick="showRoute([parseFloat('{{ $data->latitude }}'), parseFloat('{{ $data->longitude }}')])">
                                    Lihat Rute
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('lokasi.destroy', $data->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <br>

                <div class=" card-body px-0 pt-0 pb-2">
                    <div class="button-container">
                        <input type="text" id="addressInput" class="form-control" placeholder="Masukkan alamat atau koordinat">
                        <div id="autocomplete-list" class="autocomplete-list"></div>
                    </div>
                    <br>
                    <div style="height: 800px;">
                        <div id="map" style="height: 100%;"></div>
                    </div>
                    <br>
                    <form id="locationForm" method="POST" style="display:none;" action="{{ route('input.lokasi') }}">
                        @csrf
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" name="address" id="address">
                        <button type="submit" class="btn btn-dark btn-sm w-100 mb-3">Simpan Lokasi</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Inisialisasi peta
    const map = L.map('map').setView([1.12343630, 104.01568480], 13);

    // Tambahkan layer tile ke peta
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Variabel untuk menyimpan marker
    let currentMarker = null;

    // Fungsi untuk menambahkan atau memindahkan pin ke peta


    // Fungsi untuk menambahkan atau memindahkan pin ke peta
    // Fungsi untuk menambahkan atau memindahkan pin ke peta
    function addMarker(lat, lon, address) {
        if (currentMarker) {
            map.removeLayer(currentMarker); // Hapus marker lama jika ada
        }

        currentMarker = L.marker([lat, lon]).addTo(map)
            .bindPopup('Lokasi: ' + address)
            .openPopup();

        // Simpan data ke dalam form
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lon;
        document.getElementById('address').value = address;

        // Tampilkan form simpan lokasi
        document.getElementById('locationForm').style.display = 'block';

        // // Kirim form setelah marker ditambahkan
        // document.getElementById('locationForm').submit();
    }

    // Event listener untuk klik pada peta
    map.on('click', function(e) {
        fetch(`https://api.opencagedata.com/geocode/v1/json?q=${e.latlng.lat}+${e.latlng.lng}&key=94f61fd952d9498a8d7fd7a3858e7599`)
            .then(response => response.json())
            .then(data => {
                if (data.results.length > 0) {
                    const address = data.results[0].formatted;
                    addMarker(e.latlng.lat, e.latlng.lng, address);
                }
            });
    });



    // Fungsi untuk menangani input dan menampilkan hasil pencarian
    function onAddressInput() {
        const address = document.getElementById('addressInput').value;
        if (address) {
            fetch(`https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(address)}&key=94f61fd952d9498a8d7fd7a3858e7599`)
                .then(response => response.json())
                .then(data => {
                    const autocompleteList = document.getElementById('autocomplete-list');
                    autocompleteList.innerHTML = '';
                    if (data.results.length > 0) {
                        data.results.forEach((result, index) => {
                            const itemDiv = document.createElement('div');
                            itemDiv.innerHTML = result.formatted;
                            itemDiv.addEventListener('click', () => {
                                const lat = result.geometry.lat;
                                const lon = result.geometry.lng;
                                const address = result.formatted;
                                addMarker(lat, lon, address);
                                autocompleteList.innerHTML = ''; // Hapus daftar autocomplete
                                document.getElementById('addressInput').value = address; // Tampilkan alamat yang dipilih di input
                            });
                            autocompleteList.appendChild(itemDiv);
                        });
                    } else {
                        autocompleteList.innerHTML = '<div>Alamat tidak ditemukan</div>';
                    }
                });
        }
    }

    // Event listener untuk input alamat
    document.getElementById('addressInput').addEventListener('input', onAddressInput);

    // Event listener untuk klik pada peta
    map.on('click', function(e) {
        fetch(`https://api.opencagedata.com/geocode/v1/json?q=${e.latlng.lat}+${e.latlng.lng}&key=94f61fd952d9498a8d7fd7a3858e7599`)
            .then(response => response.json())
            .then(data => {
                if (data.results.length > 0) {
                    const address = data.results[0].formatted;
                    addMarker(e.latlng.lat, e.latlng.lng, address);
                }
            });
    });



    // Tambahkan layer peta dasar
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Variabel untuk menyimpan rute dan marker
    let currentRoute = null;
    let markers = [];

    function showRoute(end) {
        // Hapus rute lama jika ada
        if (currentRoute) {
            map.removeLayer(currentRoute);
            currentRoute = null; // Reset currentRoute
        }

        // Hapus marker lama
        markers.forEach(marker => map.removeLayer(marker));
        markers = []; // Reset markers array

        // Mengambil lokasi saat ini menggunakan API Geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const start = [position.coords.latitude, position.coords.longitude];

                fetch(`https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf62480062fe5146374bd49a918004793249ce&start=${start[1]},${start[0]}&end=${end[1]},${end[0]}`)
                    .then(response => response.json())
                    .then(data => {
                        const routeCoordinates = data.features[0].geometry.coordinates;

                        // Buat rute baru dan tambahkan ke peta
                        currentRoute = L.polyline(routeCoordinates.map(coord => [coord[1], coord[0]]), {
                            color: 'blue'
                        }).addTo(map);
                        map.fitBounds(currentRoute.getBounds());

                        // Tambahkan marker di lokasi awal dan akhir
                        const startMarker = L.marker([start[0], start[1]]).addTo(map).bindPopup('Start').openPopup();
                        const endMarker = L.marker([end[0], end[1]]).addTo(map).bindPopup('End').openPopup();

                        // Simpan marker di array untuk dihapus nantinya
                        markers.push(startMarker, endMarker);
                    })
                    .catch(error => console.error('Error:', error));
            }, function(error) {
                console.error('Error getting location:', error);
                alert('Tidak dapat mengambil lokasi Anda. Pastikan fitur lokasi aktif.');
            });
        } else {
            alert('Geolocation tidak didukung oleh browser ini.');
        }
    }
</script>