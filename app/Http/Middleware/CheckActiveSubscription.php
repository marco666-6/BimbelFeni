<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;

class CheckActiveSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        // Skip for admin
        if ($user->isAdmin()) {
            return $next($request);
        }
        
        // For siswa
        if ($user->isSiswa()) {
            $siswa = $user->siswa;
            $hasActiveSubscription = $this->checkSiswaSubscription($siswa);
            
            if (!$hasActiveSubscription) {
                return redirect()->route('siswa.dashboard')
                    ->with('error', 'Anda tidak memiliki paket aktif. Silakan hubungi orang tua untuk melakukan pembayaran.');
            }
        }
        
        // For orangtua - check if any child has active subscription
        if ($user->isOrangTua()) {
            $orangTua = $user->orangTua;
            $hasAnyActiveChild = false;
            
            foreach ($orangTua->siswa as $siswa) {
                if ($this->checkSiswaSubscription($siswa)) {
                    $hasAnyActiveChild = true;
                    break;
                }
            }
            
            if (!$hasAnyActiveChild) {
                return redirect()->route('orangtua.dashboard')
                    ->with('error', 'Tidak ada anak dengan paket aktif. Silakan lakukan pembayaran terlebih dahulu.');
            }
        }
        
        return $next($request);
    }
    
    private function checkSiswaSubscription($siswa)
    {
        // Get latest verified transaction
        $latestTransaction = Transaksi::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'verified')
            ->latest('tanggal_transaksi')
            ->first();
        
        if (!$latestTransaction) {
            return false;
        }
        
        // Check if subscription is still active
        $paket = $latestTransaction->paketBelajar;
        $endDate = Carbon::parse($latestTransaction->tanggal_transaksi)
            ->addMonths($paket->durasi_bulan);
        
        return now()->lte($endDate);
    }
}