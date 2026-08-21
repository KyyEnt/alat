@extends('layouts.admin')

@section('title', 'Edit User - SiAlat')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&display=swap');

    .edit-user-container {
        max-width: 600px;
        margin: 32px auto;
        padding: 0 16px;
        font-family: 'IBM Plex Mono', monospace;
    }

    .form-card {
        background-color: #0f172a;
        border: 1px solid #1e293b;
        border-radius: 8px;
        padding: 28px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    }

    .form-title {
        font-size: 20px;
        color: #2dd4bf;
        margin-bottom: 24px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        color: #94a3b8;
        margin-bottom: 8px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        background-color: #020617;
        border: 1px solid #334155;
        border-radius: 6px;
        color: #f8fafc;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 13px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #14b8a6;
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.15);
    }

    .form-control.is-invalid {
        border-color: #f43f5e;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.15);
    }

    .error-text {
        color: #f43f5e;
        font-size: 11px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .help-text {
        color: #64748b;
        font-size: 11px;
        margin-top: 6px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 32px;
        padding-top: 16px;
        border-top: 1px solid #1e293b;
    }

    .btn {
        padding: 10px 20px;
        font-size: 13px;
        border-radius: 6px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-family: 'IBM Plex Mono', monospace;
        font-weight: 500;
        transition: background-color 0.2s ease, transform 0.1s ease;
    }

    .btn:active {
        transform: translateY(1px);
    }

    .btn-secondary {
        background: #334155;
        color: #f8fafc;
    }

    .btn-secondary:hover {
        background: #475569;
    }

    .btn-primary {
        background: #14b8a6;
        color: #020617;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: #2dd4bf;
    }
</style>
@endpush

@section('content')
<div class="edit-user-container">
    <div class="form-card">
        <h1 class="form-title">
            <span>&gt;</span> Edit Data User
        </h1>

        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Input Name -->
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control @error('name') is-invalid @enderror" 
                    value="{{ old('name', $user->name) }}" 
                    required
                    autocomplete="name"
                >
                @error('name')
                    <div class="error-text">⚠ {{ $message }}</div>
                @enderror
            </div>

            <!-- Input Email -->
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email', $user->email) }}" 
                    required
                    autocomplete="email"
                >
                @error('email')
                    <div class="error-text">⚠ {{ $message }}</div>
                @enderror
            </div>

            <!-- Input Password (Opsional) -->
            <div class="form-group">
                <label for="password">Password (Opsional)</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    autocomplete="new-password"
                >
                <div class="help-text">Kosongkan jika tidak ingin mengubah password user.</div>
                @error('password')
                    <div class="error-text">⚠ {{ $message }}</div>
                @enderror
            </div>

            <!-- Select Role -->
            <div class="form-group">
                <label for="role_id">Role / Hak Akses</label>
                <select id="role_id" name="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                    <option value="" disabled>-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ ucfirst($role->nama_role ?? $role->name) }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <div class="error-text">⚠ {{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Perbarui User</button>
            </div>
        </form>
    </div>
</div>
@endsection
```eof

```php:app/Http/Controllers/Admin/UserController.php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role_id'  => ['required', 'exists:roles,id'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.index')->with('success', 'Data user berhasil diperbarui.');
    }
}
```eof

### Key Highlights:
1. **Blade Template (`edit.blade.php`)**: Cleaned up inline CSS, added conditional `.is-invalid` classes to inputs on validation errors, and structured layout extends for standard Blade usage.
2. **Laravel Controller Example (`UserController.php`)**: Included proper validation logic with unique email checks ignoring the current user ID, conditional password hashing, and role verification.