<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\InfluencerProfile;
use App\Models\ThirdPartyAuthentication;
use App\Models\Umkm;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman Login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Tampilkan halaman Register (Formulir Cepat 30 Detik)
     */
    public function showRegister(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedApplicant('investor');
        }

        return view('auth.register');
    }

    /**
     * Tampilkan Formulir Cepat dengan Peran Investor Terpilih
     */
    public function showRegisterInvestor(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedApplicant('investor');
        }

        $request->merge(['role' => 'investor']);

        return view('auth.register');
    }

    /**
     * Tampilkan Formulir Cepat dengan Peran Pelaku UMKM Terpilih
     */
    public function showRegisterUmkm(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedApplicant('umkm');
        }

        $request->merge(['role' => 'umkm']);

        return view('auth.register');
    }

    /**
     * Tampilkan Formulir Cepat dengan Peran Mitra Influencer Terpilih
     */
    public function showRegisterInfluencer(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedApplicant('influencer');
        }

        $request->merge(['role' => 'influencer']);

        return view('auth.register');
    }

    /**
     * Tampilkan halaman Verifikasi OTP
     */
    public function showVerifyOtp(Request $request)
    {
        $email = Session::get('otp_email');
        if (! $email) {
            return redirect()->route('login')->with('error', 'Sesi verifikasi tidak ditemukan. Silakan login atau daftar ulang.');
        }

        $action = Session::get('otp_action', 'verifikasi');

        return view('auth.verify-otp', compact('email', 'action'));
    }

    /**
     * Proses Registrasi Akun Cepat & Inisialisasi Profil (Tahap 1)
     */
    public function register(Request $request)
    {
        $rules = [
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'nomor_telepon' => ['required', 'string', 'max:25'],
            'role' => ['required', 'in:investor,umkm,influencer'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'kota' => ['nullable', 'string', 'max:100'],
            'provinsi_kota' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'kelurahan' => ['nullable', 'string', 'max:100'],
            'rt' => ['nullable', 'string', 'max:10'],
            'rw' => ['nullable', 'string', 'max:10'],
            'kategori_diminati' => ['nullable', 'string', 'max:100'],
            'foto_profil' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ];

        $validated = $request->validate($rules, [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan masuk.',
            'nomor_telepon.required' => 'Nomor WhatsApp / telepon wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.mixed' => 'Kata sandi harus mengandung huruf besar dan kecil.',
            'password.numbers' => 'Kata sandi harus mengandung angka.',
            'password.symbols' => 'Kata sandi harus mengandung simbol/karakter khusus.',
            'role.required' => 'Pilih peran pendaftaran.',
            'foto_profil.image' => 'Foto profil harus berupa file gambar (JPG, PNG, WEBP).',
            'foto_profil.max' => 'Ukuran foto profil maksimal 3MB.',
        ]);

        $role = $validated['role'];
        $provinsi = $validated['provinsi'] ?? null;
        $kota = $validated['kota'] ?? null;
        $provinsiKota = $validated['provinsi_kota'] ?? (($provinsi && $kota) ? "{$provinsi}, {$kota}" : ($kota ?: ($provinsi ?: null)));

        $avatarPath = null;
        if ($request->hasFile('foto_profil')) {
            $avatarPath = $request->file('foto_profil')->store('avatars', 'public');
        }

        // Simpan data akun pengguna baru
        $user = User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'phone_number' => $validated['nomor_telepon'],
            'provinsi' => $provinsi,
            'kota' => $kota,
            'provinsi_kota' => $provinsiKota,
            'kecamatan' => $validated['kecamatan'] ?? null,
            'kelurahan' => $validated['kelurahan'] ?? null,
            'rt' => $validated['rt'] ?? null,
            'rw' => $validated['rw'] ?? null,
            'kategori_diminati' => $validated['kategori_diminati'] ?? null,
            'avatar_url' => $avatarPath,
            'role' => $role,
            'password' => $validated['password'],
            'status' => 'menunggu_verifikasi',
        ]);

        // Jika pendaftar adalah UMKM, inisialisasi profil usaha awal (status: draf)
        if ($role === 'umkm') {
            Umkm::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_usaha' => 'Usaha '.$validated['nama'],
                    'jenis_usaha' => 'Makanan',
                    'pemilik' => $validated['nama'],
                    'nomor_whatsapp' => $validated['nomor_telepon'],
                    'provinsi' => $provinsi,
                    'kota' => $kota,
                    'provinsi_kota' => $provinsiKota,
                    'kecamatan' => $validated['kecamatan'] ?? null,
                    'kelurahan' => $validated['kelurahan'] ?? null,
                    'rt' => $validated['rt'] ?? null,
                    'rw' => $validated['rw'] ?? null,
                    'status_pengajuan' => 'draf',
                ]
            );
        }

        // Jika pendaftar adalah Influencer, inisialisasi profil kreator awal
        if ($role === 'influencer') {
            InfluencerProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_panggung' => $validated['nama'],
                    'kategori' => $validated['kategori_diminati'] ?? 'Kuliner',
                    'kota' => $kota ?? 'Surabaya',
                    'provinsi' => $provinsi ?? 'Jawa Timur',
                    'status_verifikasi' => 'terverifikasi',
                    'is_available' => true,
                    'saldo' => 0,
                ]
            );
        }

        // Kirim OTP verifikasi email pendaftaran
        $this->generateAndSendOtp($user, 'daftar');

        Session::put('otp_user_id', $user->id);
        Session::put('otp_email', $user->email);
        Session::put('otp_action', 'daftar');

        return redirect()->route('otp.verify.show')->with('success', 'Akun berhasil dibuat! Silakan verifikasi email Anda dengan kode OTP.');
    }

    /**
     * Proses Login Manual (Langsung Masuk tanpa OTP jika akun aktif)
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return back()->withInput($request->only('email'))->withErrors([
                'email' => 'Kombinasi email dan kata sandi tidak sesuai.',
            ]);
        }

        if ($user->status === 'ditangguhkan') {
            return back()->with('error', 'Akun Anda sedang ditangguhkan. Hubungi admin DAYA UMKM.');
        }

        // Jika akun masih berstatus menunggu verifikasi awal, arahkan ke OTP pendaftaran
        if ($user->status === 'menunggu_verifikasi') {
            $this->generateAndSendOtp($user, 'daftar');

            Session::put('otp_user_id', $user->id);
            Session::put('otp_email', $user->email);
            Session::put('otp_action', 'daftar');

            return redirect()->route('otp.verify.show')->with('warning', 'Akun Anda belum diverifikasi. Kode OTP telah dikirimkan ke email Anda.');
        }

        // Login langsung ke akun
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        if (in_array($user->role, ['admin', 'super_admin'])) {
            return redirect()->intended('/admin');
        }

        if ($user->role === 'influencer') {
            $profile = InfluencerProfile::where('user_id', $user->id)->first();
            if (! $profile || empty($profile->rate_story) || empty($profile->bio)) {
                return redirect()->route('formulir.influencer')->with('info', 'Selamat datang! Silakan lengkapi Formulir Pendaftaran Mitra Influencer Anda.');
            }
        }

        return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali, '.$user->name.'!');
    }

    /**
     * Tampilkan halaman Lupa Kata Sandi
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim OTP untuk Reset Kata Sandi
     */
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Alamat email tidak terdaftar di sistem.',
        ]);

        $user = User::where('email', $request->email)->first();

        $this->generateAndSendOtp($user, 'reset_password');

        Session::put('otp_user_id', $user->id);
        Session::put('otp_email', $user->email);
        Session::put('otp_action', 'reset_password');

        return redirect()->route('otp.verify.show')->with('success', 'Kode OTP pemulihan kata sandi telah dikirim ke email Anda.');
    }

    /**
     * Tampilkan Form Reset Kata Sandi Baru
     */
    public function showResetPassword()
    {
        if (! Session::get('can_reset_password') || ! Session::get('reset_user_id')) {
            return redirect()->route('password.request')->with('error', 'Sesi reset kata sandi tidak valid atau telah kedaluwarsa.');
        }

        return view('auth.reset-password');
    }

    /**
     * Simpan Kata Sandi Baru
     */
    public function resetPassword(Request $request)
    {
        $userId = Session::get('reset_user_id');
        if (! Session::get('can_reset_password') || ! $userId) {
            return redirect()->route('password.request')->with('error', 'Sesi reset kata sandi telah kedaluwarsa.');
        }

        $request->validate([
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.mixed' => 'Kata sandi harus mengandung huruf besar dan kecil.',
            'password.numbers' => 'Kata sandi harus mengandung angka.',
            'password.symbols' => 'Kata sandi harus mengandung simbol/karakter khusus.',
        ]);

        $user = User::findOrFail($userId);
        $user->password = $request->password;
        $user->save();

        Session::forget(['can_reset_password', 'reset_user_id']);

        return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diperbarui. Silakan masuk.');
    }

    /**
     * Verifikasi kode OTP
     */
    public function verifyOtp(Request $request)
    {
        // Pastikan hanya karakter angka numerik
        $cleanOtp = preg_replace('/\D/', '', (string) $request->input('otp'));
        $request->merge(['otp' => $cleanOtp]);

        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Kode OTP 6-digit wajib diisi.',
            'otp.digits' => 'Kode OTP harus berupa 6 digit angka.',
            'otp.size' => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $userId = Session::get('otp_user_id');
        $email = Session::get('otp_email');

        if (! $userId || ! $email) {
            return redirect()->route('login')->with('error', 'Sesi telah kedaluwarsa. Silakan ulangi.');
        }

        $user = User::findOrFail($userId);

        // Cari kode verifikasi yang cocok dan masih aktif (< 5 menit)
        $code = VerificationCode::where('user_id', $user->id)
            ->where('verification_type', 'otp_email')
            ->where('secret_code', $request->otp)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->latest('id_verification')
            ->first();

        if (! $code) {
            return back()->withErrors([
                'otp' => 'Kode OTP salah atau sudah kedaluwarsa. Silakan klik kirim ulang.',
            ]);
        }

        // Tandai kode sudah digunakan
        $code->update(['is_used' => true]);

        $action = Session::get('otp_action');
        if ($action === 'reset_password') {
            Session::put('can_reset_password', true);
            Session::put('reset_user_id', $user->id);
            Session::forget(['otp_user_id', 'otp_email', 'otp_action']);

            return redirect()->route('password.reset.show')->with('success', 'Kode OTP terverifikasi. Silakan masukkan kata sandi baru Anda.');
        }

        // Update status user jika belum terverifikasi
        if (! $user->email_verified_at) {
            $user->email_verified_at = Carbon::now();
        }
        if ($user->status === 'menunggu_verifikasi') {
            $user->status = 'aktif';
        }
        $user->save();

        // Login user
        $remember = Session::get('remember', false);
        Auth::login($user, $remember);

        // Bersihkan session OTP
        Session::forget(['otp_user_id', 'otp_email', 'otp_action', 'remember']);

        // Jika verifikasi berasal dari pendaftaran akun baru, arahkan langsung ke formulir pendaftaran peran (Tahap 2)
        if ($action === 'daftar') {
            if ($user->role === 'investor') {
                return redirect()->route('formulir.investor')->with('success', 'Email berhasil diverifikasi! Silakan lengkapi Formulir Pendaftaran Investor Anda di bawah ini.');
            }

            if ($user->role === 'influencer') {
                return redirect()->route('formulir.influencer')->with('success', 'Email berhasil diverifikasi! Silakan lengkapi Formulir Pendaftaran Mitra Influencer Anda di bawah ini.');
            }

            return redirect()->route('formulir.umkm')->with('success', 'Email berhasil diverifikasi! Silakan lengkapi Formulir Pendaftaran Pelaku UMKM Anda di bawah ini.');
        }

        return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali, '.$user->name.'!');
    }

    /**
     * Kirim Ulang Kode OTP
     */
    public function resendOtp()
    {
        $userId = Session::get('otp_user_id');
        if (! $userId) {
            return redirect()->route('login')->with('error', 'Sesi tidak ditemukan.');
        }

        $user = User::findOrFail($userId);
        $action = Session::get('otp_action', 'verifikasi');

        $this->generateAndSendOtp($user, $action);

        return back()->with('success', 'Kode OTP baru telah berhasil dikirimkan ke email Anda.');
    }

    /**
     * Redirect ke Google OAuth
     */
    public function googleRedirect(Request $request)
    {
        try {
            if ($request->query->has('role')) {
                $role = $request->query('role');
                if (! in_array($role, ['investor', 'umkm'], true)) {
                    return redirect()->route('register')->with('error', 'Peran pendaftaran tidak valid.');
                }

                $request->session()->put('google_registration_role', $role);
            }

            return Socialite::driver('google')->redirect();
        } catch (Throwable $e) {
            return redirect()->route('login')->with('error', 'Gagal menghubungkan ke Google: '.$e->getMessage().'.');
        }
    }

    /**
     * Callback dari Google OAuth
     */
    public function googleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect()->route('login')->with('error', 'Autentikasi Google gagal atau dibatalkan: '.$e->getMessage());
        }

        // Cari atau buat pengguna
        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            // Pengguna baru mendaftar via Google -> otomatis terverifikasi & aktif sesuai ERD
            $role = request()->session()->pull('google_registration_role', 'investor');
            $user = User::create([
                'name' => $googleUser->getName() ?? 'Pengguna Google',
                'email' => $googleUser->getEmail(),
                'role' => $role,
                'email_verified_at' => Carbon::now(),
                'status' => 'aktif',
                'avatar_url' => $googleUser->getAvatar(),
            ]);
        } else {
            // Update email_verified_at jika belum
            if (! $user->email_verified_at) {
                $user->email_verified_at = Carbon::now();
            }
            if ($user->status === 'menunggu_verifikasi') {
                $user->status = 'aktif';
            }
            if (! $user->avatar_url) {
                $user->avatar_url = $googleUser->getAvatar();
            }
            $user->save();
        }

        // Simpan ke tabel autentikasi_pihak_ketiga
        ThirdPartyAuthentication::updateOrCreate(
            [
                'provider_name' => 'google',
                'provider_user_id' => $googleUser->getId(),
            ],
            [
                'user_id' => $user->id,
                'avatar_url' => $googleUser->getAvatar(),
                'connected_at' => Carbon::now(),
            ]
        );

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'))->with('success', 'Berhasil masuk dengan akun Google.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }

    private function redirectAuthenticatedApplicant(string $requestedRole): RedirectResponse
    {
        $user = Auth::user();

        if (! in_array($user->role, ['investor', 'umkm', 'influencer'], true)) {
            return redirect()->route('dashboard')->with('error', 'Pendaftaran mitra hanya tersedia untuk akun investor, pelaku UMKM, atau influencer.');
        }

        if ($user->role !== $requestedRole) {
            if ($user->role === 'umkm') {
                $joinRoute = 'gabung.umkm';
                $roleLabel = 'pelaku UMKM';
            } elseif ($user->role === 'investor') {
                $joinRoute = 'gabung.investor';
                $roleLabel = 'investor';
            } else {
                $joinRoute = 'gabung.influencer';
                $roleLabel = 'mitra influencer';
            }

            return redirect()->route($joinRoute)->with('error', 'Akun Anda terdaftar sebagai '.$roleLabel.'.');
        }

        if ($user->role === 'investor') {
            if (empty($user->kategori_diminati)) {
                return redirect()->route('formulir.investor')->with('info', 'Lengkapi formulir pendaftaran investor Anda.');
            }

            if ($user->status === 'menunggu_verifikasi') {
                return redirect()->route('dashboard')->with('info', 'Formulir investor sudah diajukan dan sedang menunggu verifikasi admin.');
            }

            return redirect()->route('dashboard')->with('info', 'Akun investor Anda sudah diterima.');
        }

        if ($user->role === 'influencer') {
            $profile = InfluencerProfile::where('user_id', $user->id)->first();

            if (! $profile || empty($profile->rate_story) || empty($profile->bio)) {
                return redirect()->route('formulir.influencer')->with('info', 'Lengkapi formulir pendaftaran mitra influencer Anda.');
            }

            return redirect()->route('dashboard')->with('info', 'Akun mitra influencer Anda sudah aktif.');
        }

        if ($user->role === 'umkm') {
            $umkm = Umkm::where('user_id', $user->id)->first();

            if (! $umkm || $umkm->status_pengajuan === 'draf') {
                return redirect()->route('formulir.umkm')->with('info', 'Lengkapi dan ajukan formulir pendaftaran UMKM Anda.');
            }

            if ($umkm->status_pengajuan === 'menunggu_verifikasi') {
                return redirect()->route('formulir.umkm')->with('info', 'Pengajuan UMKM Anda sedang menunggu verifikasi admin.');
            }

            if ($umkm->status_pengajuan === 'ditolak') {
                return redirect()->route('formulir.umkm')->with('info', 'Pengajuan UMKM Anda belum diterima. Perbarui formulir sebelum mengajukan kembali.');
            }
        }

        return redirect()->route('dashboard')->with('info', 'Akun Anda sudah terdaftar.');
    }

    /**
     * Helper membuat & mengirim kode OTP
     */
    protected function generateAndSendOtp(User $user, string $action): string
    {
        // Generate random 6-digit number
        $otp = (string) random_int(100000, 999999);

        // Batalkan kode sebelumnya yang belum terpakai untuk user ini
        VerificationCode::where('user_id', $user->id)
            ->where('verification_type', 'otp_email')
            ->where('is_used', false)
            ->update(['is_used' => true]);

        // Simpan kode baru (valid 5 menit)
        VerificationCode::create([
            'user_id' => $user->id,
            'verification_type' => 'otp_email',
            'secret_code' => $otp,
            'sent_to' => $user->email,
            'is_used' => false,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        $actionText = match ($action) {
            'daftar' => 'verifikasi pendaftaran akun baru',
            'reset_password' => 'pemulihan kata sandi',
            default => 'keamanan masuk akun',
        };

        // Kirim email
        try {
            Mail::to($user->email)->send(new SendOtpMail(
                otp: $otp,
                userName: $user->name,
                action: $actionText
            ));
        } catch (Throwable $e) {
            // Log jika mail belum terkonfigurasi (misal mailer log)
            report($e);
        }

        return $otp;
    }
}
