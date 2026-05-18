<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'avatar' => 'nullable|image|max:5120',
            'asal_sekolah' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|regex:/^[0-9]+$/|min:10|max:13',
        ], [
            'no_telp.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'no_telp.min' => 'Nomor telepon minimal 10 digit.',
            'no_telp.max' => 'Nomor telepon maksimal 13 digit.',
        ]);

        $user = Auth::user();

        // ======================
        // HANDLE UPLOAD AVATAR
        // ======================
        if ($request->hasFile('avatar')) {

            // hapus avatar lama (jika ada & file lokal)
            if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                if (Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            // simpan avatar baru ke storage/app/public/avatars
            $path = $request->file('avatar')->store('avatars', 'public');

            // simpan ke database (format: avatars/xxx.jpg)
            $user->avatar = $path;
        }

        // ======================
        // UPDATE DATA PROFIL
        // ======================
        $user->asal_sekolah = $request->asal_sekolah;
        $user->jurusan = $request->jurusan;
        $user->no_telp = $request->no_telp;

        $user->save();

        // refresh user session
        Auth::setUser($user);

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