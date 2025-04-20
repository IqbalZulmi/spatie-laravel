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

                        <!-- siswa Card -->
                        <div class="col-md-4">
                            <div class="card info-card sales-card ">
                                <div class="card-body">
                                    <h5 class="card-title">Total Siswa</h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>145</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <!-- tendik Card -->
                        <div class="col-md-4">
                            <div class="card info-card sales-card ">
                                <div class="card-body">
                                    <h5 class="card-title">Tenaga Pendidik</h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-badge"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>145</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <!-- pengurus Card -->
                        <div class="col-md-4">
                            <div class="card info-card sales-card ">
                                <div class="card-body">
                                    <h5 class="card-title">Total Pengurus</h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-check"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>145</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <div class="col-12" id="kelola-admin">
                            <div class="card recent-sales overflow-auto">
                                <div class="card-body">
                                    <h5 class="card-title">Persetujuan Cuti</h5>
                                    <table class="table table-striped table-hover border table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Tipe</th>
                                                <th scope="col">Durasi</th>
                                                <th scope="col">status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>2025-04-01</td>
                                                <td>Andi Saputra</td>
                                                <td>Cuti Tahunan</td>
                                                <td>2025-04-05 - 2025-04-07</td>
                                                <td><span class="badge bg-success">Disetujui</span></td>
                                            </tr>
                                            <tr>
                                                <td>2025-04-02</td>
                                                <td>Budi Santoso</td>
                                                <td>Sakit</td>
                                                <td>2025-04-03 - 2025-04-04</td>
                                                <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                                            </tr>
                                            <tr>
                                                <td>2025-04-03</td>
                                                <td>Citra Lestari</td>
                                                <td>Cuti Hamil</td>
                                                <td>2025-04-10 - 2025-07-08</td>
                                                <td><span class="badge bg-danger">Ditolak</span></td>
                                            </tr>
                                            <tr>
                                                <td>2025-04-04</td>
                                                <td>Dewi Anggraini</td>
                                                <td>Cuti Tahunan</td>
                                                <td>2025-04-08 - 2025-04-12</td>
                                                <td><span class="badge bg-success">Disetujui</span></td>
                                            </tr>
                                            <tr>
                                                <td>2025-04-05</td>
                                                <td>Eko Prasetyo</td>
                                                <td>Sakit</td>
                                                <td>2025-04-06 - 2025-04-06</td>
                                                <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                                            </tr>
                                            <tr>
                                                <td>2025-04-06</td>
                                                <td>Fajar Hidayat</td>
                                                <td>Cuti Hamil</td>
                                                <td>2025-04-15 - 2025-07-14</td>
                                                <td><span class="badge bg-success">Disetujui</span></td>
                                            </tr>
                                            <tr>
                                                <td>2025-04-07</td>
                                                <td>Gita Sari</td>
                                                <td>Cuti Tahunan</td>
                                                <td>2025-04-09 - 2025-04-15</td>
                                                <td><span class="badge bg-danger">Ditolak</span></td>
                                            </tr>
                                            <tr>
                                                <td>2025-04-08</td>
                                                <td>Hadi Wijaya</td>
                                                <td>Sakit</td>
                                                <td>2025-04-09 - 2025-04-10</td>
                                                <td><span class="badge bg-success">Disetujui</span></td>
                                            </tr>
                                            <tr>
                                                <td>2025-04-09</td>
                                                <td>Indra Kusuma</td>
                                                <td>Cuti Hamil</td>
                                                <td>2025-04-20 - 2025-07-19</td>
                                                <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                                            </tr>
                                            <tr>
                                                <td>2025-04-10</td>
                                                <td>Joko Widodo</td>
                                                <td>Cuti Tahunan</td>
                                                <td>2025-04-12 - 2025-04-16</td>
                                                <td><span class="badge bg-success">Disetujui</span></td>
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
                </div><!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-lg-4">

                    <div id="calendar"></div>

                </div><!-- End Right side columns -->
            </div>
        </section>

    </main><!-- End #main -->

    @include('components.footer')
@endsection
