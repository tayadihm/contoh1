<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class TanggapanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'tanggapan'     => 'required|max:255',
            'status'        => 'required|in:Selesai,Sedang di Proses,Belum di Proses',
            'feedback'      => 'required|max:2048|mimetypes:application/pdf'
        ]);

        $now = Carbon::now('Asia/Jakarta');

        $petugas_id = Auth::user()->id;
        $data = $request->all();
        $data['pengaduan_id'] = $request->pengaduan_id;
        $data['petugas_id']=$petugas_id;
        $filename = $now->format('Ymd_His') . '_' . $request->file('feedback')->getClientOriginalName();
        $data['feedback'] = $request->file('feedback')->storeAs('public', $filename);

        try {
            Tanggapan::create($data);
            DB::table('pengaduan')->where('id', $request->pengaduan_id)->update([
                'status'=> $request->status,
            ]);
            return redirect()->route('pengaduans.show', ['pengaduan' => $request->pengaduan_id])->with('success', 'Pengaduan Berhasil Ditanggapi');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error', 'Tanggapan Gagal:' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Pengaduan::with([
            'details', 'user'
        ])->findOrFail($id);

        return view('pages.admin.tanggapan.add',[
            'item' => $item
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tanggapan = Tanggapan::findOrFail($id);
        return view('pages.admin.tanggapan.edit', compact('tanggapan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggapan'     => 'required|max:255',
            'status'        => 'required|in:Selesai,Sedang di Proses,Belum di Proses',
            'feedback'      => 'nullable|max:2048|mimetypes:application/pdf'
        ]);

        $now = Carbon::now('Asia/Jakarta');
        $tanggapan = Tanggapan::findOrFail($id);
        $petugas_id = Auth::user()->id;
        $data = $request->all();
        $data['petugas_id'] = $petugas_id;

        if ($request->hasFile('feedback')) {
            $filename = $now->format('Ymd_His') . '_' . $request->file('feedback')->getClientOriginalName();
            $data['feedback'] = $request->file( 'feedback')->storeAs('public', $filename);
        }

        try {
            $tanggapan->update($data);
            DB::table('pengaduan')->where('id', $tanggapan->pengaduan_id)->update([
                'status'=> $request->status,
            ]);
            return redirect()->route('pengaduans.show', ['pengaduan' => $tanggapan->pengaduan_id])->with('success', 'Tanggapan Berhasil Diupdate');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error', 'Tanggapan Gagal:' . $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
