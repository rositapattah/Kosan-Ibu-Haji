{{-- resources/views/profile/edit.blade.php --}}
@extends('templates.user')

@section('title', 'Profil Penghuni')

@section('content')
<div class="space-y-6">
    {{-- Judul halaman --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Pengaturan Profil</h2>
        <p class="text-sm text-gray-500">Kelola informasi akun, keamanan, dan penghapusan akun Anda.</p>
    </div>

    {{-- Update Profile Information --}}
    <div class="card">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Informasi Profil</h3>
            <p class="text-sm text-gray-500">Perbarui nama, email, dan informasi dasar akun Anda.</p>
        </div>
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- Update Password --}}
    <div class="card">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Ubah Password</h3>
            <p class="text-sm text-gray-500">Pastikan akun Anda menggunakan password yang kuat.</p>
        </div>
        @include('profile.partials.update-password-form')
    </div>

    {{-- Delete User --}}
    <div class="card border border-red-100">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-red-600">Hapus Akun</h3>
            <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan. Semua data akan dihapus secara permanen.</p>
        </div>
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection