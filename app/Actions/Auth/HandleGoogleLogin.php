<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class HandleGoogleLogin
{
    public function execute($googleUser)
    {
        // Cari user berdasarkan email
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            throw new \Exception('Akun tidak terdaftar. Silahkan hubungi administrator.');
        }

        // Update google_id kalau belum ada
        if (!$user->google_id) {
            $avatarPath = null;
            $googleAvatarUrl = $googleUser->getAvatar();

            // Download dan simpan avatar ke lokal jika ada
            if ($googleAvatarUrl) {
                try {
                    $avatarContents = Http::get($googleAvatarUrl)->body();
                    $filename = 'avatars/google_' . $googleUser->getId() . '_' . time() . '.jpg';
                    Storage::disk('public')->put($filename, $avatarContents);
                    
                    $avatarPath = Storage::url($filename); // Menghasilkan URL path: /storage/avatars/namafile.jpg
                } catch (\Exception $e) {
                    // Fallback gunakan URL asli jika gagal download
                    $avatarPath = $googleAvatarUrl;
                }
            }

            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $avatarPath,
            ]);
        }

        // Login user
        Auth::login($user, true);

        return $user;
    }
}