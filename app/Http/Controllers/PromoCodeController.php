<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promos = PromoCode::orderBy('created_at', 'desc')->get();
        return view('admin.promo-codes.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promo-codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:promo_codes,code|max:50',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|integer|min:1',
            'quota' => 'required|integer|min:1',
            'valid_until' => 'required|date',
        ]);

        $data = $request->all();
        $data['code'] = strtoupper($request->code); // Pastikan kode selalu huruf besar
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        PromoCode::create($data);

        return redirect()->route('admin.promo-codes.index')->with('success', 'Kode Promo berhasil ditambahkan!');
    }

    public function edit(PromoCode $promoCode)
    {
        return view('admin.promo-codes.edit', compact('promoCode'));
    }

    public function update(Request $request, PromoCode $promoCode)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promo_codes,code,' . $promoCode->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|integer|min:1',
            'quota' => 'required|integer|min:1',
            'valid_until' => 'required|date',
        ]);

        $data = $request->all();
        $data['code'] = strtoupper($request->code);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $promoCode->update($data);

        return redirect()->route('admin.promo-codes.index')->with('success', 'Kode Promo berhasil diperbarui!');
    }

    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();
        return redirect()->route('admin.promo-codes.index')->with('success', 'Kode Promo berhasil dihapus!');
    }

    public function check(Request $request)
    {
        $promo = PromoCode::where('code', strtoupper($request->code))->first();

        if (!$promo) {
            return response()->json(['valid' => false, 'message' => 'Kode promo tidak ditemukan.']);
        }
        if (!$promo->is_active) {
            return response()->json(['valid' => false, 'message' => 'Kode promo sedang tidak aktif.']);
        }
        if (\Carbon\Carbon::parse($promo->valid_until)->isPast()) {
            return response()->json(['valid' => false, 'message' => 'Kode promo sudah kedaluwarsa.']);
        }
        if ($promo->used_count >= $promo->quota) {
            return response()->json(['valid' => false, 'message' => 'Kuota penggunaan promo sudah habis.']);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Promo berhasil diterapkan!',
            'promo' => $promo
        ]);
    }
}