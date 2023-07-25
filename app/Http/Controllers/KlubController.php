<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klub;
use RealRashid\SweetAlert\Facades\Alert;


class KlubController extends Controller
{
    public function index()
    {
        $klubs = Klub::all();
        return view('klub.index', compact('klubs'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'nama_klub' => 'required|unique:klubs,nama_klub',
                'kota_klub' => 'required'
            ]);
    
            Klub::create($request->all());
            return redirect()->route('klub.index')->with('success', 'Klub berhasil ditambahkan.');
        }catch (\Exception $e) {
            Alert::error('Error', 'Nama Klub Sudah Ada.')->autoClose(5000);
            return redirect()->back()->withErrors('Terjadi kesalahan saat menyimpan skor.')->withInput();
        }
       
    }
}

