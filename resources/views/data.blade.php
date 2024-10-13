<div class="container-fluid py-4" style="margin-top: 60px;">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <!-- Kolom kiri: Peta -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Peta Lokasi</h6>
                        </div>
                        <br>
                        <div class="card-body px-0 pt-0 pb-2" style="height: 800px;">
                            <div id="map" style="height: 100%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Kolom kanan: Tabel -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Data Alamat PKL</h6>
                        </div>

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
                                        <button class="btn btn-primary btn-sm"
                                            onclick="showRoute([parseFloat('{{ $data->latitude }}'), parseFloat('{{ $data->longitude }}')])">
                                            Lihat Rute
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan dependency Bootstrap jika belum -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    // Inisialisasi peta dan variabel untuk rute dan marker
    let map, currentRoute, markers = [];

    document.addEventListener("DOMContentLoaded", function() {
        map = L.map('map').setView([1.1234363, 104.0156848], 13);

        // Tambahkan layer peta dasar
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
    });

    function showRoute(end) {
        // Hapus rute lama jika ada
        if (currentRoute) {
            map.removeLayer(currentRoute);
            currentRoute = null;
        }

        // Hapus marker lama
        markers.forEach(marker => map.removeLayer(marker));
        markers = [];

        // Ambil lokasi saat ini menggunakan API Geolocation
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