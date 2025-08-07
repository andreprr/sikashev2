@extends('layouts/contentNavbarLayout')

@section('title', 'Profil Saya')

@section('content')
<style>
    .hidden {
        display: none;
    }
</style>

<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Profil Saya</h4>
            </div>
        </div>
    </div>
</div>

<form enctype="multipart/form-data" action="{{ route('profile-update') }}" method="POST">
    @csrf
    <div class="card w-100 position-relative overflow-hidden">
        <div class="card-header bg-primary text-white">Informasi Akun</div>
        <div class="card-body">
            @if ($success = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $success }}
            </div>
            @endif
            @if ($erorr = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ $erorr }}
            </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-lg-3 col-xl-3 mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input name="name" id="name" value="{{ old('name', $result->name ?? NULL) }}" class="@error('name') is-invalid @enderror form-control" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-12 col-lg-3 col-xl-3 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input name="username" id="username" value="{{ old('username', $result->username ?? NULL) }}" class="@error('username') is-invalid @enderror form-control" disabled>
                    @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-12 col-lg-3 col-xl-3 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror form-control">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12 col-lg-3 col-xl-3 mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="@error('confirm_password') is-invalid @enderror form-control">
                    @error('confirm_password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-3 col-xl-3 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $result->email ?? NULL) }}" class="@error('email') is-invalid @enderror form-control" disabled>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-12 col-lg-3 col-xl-3 mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="@error('role') is-invalid @enderror form-control" disabled>
                        <option value="">{{ $result->roles->pluck('name')->implode(',') }}</option>
                    </select>
                    @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-12 col-lg-3 col-xl-3 mb-3">
                    <label for="phone" class="form-label">Telepon</label>
                    <input name="phone" value="{{ old('phone', isset($result->profile) ? $result->profile->phone ?? NULL : NULL) }}" class="form-control">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-3 mb-3">
                    <label for="img_url" class="form-label">Foto Profil</label>
                    <input class="form-control @error('img_url') is-invalid @enderror" type="file" id="img_url" name="img_url" accept="image/*">
                    @php
                    $img_url = $result->profile->img_url ?? NULL;
                    if($img_url){
                        echo "<div class='d-flex align-items-center mt-3'><img src='". (filter_var($img_url, FILTER_VALIDATE_URL) ? $img_url : route('getimage',$result->profile->img_url))."' class='rounded-circle' width='40' height='40'></div>";
                    }
                    @endphp
                    @error('img_url')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="card w-100 position-relative overflow-hidden">
        <div class="card-header bg-primary text-white">Informasi Profil</div>
        <div class="card-body">
            <div class="row">
                <div class="col mb-3 hidden" id="nik_field">
                    <label for="nik" class="form-label">NIK</label>
                    <input name="nik" value="{{ old('nik', isset($result->profile) ? $result->profile->nik ?? NULL : NULL) }}" class="form-control">
                    @error('nik') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3" id="birth_date_field">
                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', isset($result->profile) ? $result->profile->birth_date ?? NULL : NULL) }}" class="form-control">
                    @error('birth_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3" id="gender_field">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender1" value="Laki-laki" {{ old('gender', isset($result->profile) ? $result->profile->gender ?? '' : '') == 'Laki-laki' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gender1">
                            Laki-laki
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender2" value="Perempuan" {{ old('gender', isset($result->profile) ? $result->profile->gender ?? '' : '') == 'Perempuan' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gender2">
                            Perempuan
                        </label>
                    </div>
                </div>
                <div class="col mb-3">
                    <label for="nip" class="form-label">NIP/NIS/KTA/KTP/NIM</label>
                    <input name="nip" id="nip" value="{{ old('nip', $result->profile->nip  ?? NULL) }}" class="@error('nip') is-invalid @enderror form-control" required>
                    @error('nip') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea name="address" id="address" class="form-control" rows="3">{{ old('address', isset($result->profile) ? $result->profile->address ?? NULL : NULL) }}</textarea>
                </div>


            </div>
            
            <div class="row">
                <div class="col mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection