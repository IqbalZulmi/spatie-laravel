@extends('html.html')

@push('css')
    <link href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/3.0.0/css/select.bootstrap5.css" rel="stylesheet">
    <style>
        /* Jika ingin warna teks tetap hitam, gunakan ini */
        .table.dataTable tbody tr.selected td {
            color: black !important;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/select/3.0.0/js/dataTables.select.js"></script>
    <script src="https://cdn.datatables.net/select/3.0.0/js/select.bootstrap5.js"></script>
    {{-- datatables --}}
    <script>
        $(document).ready(function () {
            // Mendeklarasikan dan menginisialisasi variabel table dengan DataTable
            var table = $('.table').DataTable({
                columnDefs: [
                    {
                        orderable: false,
                        render: DataTable.render.select(),
                        targets: 0
                    }
                ],
                order: [],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                info: true,
            });

            // Menangani klik pada tombol hapus
            $('#btnHapus').on('click', function () {
                // Mendapatkan data dari baris yang dipilih
                var selectedRows = table.rows({ selected: true }).data();

                // Mengecek apakah ada baris yang dipilih
                if (selectedRows.length === 0) {
                    Swal.fire({
                        text: 'Tidak ada data yang dipilih',
                        icon: 'warning',
                        confirmButtonText:'OK',
                        showCloseButton: true,
                        timer: 2000,
                    })
                } else {
                    // Mengambil ID dari baris yang dipilih
                    var selectedIds = [];
                    selectedRows.each(function (rowData) {
                        console.log(rowData);
                        selectedIds.push(rowData[0]); // ID pegawai ada di kolom pertama (index 0)
                    });

                    // Menyimpan ID yang dipilih ke input hidden dalam form
                    $('#hapusId').val(selectedIds.join(','));

                    // Menampilkan modal hapus
                    $('#hapusModal').modal('show');
                }
            });
    });

    </script>
    {{-- chart domisili --}}
    <script>
        const domisili = document.getElementById('domisili');

        new Chart(domisili, {
            type: 'doughnut',
            data: {
                labels: ['Red', 'Blue', 'Yellow'],
                datasets: [{
                    label: 'My First Dataset',
                    data: [300, 50, 100],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                aspectRatio: 2, // 1 artinya tinggi = lebar
            }
        });
    </script>
    {{-- chart golongan --}}
    <script>
        const golongan = document.getElementById('golongan');

        new Chart(golongan, {
            type: 'doughnut',
            data: {
                labels: ['Red', 'Blue', 'Yellow'],
                datasets: [{
                    label: 'My First Dataset',
                    data: [300, 50, 100],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                aspectRatio: 2, // 1 artinya tinggi = lebar
            }
        });
    </script>
@endpush


@section('content')
    @include('components.navbar')

    @include('components.sidebar')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1 class="text-capitalize">Kelola Pegawai</h1>
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
                <div class="col-12" id="kelola-admin">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Kelola Pegawai</h5>
                            <div class="d-flex flex-column flex-md-row justify-content-start mb-2">
                                <div class="me-md-2 mb-2">
                                    <button class="btn btn-main" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        <i class="bi bi-plus-circle-fill"></i> Tambah Baru
                                    </button>
                                </div>
                                <div class="me-md-2 mb-2">
                                    <button class="btn btn-danger" id="btnHapus">
                                        <i class="bi bi-trash"></i> Hapus Pilihan
                                    </button>
                                </div>
                            </div>
                            <table class="table table-striped table-hover border table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Jabatan</th>
                                        <th scope="col">Tanggal Masuk</th>
                                        <th scope="col">Tahun Pengabdian</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Gol.</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataPegawai as $index => $data )
                                        <tr>
                                            <td>{{ $data->id_user }}</td>
                                            <td>{{ $data->nama }}</td>
                                            <td>{{ $data->jabatan->nama_jabatan }}</td>
                                            <td>{{ $data->tanggal_masuk }}</td>
                                            @php
                                                $selisih = \Carbon\Carbon::parse($data->tanggal_masuk)->diff(\Carbon\Carbon::now());

                                                // Ambil tahun dan bulan
                                                $tahun = $selisih->y;
                                                $bulan = $selisih->m;
                                            @endphp
                                            <td>{{ $tahun }} tahun {{ $bulan }} bulan</td>
                                            <td>{{ $data->user->email }}</td>
                                            <td>{{ $data->golongan->nama_golongan }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn rounded-3" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $index+1 }}">
                                                                <i class="bi bi-pencil-square"></i> Edit Profil
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <i class="bi bi-calendar-check"></i> Absensi
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <i class="bi bi-cash-stack"></i> Penggajian
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card p-3">
                        <h5 class="card-title">Domisili Pegawai</h5>
                        <canvas id="domisili"></canvas>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card p-3">
                        <h5 class="card-title">Golongan Pegawai</h5>
                        <canvas id="golongan"></canvas>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    {{-- tambah modal --}}
    <div class="modal fade" id="tambahModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Pegawai</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.pegawai.store') }}" method="post" enctype="multipart/form-data">
                        @csrf @method('post')
                        <div class="container-fluid">
                            <div class="row gy-2">
                                <div class="col-12">
                                    <label for="">Email</label>
                                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="">Kata Sandi</label>
                                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="">Tempat Bekerja</label>
                                    <select name="id_tempat_bekerja" class="form-select" @error('id_tempat_bekerja') is-invalid @enderror>
                                        @forelse ($dataTempatBekerja as $index => $tempatBekerja )
                                            <option value="{{ $tempatBekerja->id }}" @if (Auth::user()->admin->id_tempat_bekerja == $tempatBekerja->id) selected @endif>{{ $tempatBekerja->nama_tempat_bekerja }}</option>
                                        @empty
                                            <option value="">Tidak ada data tempat bekerja yang ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('id_tempat_bekerja')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="">Jabatan</label>
                                    <select name="id_jabatan" class="form-select" @error('id_jabatan') is-invalid @enderror>
                                        @forelse ($dataJabatan as $index => $jabatan )
                                            <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                        @empty
                                            <option value="">Tidak ada data jabatan yang ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('id_jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="">Golongan</label>
                                    <select name="id_golongan" class="form-select" @error('id_golongan') is-invalid @enderror>
                                        @forelse ($dataGolongan as $index => $golongan )
                                            <option value="{{ $golongan->id }}">{{ $golongan->nama_golongan }}</option>
                                        @empty
                                            <option value="">Tidak ada data jabatan yang ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('id_golongan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="">Nama</label>
                                    <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="">Alamat</label>
                                    <textarea name="alamat" class="form-control" @error('alamat') is-invalid @enderror></textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="">No Telepon</label>
                                    <input name="no_telepon" type="text" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon') }}" required>
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="">Tanggal Lahir</label>
                                    <input name="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="">Tanggal Masuk</label>
                                    <input name="tanggal_masuk" type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk') }}" required>
                                    @error('tanggal_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="pria">pria</option>
                                        <option value="wanita">wanita</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="">Foto</label>
                                    <input name="foto" type="file" class="form-control @error('foto') is-invalid @enderror" value="{{ old('foto') }}">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-main">Simpan</button>
                    </form>
                </div>
        </div>
        </div>
    </div>

    {{-- hapus modal --}}
    <div class="modal fade" id="hapusModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Hapus Pegawai</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.pegawai.mass.delete') }}" method="post">
                        @csrf @method('delete')
                        <div class="container-fluid">
                            <input type="hidden" name="id" id="hapusId">
                            <h4 class="text-capitalize">
                                Apakah anda yakin ingin <span class="text-danger">menghapus data</span> yang dipilih ?</span>
                            </h4>
                        </div>
                    </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-main">Simpan</button>
                    </form>
                </div>
        </div>
        </div>
    </div>

    @foreach ($dataPegawai as $index => $data )
    {{-- edit modal --}}
        <div class="modal fade" id="editModal{{ $index+1 }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Pegawai</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.pegawai.update',['pegawai' => $data->id_user]) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('put')
                            <div class="container-fluid">
                                <div class="row gy-2">
                                    <input type="hidden" name="old_email" value="{{ $data->user->email }}">
                                    <div class="col-12">
                                        <label for="">Email</label>
                                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$data->user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="">Tempat Bekerja</label>
                                        <select name="id_tempat_bekerja" class="form-select" @error('id_tempat_bekerja') is-invalid @enderror>
                                            @forelse ($dataTempatBekerja as $index => $tempatBekerja )
                                                <option value="{{ $tempatBekerja->id }}" @if ($data->id_tempat_bekerja == $tempatBekerja->id) selected @endif>{{ $tempatBekerja->nama_tempat_bekerja }}</option>
                                            @empty
                                                <option value="">Tidak ada data tempat bekerja yang ditemukan</option>
                                            @endforelse
                                        </select>
                                        @error('id_tempat_bekerja')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="">Jabatan</label>
                                        <select name="id_jabatan" class="form-select" @error('id_jabatan') is-invalid @enderror>
                                            @forelse ($dataJabatan as $index => $jabatan )
                                                <option value="{{ $jabatan->id }}" @if ($data->id_jabatan == $jabatan->id) selected @endif>{{ $jabatan->nama_jabatan }}</option>
                                            @empty
                                                <option value="">Tidak ada data jabatan yang ditemukan</option>
                                            @endforelse
                                        </select>
                                        @error('id_jabatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="">Golongan</label>
                                        <select name="id_golongan" class="form-select" @error('id_golongan') is-invalid @enderror>
                                            @forelse ($dataGolongan as $index => $golongan )
                                                <option value="{{ $golongan->id }}" @if ($data->id_golongan == $golongan->id) selected @endif>{{ $golongan->nama_golongan }}</option>
                                            @empty
                                                <option value="">Tidak ada data jabatan yang ditemukan</option>
                                            @endforelse
                                        </select>
                                        @error('id_golongan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="">Kata Sandi</label>
                                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="">Nama</label>
                                        <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama',$data->nama) }}" required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="">Alamat</label>
                                        <textarea name="alamat" class="form-control" @error('alamat') is-invalid @enderror>{{ $data->alamat }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="">No Telepon</label>
                                        <input name="no_telepon" type="text" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon',$data->no_telepon) }}" required>
                                        @error('no_telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="">Tanggal Lahir</label>
                                        <input name="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir',$data->tanggal_lahir) }}" required>
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="">Gender</label>
                                        <select name="gender" class="form-select">
                                            <option value="pria"@if ($data->id == 'pria') selected @endif>pria</option>
                                            <option value="wanita"@if ($data->id =='wanita') selected @endif>wanita</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="">Foto</label>
                                        <input name="foto" type="file" class="form-control @error('foto') is-invalid @enderror" value="{{ old('foto',$data->foto) }}">
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="">Tanggal Masuk</label>
                                        <input name="tanggal_masuk" type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk',$data->tanggal_masuk) }}" required>
                                        @error('tanggal_masuk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-main">Simpan</button>
                        </form>
                    </div>
            </div>
            </div>
        </div>
    @endforeach

    @include('components.footer')
@endsection
