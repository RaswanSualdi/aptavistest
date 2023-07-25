<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klub;
use App\Models\Skor;
use RealRashid\SweetAlert\Facades\Alert;

class SkorController extends Controller
{
    public function index()
    {
        $klubs = Klub::all();
        return view('skor.index', compact('klubs'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'klub_id_1' => 'required|different:klub_id_2',
                'klub_id_2' => 'required',
                'score_1' => 'required|numeric|min:0',
                'score_2' => 'required|numeric|min:0',
            ]);
    
            Skor::create($request->all());
    
            // Use SweetAlert for success message
            Alert::success('Success', 'Skor berhasil ditambahkan.')->autoClose(3000);
    
            // Redirect to the 'klasemen' route
            return redirect()->route('klasemen');
        } catch (\Exception $e) {
            // Untuk handle error exception
    
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan skor.')->autoClose(5000);
            return redirect()->back()->withErrors('Terjadi kesalahan saat menyimpan skor.')->withInput();
        }
    }

    public function storeMultiple(Request $request)
    {

        try{

            $clubIds = [];
            foreach ($request->scores as $scoreData) {
                $clubIds[] = $scoreData['klub_id_1'];
                $clubIds[] = $scoreData['klub_id_2'];
            }

            // memeriksa apakah ada klub yang muncul lebih dari sekali (lebih dari satu kali) dalam suatu data atau daftar
            $duplicateClubs = array_filter(array_count_values($clubIds), function ($count) {
                return $count > 1;
            });

            if (count($duplicateClubs) > 0) {
                Alert::error('Error', 'Klub tidak dapat memainkan dua laga sekaligus.')->persistent(true, false)->autoClose(30000);
                return redirect()->route('skor.index');
            }

            // Simpan  multiple scores
            foreach ($request->scores as $scoreData) {
                Skor::create([
                    'klub_id_1' => $scoreData['klub_id_1'],
                    'klub_id_2' => $scoreData['klub_id_2'],
                    'score_1' => $scoreData['score_1'],
                    'score_2' => $scoreData['score_2'],
                ]);
            }

            Alert::success('Success', 'Skor berhasil ditambahkan.')->autoClose(30000);

            return redirect()->route('klasemen');
        }  catch (\Exception $e){
                Alert::error('Error', 'Terjadi kesalahan saat menyimpan skor.')->autoClose(5000);
                return redirect()->back()->withErrors('Terjadi kesalahan saat menyimpan skor.')->withInput();
        }
        
    }

    public function klasemen()
    {
        $klubs = Klub::all();
        $klasemen = [];
        
        foreach ($klubs as $klub) {
            $klubData = [
                'klub' => $klub->nama_klub,
                'Ma' => 0,
                'Me' => 0,
                'S' => 0,
                'K' => 0,
                'GM' => 0,
                'GK' => 0,
                'Point' => 0,
            ];
            
            $scores = Skor::where('klub_id_1', $klub->id)->orWhere('klub_id_2', $klub->id)->get();
            foreach ($scores as $score) {
                $klubData['Ma']++;
                
                if ($score->klub_id_1 === $klub->id) {
                    $klubData['GM'] += $score->score_1;
                    $klubData['GK'] += $score->score_2;
                    if ($score->score_1 > $score->score_2) {
                        $klubData['Me']++;
                        $klubData['Point'] += 3;
                    } elseif ($score->score_1 === $score->score_2) {
                        $klubData['S']++;
                        $klubData['Point'] += 1;
                    } else {
                        $klubData['K']++;
                    }
                } else {
                    $klubData['GM'] += $score->score_2;
                    $klubData['GK'] += $score->score_1;
                    if ($score->score_2 > $score->score_1) {
                        $klubData['Me']++;
                        $klubData['Point'] += 3;
                    } elseif ($score->score_2 === $score->score_1) {
                        $klubData['S']++;
                        $klubData['Point'] += 1;
                    } else {
                        $klubData['K']++;
                    }
                }
            }
            
            $klasemen[] = $klubData;
        }

        // Mengurutkan array $klasemen berdasarkan poin secara menurun (descending).
        usort($klasemen, function ($a, $b) {
            return $b['Point'] - $a['Point'];
        });

        return view('klasemen', compact('klasemen'));
    }
}

