<?php

namespace App\Http\Controllers;

use App\Models\Investasi;
use App\Models\KontrakInvestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KontrakInvestasiController extends Controller
{
    /**
     * Tampilkan Lembar Dokumen Akad / Kontrak Kemitraan Resmi (A4 Legal Document)
     */
    public function show($id)
    {
        $user = Auth::user();

        // Cari berdasarkan id_kontrak atau id_investasi
        $kontrak = KontrakInvestasi::with(['investasi', 'umkm.user', 'investor'])
            ->where('id', $id)
            ->orWhere('id_investasi', $id)
            ->first();

        // Jika belum ada kontrak pada investasi ini, inisialisasi otomatis
        if (!$kontrak) {
            $investasi = Investasi::with(['umkm.user', 'pengguna'])->findOrFail($id);
            $kontrak = $this->createKontrakForInvestasi($investasi);
        }

        // Hak akses: investor terkait, pemilik UMKM terkait, admin, atau mode tinjauan terbuka
        $isInvestor = ($kontrak->id_investor == $user->id) || ($user->role === 'investor' && app()->environment('local'));
        $isUmkm = (optional($kontrak->umkm)->user_id == $user->id) || ($user->role === 'umkm' && app()->environment('local'));
        $isAdmin = in_array($user->role, ['admin', 'super_admin']);
        $isPreview = (!$isInvestor && !$isUmkm && !$isAdmin);

        return view('dashboard.kontrak.show', compact('kontrak', 'user', 'isInvestor', 'isUmkm', 'isAdmin', 'isPreview'));
    }

    /**
     * Simpan Tanda Tangan Digital (E-Sign) dari Canvas
     */
    public function sign(Request $request, $id)
    {
        $user = Auth::user();

        $kontrak = KontrakInvestasi::where('id', $id)
            ->orWhere('id_investasi', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'signature_data' => ['required', 'string'], // base64 PNG data URL
        ]);

        $signature = $validated['signature_data'];

        $isInvestor = ($kontrak->id_investor == $user->id) || ($user->role === 'investor' && app()->environment('local'));
        $isUmkm = (optional($kontrak->umkm)->user_id == $user->id) || ($user->role === 'umkm' && app()->environment('local'));
        $isAdmin = in_array($user->role, ['admin', 'super_admin']);

        if (!$isInvestor && !$isUmkm && !$isAdmin) {
            return back()->with('error', 'Hanya pihak terkait dalam akad yang dapat membubuhkan tanda tangan digital.');
        }

        if ($isInvestor) {
            $kontrak->signature_investor = $signature;
            $kontrak->signed_at_investor = now();
        }

        if ($isUmkm) {
            $kontrak->signature_umkm = $signature;
            $kontrak->signed_at_umkm = now();
        }

        if ($isAdmin && !$isInvestor && !$isUmkm) {
            if (!$kontrak->signature_investor) {
                $kontrak->signature_investor = $signature;
                $kontrak->signed_at_investor = now();
            } else {
                $kontrak->signature_umkm = $signature;
                $kontrak->signed_at_umkm = now();
            }
        }

        if ($kontrak->signature_investor && $kontrak->signature_umkm) {
            $kontrak->status = 'aktif_sah';
        }

        $kontrak->save();

        return back()->with('success', 'Tanda tangan elektronik Anda berhasil dibubuhkan secara sah pada Akad Perjanjian #' . $kontrak->nomor_kontrak . '!');
    }

    /**
     * Inisialisasi Kontrak Digital untuk sebuah Investasi
     */
    public function createKontrakForInvestasi(Investasi $investasi): KontrakInvestasi
    {
        $nomorKontrak = 'TIKUM/AKAD/' . date('Y') . '/' . strtoupper(Str::random(3)) . '/' . sprintf('%04d', $investasi->id_investasi);
        $qrCode = hash('sha256', $investasi->id_investasi . '_' . $investasi->id_pengguna . '_' . $investasi->id_umkm . '_' . uniqid());

        return KontrakInvestasi::firstOrCreate(
            ['id_investasi' => $investasi->id_investasi],
            [
                'nomor_kontrak' => $nomorKontrak,
                'id_umkm' => $investasi->id_umkm,
                'id_investor' => $investasi->id_pengguna,
                'judul_kontrak' => 'Perjanjian Kemitraan Modal & Bagi Hasil Usaha Sektor Riil',
                'skema_akad' => 'Musyarakah (Bagi Hasil Sektor Riil)',
                'nominal_modal' => $investasi->jumlah_modal,
                'persentase_bagi_hasil' => $investasi->persentase_bagi_hasil,
                'tenor_bulan' => 12,
                'periode_dividen' => $investasi->periode_pembagian ?? 'Bulanan',
                'status' => 'aktif_sah',
                'kode_keabsahan_qr' => $qrCode,
            ]
        );
    }
}
