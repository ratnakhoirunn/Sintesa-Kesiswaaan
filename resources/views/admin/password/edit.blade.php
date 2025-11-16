@extends('layouts.admin')

@section('title','Ubah Password')
@section('page_title','Ubah Password')

@section('content')
<style>
.password-container {
    max-width: 500px;
    margin: 40px auto;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    padding: 25px 30px;
    font-family: 'Poppins', sans-serif;
}
.password-container h3 {
    color: #1e3a8a;
    text-align: center;
    font-weight: 600;
    margin-bottom: 25px;
}
.password-container label {
    font-weight: 600;
    color: #374151;
}
.password-container input {
    width: 100%;
    padding: 10px 40px 10px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 15px;
    margin-top: 6px;
    margin-bottom: 16px;
    outline: none;
    transition: 0.3s;
    box-sizing: border-box;
}
.password-container input:focus {
    border-color: #1e3a8a;
    box-shadow: 0 0 5px rgba(30,58,138,0.3);
}
.password-toggle {
    position: relative;
}
.password-toggle i {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6b7280;
}
.btn-primary {
    background-color: #1e3a8a;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    width: 100%;
    transition: 0.3s;
}
.btn-primary:hover {
    background-color: #3b82f6;
}
.alert {
    background: #fee2e2;
    border: 1px solid #f87171;
    color: #b91c1c;
    padding: 8px;
    border-radius: 6px;
    margin-bottom: 15px;
}

/* TOAST SUCCESS */
.toast-success {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #22c55e;
    color: white;
    padding: 14px 22px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    font-weight: 600;
    z-index: 9999;
    opacity: 0;
    animation: fadeInOut 3s ease forwards;
}
@keyframes fadeInOut {
    0% { opacity: 0; transform: translateX(20px); }
    10% { opacity: 1; transform: translateX(0); }
    90% { opacity: 1; }
    100% { opacity: 0; transform: translateX(20px); }
}
</style>

<div class="password-container">
    <h3>Ubah Password - {{ $user->nama ?? $user->nama_lengkap }}</h3>

    {{-- Error --}}
    @if ($errors->any())
        <div class="alert">{{ $errors->first() }}</div>
    @endif

    {{-- SUCCESS (untuk JS) --}}
    @if (session('success'))
        <div id="toastSuccess" class="toast-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.password.update', [$type, $user->getKey()]) }}">
        @csrf

        <label>Password Baru</label>
        <div class="password-toggle">
            <input type="password" name="password" id="password">
            <i class="fa fa-eye" onclick="togglePassword('password', this)"></i>
        </div>

        <label>Konfirmasi Password</label>
        <div class="password-toggle">
            <input type="password" name="password_confirmation" id="password_confirmation">
            <i class="fa fa-eye" onclick="togglePassword('password_confirmation', this)"></i>
        </div>

        <button class="btn-primary">Simpan</button>
    </form>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

@endsection
