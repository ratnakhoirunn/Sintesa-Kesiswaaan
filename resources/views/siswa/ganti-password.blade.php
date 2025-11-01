<h3>Ganti Password</h3>

@if(session('success'))
<p style="color:green;">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('siswa.password.update') }}">
    @csrf

    <label>Password Lama</label>
    <input type="password" name="password_lama" required><br><br>

    <label>Password Baru</label>
    <input type="password" name="password_baru" required><br><br>

    <label>Konfirmasi Password Baru</label>
    <input type="password" name="password_baru_confirmation" required><br><br>

    <button type="submit">Update Password</button>

    @error('password_lama')<p style="color:red">{{ $message }}</p>@enderror
</form>
