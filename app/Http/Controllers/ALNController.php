<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ALNController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aln = Auth::user()->nik;
        return view('pages.aln.index', compact($aln));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.aln.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description'   => 'required',
            'pdf'           => 'required',
        ]);

        $id     = Auth::user()->id;
        $nik    = Auth::user()->nik;
        $name   = Auth::user()->name;

        $data               = $request->all();
        $data['user_id']    = $id;
        $data['user_nik']   = $nik;
        $data['name']       = $name;
        $data['pdf']        = $request->file('pdf')->store('assets/laporan', 'public');

        Pengaduan::create($data);
        return redirect('user')->with('success', 'Pengaduan Terkirim');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ALN  $aLN
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ALN  $aLN
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ALN  $aLN
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ALN  $aLN
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
