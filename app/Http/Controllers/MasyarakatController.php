<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = Auth::user()->nik;
        // dd($user);

        return view('pages.masyarakat.detail');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user()->nik;
        return view('pages.masyarakat.index', ['liat'=>$user]);
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
            'description'       => 'required',
            'phone_nasabah'     => 'required|max:13',
            'ktp'               => 'required|mimetypes:application/pdf',
        ]);

        $nik = Auth::user()->nik;
        $id = Auth::user()->id;
        $name = Auth::user()->name;

        $data = $request->all();
        $data['user_nik']=$nik;
        $data['user_id']=$id;
        $data['name']=$name;
        $filename = time() . '_' . $request->file('ktp')->getClientOriginalName();
        $data['ktp'] = $request->file('ktp')->storeAs('public', $filename);

        try {
            Pengaduan::create($data);
            return redirect()->back()->with('success', 'Pengaduan Berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Pengaduan Gagal');
        }
        return redirect('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function lihat(Request $request) {

        // $user = Auth::user()->pengaduan()->get();
        // $user = Auth::user()->nik;

        if ($request->ajax()) {
            $items = Pengaduan::where('user_nik', Auth::user()->nik)->get();
            return DataTables::of($items)
            ->addIndexColumn()
            ->addColumn('image', function ($img){
                $url = Storage::url($img->image);
                return '<img src="'.$url.'" width="120px" height="120px">';
            })
            ->addColumn('created_at', function ($date){
                return Carbon::parse($date->created_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function($row){
                $actionBtn = '<a href="'.route('pengaduan.show', $row->id).'" class="edit btn btn-success btn-sm">Lihat</a>';
                return $actionBtn;
            })
            ->rawColumns(['image','action'])
            ->make(true);
        }
        return view('pages.masyarakat.detail');
    }

    public function show($id)
    {
        $item = Pengaduan::with([
            'details', 'user'
        ])->findOrFail($id);

        $tangap = Tanggapan::where('pengaduan_id',$id)->first();

        return view('pages.masyarakat.show',[
        'item' => $item,
        'tangap' => $tangap
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
