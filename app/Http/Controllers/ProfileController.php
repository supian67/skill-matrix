<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Halaman profil
    public function edit()
    {
        return view('profile.edit');
    }

    // Simpan perubahan profil
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $user->name = $validated['name'];

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika tersedia
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Simpan foto baru
            $user->profile_photo = $request->file('photo')
                ->store('profiles', 'public');
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}