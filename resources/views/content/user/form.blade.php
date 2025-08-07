@extends('layouts/contentNavbarLayout')

@section('title', 'Users')

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
                <h4 class="fw-semibold mb-8">{{ $page }} User</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html">Index</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">{{ $page }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<form enctype="multipart/form-data" action="{{ $page == 'Edit' ? route('user-update',$result->id) : route('user-store') }}" method="POST">
    @csrf
    @if($page == 'Edit')
    @method('PUT')
    @endif
    <div class="card w-100 position-relative overflow-hidden">
        <div class="card-header bg-primary text-white">Informasi Akun</div>
        <div class="card-body">
            @if ($success = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $success }}
            </div>
            @endif
            <div class="row">
                <div class="col mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input name="name" id="name" value="{{ old('name', $result->name ?? NULL) }}" class="@error('name') is-invalid @enderror form-control" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input name="username" id="username" value="{{ old('username', $result->username ?? NULL) }}" class="@error('username') is-invalid @enderror form-control">
                    @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror form-control">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                    <input type="confirm_password" name="confirm_password" id="confirm_password" class="@error('confirm_password') is-invalid @enderror form-control">
                    @error('confirm_password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $result->email ?? NULL) }}" class="@error('email') is-invalid @enderror form-control">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="@error('role') is-invalid @enderror form-control" required>
                        <option value="">Pilih Role ...</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ $role->name == (isset($result) ? $result->roles->first()->name : '') ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3  hidden" id="opd_field">
                    <label for="user_opd" class="form-label">Perangkat Daerah</label>
                    <select name="user_opd" id="user_opd" class="@error('user_opd') is-invalid @enderror form-control">
                        <option value="" >Pilih OPD</option>
                        @foreach ($opds as $row)
                            <option value="{{ $row->id }}" {{ old('user_opd', $result->opd->opd_id ?? NULL) == $row->id ? 'selected' : NULL }}>{{ $row->name }}</option>
                        @endforeach
                    </select>
                    @error('user_opd') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3">
                    <label for="phone" class="form-label">Telepon</label>
                    <input name="phone" value="{{ old('phone', isset($result->profile) ? $result->profile->phone ?? NULL : NULL) }}" class="form-control">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-3 mb-3">
                    <label for="img_url" class="form-label">Foto Profil</label>
                    <input class="form-control @error('img_url') is-invalid @enderror" type="file" id="img_url" name="img_url" accept="image/*">
                    @php
                    $img_url = $result->profile->img_url ?? NULL;
                    if($img_url){
                        echo "<div class='d-flex align-items-center mt-3'><img src='".(filter_var($img_url, FILTER_VALIDATE_URL) ? $img_url : route('getimage',$result->profile->img_url))."' class='rounded-circle' width='40' height='40'></div>";
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
                <div class="col mb-" id="nik_field">
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
            </div>

            <div class="row">
                <div class="col mb-3  hidden" id="business_name_field">
                    <label for="business_name" class="form-label">Nama Usaha</label>
                    <input name="business_name" value="{{ old('business_name', isset($result->profile) ? $result->profile->business_name ?? NULL : NULL) }}" class="form-control">
                    @error('business_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3  hidden" id ="business_owner_field">
                    <label for="business_owner" class="form-label">Nama Pemilik Usaha</label>
                    <input name="business_owner" value="{{ old('business_owner', isset($result->profile) ? $result->profile->business_owner ?? NULL : NULL) }}" class="form-control">
                    @error('business_owner') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col mb-3  hidden" id="business_range_field">
                    <label for="business_range" class="form-label">Skala/Fase Wirausaha</label>
                    <select name="business_range" id="business_range" class="@error('business_range') is-invalid @enderror form-control">
                        <option value="" {{ old('business_range', $result->profile->business_range ?? NULL) == '' ? 'selected' : NULL }}>Pilih</option>
                        <option value="mikro" {{ old('business_range', $result->profile->business_range ?? NULL) == 'mikro' ? 'selected' : NULL }}>Mikro</option>
                        <option value="kecil" {{ old('business_range', $result->profile->business_range ?? NULL) == 'kecil' ? 'selected' : NULL }}>Kecil</option>
                        <option value="menengah" {{ old('business_range', $result->profile->business_range ?? NULL) == 'menengah' ? 'selected' : NULL }}>Menengah</option>
                        <option value="besar" {{ old('business_range', $result->profile->business_range ?? NULL) == 'besar' ? 'selected' : NULL }}>Besar</option>
                    </select>
                    @error('business_range') <span class="text-danger">{{ $message }}</span> @enderror
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
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const userTypeSelect = document.getElementById('role');

            const opd = document.getElementById('opd_field');
            // Function to handle visibility
            function handleUserTypeChange() {
                if (userTypeSelect.value === 'opd') {
                    opd.classList.remove('hidden');
                }else{
                    opd.classList.add('hidden');
                }
            }

            // Add event listener for change event
            userTypeSelect.addEventListener('change', handleUserTypeChange);

            // Initial call to set visibility based on the default selected option
            handleUserTypeChange();
        });
</script>
@endsection
