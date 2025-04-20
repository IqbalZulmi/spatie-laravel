@extends('html.html')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/styles/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/styles/layout.css">
    <style>
        .status-container {
            display: flex;
            align-items: center;
            gap: 15px;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .status {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .status-box {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }
        .approved { background-color: #22bb33; } /* Biru */
        .rejected { background-color: #bb2124; }  /* Merah */
        .pending  { background-color: #f0ad4e; }  /* Oranye */
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro/index.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const { Calendar } = window.VanillaCalendarPro;

            const options = {
                selectedTheme: 'light' // Pastikan tema cocok dengan yang di-load di <head>
            };

            const calendar = new Calendar('#calendar', options);
            calendar.init();
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.table').DataTable({
                info: false,
                dom: '<"row"<"col-sm-6 d-flex justify-content-center justify-content-sm-start mb-2 mb-sm-0"l><"col-sm-6 d-flex justify-content-center justify-content-sm-end"f>>rt<"row"<"col-sm-6 mt-0"i><"col-sm-6 mt-2"p>>'
            });
        });
    </script>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Izin', 'Sakit', 'Tanpa Keterangan', 'Cuti Singkat'],
                datasets: [{
                    axis: 'y',
                    label: 'My First Dataset',
                    data: [65, 59, 80, 81],
                    fill: false,
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
            }
        });
    </script>

@endpush


@section('content')
    @include('components.navbar')

    @include('components.sidebar')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1 class="text-capitalize">Selamat Datang, {{ Auth::user()->roles }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route(Auth::user()->roles.'.dashboard.page') }}">Home</a></li>
                    <li class="breadcrumb-item active text-capitalize">
                        {{ ucwords(str_replace('/', ' / ', Request::path())) }}
                    </li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="row">
                        <div class="card bg-second text-light">
                            <div class="row">
                                <div class="col-4 col-md-2">
                                    <img src="{{ Auth::user()->pegawai->foto ? asset('storage/'.Auth::user()->pegawai->foto) : asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle my-2" >
                                </div>
                                <div class="col-8 col-md-10 my-2">
                                    <div class="row m-2">
                                        <div class="col-lg-3 col-md-4 label fw-semibold">Nama</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->nama }}</div>
                                    </div>
                                    <div class="row m-2">
                                        <div class="col-lg-3 col-md-4 label fw-semibold">Jabatan</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->jabatan->nama_jabatan }}</div>
                                    </div>
                                    <div class="row m-2">
                                        <div class="col-lg-3 col-md-4 label fw-semibold">Alamat</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->alamat }}</div>
                                    </div>
                                    <div class="row m-2">
                                        <div class="col-lg-3 col-md-4 label fw-semibold">Email</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->user->email }}</div>
                                    </div>
                                    <div class="row m-2">
                                        <div class="col-lg-3 col-md-4 label fw-semibold">Nomor Telepon</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->no_telepon }}</div>
                                    </div>
                                    <div class="row m-2">
                                        <div class="col-lg-3 col-md-4 label fw-semibold">Tahun Masuk</div>
                                        <div class="col-lg-9 col-md-8">{{ \Carbon\Carbon::parse($dataProfile->tanggal_masuk)->translatedFormat('F Y') }}
                                        </div>
                                    </div>
                                    <div class="row m-2">
                                        <div class="col-lg-3 col-md-4 label fw-semibold">Tahun Pengabdian</div>
                                        <div class="col-lg-9 col-md-8">{{ $tahunPengabdian. ' Tahun' }} {{ $bulanPengabdian. ' Bulan' }}</div>
                                    </div>
                                    <div class="row m-2">
                                        <div class="col-lg-3 col-md-4 label fw-semibold">Tahun Kelahiran</div>
                                        <div class="col-lg-9 col-md-8">{{ \Carbon\Carbon::parse($dataProfile->tanggal_lahir)->translatedFormat('d F Y') }}</div>
                                    </div>
                                    <div class="row m-2">
                                        <div class="col-lg-3 col-md-4 label fw-semibold">Golongan</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->golongan->nama_golongan }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-lg-4">
                    <div id="calendar"></div>
                </div><!-- End Right side columns -->

                {{-- Horizontal chart --}}
                <div class="col-lg-6 mt-3 mt-lg-0">
                    <div class="card p-3">
                        <h5 class="card-title">Kehadiran</h5>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>

                {{-- table --}}
                <div class="col-lg-6">
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Persetujuan Cuti</h5>
                                <table class="table table-striped table-hover border table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Tipe</th>
                                            <th scope="col">Durasi</th>
                                            <th scope="col">status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2025-04-01</td>
                                            <td>Cuti Tahunan</td>
                                            <td>2025-04-05 - 2025-04-07</td>
                                            <td><span class="badge bg-success">Disetujui</span></td>
                                        </tr>
                                        <tr>
                                            <td>2025-04-02</td>
                                            <td>Sakit</td>
                                            <td>2025-04-03 - 2025-04-04</td>
                                            <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                                        </tr>
                                        <tr>
                                            <td>2025-04-03</td>
                                            <td>Cuti Hamil</td>
                                            <td>2025-04-10 - 2025-07-08</td>
                                            <td><span class="badge bg-danger">Ditolak</span></td>
                                        </tr>
                                        <tr>
                                            <td>2025-04-04</td>
                                            <td>Cuti Tahunan</td>
                                            <td>2025-04-08 - 2025-04-12</td>
                                            <td><span class="badge bg-success">Disetujui</span></td>
                                        </tr>
                                        <tr>
                                            <td>2025-04-05</td>
                                            <td>Sakit</td>
                                            <td>2025-04-06 - 2025-04-06</td>
                                            <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="status-container">
                                    <div class="status">
                                        <div class="status-box approved"></div>
                                        <span>Disetujui</span>
                                    </div>
                                    <div class="status">
                                        <div class="status-box rejected"></div>
                                        <span>Ditolak</span>
                                    </div>
                                    <div class="status">
                                        <div class="status-box pending"></div>
                                        <span>Menunggu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    @include('components.footer')
@endsection
