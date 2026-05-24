<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use App\Services\RecommendationService;

class VoucherController extends Controller
{
    public function index(RecommendationService $recommendationService)
    {
        $user = auth()->user();
        
        // Voucher Dimiliki (sudah ditukar, belum dipakai)
        $ownedVouchers = $user->promos()->wherePivot('is_used', false)->get();
        
        // Semua Promo ID yang pernah ditukar oleh user (baik dipakai atau belum)
        $allRedeemedPromoIds = $user->promos()->pluck('promos.id')->toArray();

        // Voucher Tersedia (Rekomendasi)
        $recommended = $recommendationService->getPromoRecommendations($user);
        
        // Filter: jangan tampilkan yang sudah pernah ditukar
        $availablePromos = [];
        foreach ($recommended as $promo) {
            if (!in_array($promo->id, $allRedeemedPromoIds)) {
                $availablePromos[] = $promo;
            }
        }

        return view('vouchers.index', compact('ownedVouchers', 'availablePromos'));
    }

    public function redeem(Request $request, Promo $promo)
    {
        $user = auth()->user();

        // Cek apakah sudah pernah redeem
        if ($user->promos()->where('promos.id', $promo->id)->exists()) {
            return back()->with('error', 'Anda sudah pernah menukar voucher ini.');
        }

        // Validasi poin
        if ($user->points_balance < $promo->points_required) {
            return back()->with('error', 'Poin Anda tidak mencukupi untuk menukar voucher ini.');
        }

        // Potong poin dan berikan voucher
        $user->points_balance -= $promo->points_required;
        $user->save();

        $user->promos()->attach($promo->id);

        return back()->with('success', 'Voucher ' . $promo->code . ' berhasil ditukarkan! Silakan gunakan saat melakukan pembayaran.');
    }
}
