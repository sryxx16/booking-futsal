<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use App\Models\Field;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        // Ambil semua data member beserta relasi user dan field-nya
        $memberships = Membership::with(['user', 'field'])->latest()->get();
        return view('admin.memberships.index', compact('memberships'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get(); // Ambil akun pelanggan
        $fields = Field::all(); // Ambil semua lapangan

        return view('admin.memberships.create', compact('users', 'fields'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'field_id' => 'required|exists:fields,id',
            'team_name' => 'required|string|max:255',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'special_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        Membership::create($validated);

        return redirect()->route('admin.memberships.index')->with('success', 'Member baru berhasil ditambahkan!');
    }

    // Untuk fungsi edit, update, dan destroy bisa lu tambahin nanti setelah ini jalan
    public function destroy(Membership $membership)
    {
        $membership->delete();
        return redirect()->route('admin.memberships.index')->with('success', 'Data Member berhasil dihapus!');
    }
}
