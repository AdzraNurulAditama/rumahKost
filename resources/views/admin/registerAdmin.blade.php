@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex items-center justify-center">

<div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-md">

<div class="text-center mb-6">
<h1 class="text-3xl font-bold">
<span class="text-blue-700">Rumah</span><span class="text-orange-500">Kost</span>
</h1>
<p class="text-blue-600 font-semibold mt-1">Register Admin</p>
</div>

<form action="{{ route('admin.register.process') }}" method="POST" class="space-y-4">
@csrf

<div>
<label class="block text-sm font-medium mb-1">Username</label>
<input type="text" name="username"
class="w-full border rounded-xl px-4 py-2">
</div>

<div>
<label class="block text-sm font-medium mb-1">Email</label>
<input type="email" name="email"
class="w-full border rounded-xl px-4 py-2">
</div>

<div>
<label class="block text-sm font-medium mb-1">Role</label>
<select name="role"
class="w-full border rounded-xl px-4 py-2">
<option value="owner_kost">Owner Kost</option>
<option value="admin">Admin</option>
</select>
</div>

<div>
<label class="block text-sm font-medium mb-1">Password</label>
<input type="password" name="password"
class="w-full border rounded-xl px-4 py-2">
</div>

<div>
<label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
<input type="password" name="password_confirmation"
class="w-full border rounded-xl px-4 py-2">
</div>

<button type="submit"
class="w-full bg-blue-700 text-white py-2 rounded-xl">
Daftar
</button>

</form>

<p class="text-center mt-4 text-sm">
Sudah punya akun?
<a href="{{ route('admin.login') }}" class="text-blue-600 font-semibold">Login</a>
</p>

</div>
</div>
@endsection