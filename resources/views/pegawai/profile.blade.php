@extends('html.html')

@section('content')

    @include('components.navbar')

    @include('components.sidebar')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route(Auth::user()->roles.'.dashboard.page') }}">Home</a></li>
                    <li class="breadcrumb-item active text-capitalize">
                        {{ ucwords(str_replace('/', ' / ', Request::path())) }}
                    </li>
                </ol>
            </nav>
        </div>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="{{ $dataProfile->pegawai->foto ? asset('storage/'.$dataProfile->pegawai->foto) : asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                            <h2 class="text-capitalize">{{ $dataProfile->pegawai->nama }}</h2>
                            <h3 class="text-capitalize">{{ $dataProfile->roles }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Ringkasan</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ubah Kata Sandi</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Profile Details</h5>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Nama</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->pegawai->nama }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->email }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Alamat</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->pegawai->alamat }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">No Telepon</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->pegawai->no_telepon }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Tanggal Lahir</div>
                                        <div class="col-lg-9 col-md-8">{{ \Carbon\Carbon::parse($dataProfile->pegawai->tanggal_lahir)->translatedFormat('d F Y') }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Jenis Kelamin</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->pegawai->gender }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Tanggal Bergabung</div>
                                        <div class="col-lg-9 col-md-8">{{ \Carbon\Carbon::parse($dataProfile->pegawai->tanggal_masuk)->translatedFormat('d F Y') }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Tempat Bekerja</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->pegawai->tempatBekerja->nama_tempat_bekerja }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Jabatan</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->pegawai->jabatan->nama_jabatan }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Golongan</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->pegawai->golongan->nama_golongan }}</div>
                                    </div>
                                </div>
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <!-- Profile Edit Form -->
                                    <form action="{{ route('pegawai.profile.update')}}" method="POST" enctype="multipart/form-data">
                                        @csrf @method('put')
                                        <div class="row mb-3">
                                            <label for="fotoProfil" class="col-md-4 col-lg-3 col-form-label">Foto Profile</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="foto" type="file" class="form-control mt-2 @error('foto') is-invalid @enderror">
                                                @error('foto')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="nama_bisnis" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama',$dataProfile->pegawai->nama) }}" required>
                                                @error('nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="hidden" name="old_email" value="{{ $dataProfile->email }}">
                                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$dataProfile->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat',$dataProfile->pegawai->alamat) }}</textarea>
                                                @error('alamat')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="no_telepon" class="col-md-4 col-lg-3 col-form-label">No Telepon</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="no_telepon" type="text" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon',$dataProfile->pegawai->no_telepon) }}" required>
                                                @error('no_telepon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="tanggal_lahir" class="col-md-4 col-lg-3 col-form-label">Tanggal Lahir</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir',$dataProfile->pegawai->tanggal_lahir) }}" required>
                                                @error('tanggal_lahir')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="gender" class="col-md-4 col-lg-3 col-form-label">Gender</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                                    <option value="pria" @if ($dataProfile->pegawai->gender == 'pria') selected @endif>pria</option>
                                                    <option value="wanita"@if ($dataProfile->pegawai->gender == 'wanita') selected @endif>wanita</option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-main">Simpan Perubahan</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->
                                </div>
                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form action="{{ route('password.update') }}" method="post">
                                        @csrf @method('put')
                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Kata Sandi Sekarang</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password_lama" type="password" class="form-control @error('password_lama') is-invalid @enderror" value="{{ old('password_lama') }}" required>
                                                @error('password_lama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Kata Sandi</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password_baru" type="password" class="form-control @error('password_baru') is-invalid @enderror" value="{{ old('password_baru') }}" required>
                                                @error('password_baru')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Ulangi Kata Sandi Baru</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="konf_password" type="password" class="form-control @error('konf_password') is-invalid @enderror" value="{{ old('konf_password') }}" required>
                                                @error('konf_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-main">Ubah Kata Sandi</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>
                            </div><!-- End Bordered Tabs -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    @include('components.footer')
@endsection
