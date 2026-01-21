<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Pendaftaran; 

class ProfileController extends Controller
{
    public function show()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('email', $user->email)->first();
        return view('profile.show', compact('user', 'pendaftaran'));
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'asal_sekolah' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|regex:/^[0-9]+$/|min:10|max:13',
        ], [
            'no_telp.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'no_telp.min' => 'Nomor telepon minimal 10 digit.',
            'no_telp.max' => 'Nomor telepon maksimal 13 digit.',
        ]);

        $user = Auth::user();
        $updateData = [];

        // Handle avatar update
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan avatar baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $updateData['avatar'] = $path;
        }

        // Handle profile fields
        if ($request->has('asal_sekolah')) {
            $updateData['asal_sekolah'] = $request->asal_sekolah;
        }

        if ($request->has('jurusan')) {
            $updateData['jurusan'] = $request->jurusan;
        }

        if ($request->has('no_telp')) {
            $updateData['no_telp'] = $request->no_telp;
        }

        if (!empty($updateData)) {
            \App\Models\User::where('id', $user->id)->update($updateData);
        }

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}