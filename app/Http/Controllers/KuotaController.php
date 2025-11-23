<?php

namespace App\Http\Controllers;
use App\Models\Kuota;

use Illuminate\Http\Request;

class KuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kuotas = Kuota::with(['pendaftarans' => function($query) {
            $query->where('status', 'approved')->orderBy('tanggal_mulai_pkl');
        }])->orderBy('bulan')->get(); // Urutkan berdasarkan bulan (jika format bulan memungkinkan, misal 'YYYY-MM')
        return view('admin.kuotas.index', compact('kuotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kuotas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bulan' => 'required|string|max:255|unique:kuotas,bulan', // Bulan harus unik
            'jumlah_kuota' => 'required|integer|min:1',
        ]);

        Kuota::create($request->all());

        return redirect()->route('admin.kuotas.index')->with('success', 'Kuota berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kuota $kuota)
    {
        return view('admin.kuotas.show', compact('kuota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kuota $kuota) 
    {
        return view('admin.kuotas.edit', compact('kuota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kuota $kuota) 
    {
        $request->validate([
            'bulan' => 'required|string|max:255|unique:kuotas,bulan,' . $kuota->id, // $kuota->id sekarang aman
            'jumlah_kuota' => 'required|integer|min:1',
        ]);

        $kuota->update($request->all()); // $kuota adalah instance model yang siap di-update

        return redirect()->route('admin.kuotas.index')->with('success', 'Kuota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kuota $kuota) 
    {
        $kuota->delete(); 

        return redirect()->route('admin.kuotas.index')->with('success', 'Kuota berhasil dihapus.');
    }
}
