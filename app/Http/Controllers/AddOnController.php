<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use Illuminate\Http\Request;

class AddOnController extends Controller
{
    public function index()
    {
        $addOns = AddOn::latest()->get();
        return view('admin.add-ons.index', compact('addOns'));
    }

    public function create()
    {
        return view('admin.add-ons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        AddOn::create($request->all());

        return redirect()->route('admin.add-ons.index')->with('success', 'Fasilitas tambahan berhasil ditambahkan!');
    }

    public function edit(AddOn $addOn)
    {
        return view('admin.add-ons.edit', compact('addOn'));
    }

    public function update(Request $request, AddOn $addOn)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $addOn->update($request->all());

        return redirect()->route('admin.add-ons.index')->with('success', 'Fasilitas tambahan berhasil diperbarui!');
    }

    public function destroy(AddOn $addOn)
    {
        $addOn->delete();
        return redirect()->route('admin.add-ons.index')->with('success', 'Fasilitas tambahan berhasil dihapus!');
    }
}