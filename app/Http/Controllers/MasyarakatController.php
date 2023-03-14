<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'jenis_pengaduan'   => 'required|in:KJP,KJMU,BPMS'
        ]);

        $nik = Auth::user()->nik;
        $id = Auth::user()->id;

        $data = $request->all();
        $data['user_nik']=$nik;
        $data['user_id']=$id;
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

    public function streamPdf($filename)
    {
        $file = Storage::disk('public')->get($filename);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
        return response()->download($file, $filename, $headers);
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
            ->addColumn('ktp', function ($items){
                $file_path = $items->ktp; // file_path adalah atribut pada model Pengaduan yang menyimpan path file PDF
                $file_name = basename($file_path);
                return '<a href="'. Storage::url($file_path) .'" target="_blank"><img src="/assets/img/pdf-svg.svg" class="img-fluid" width="45px"></i></a>';
            })
            ->addColumn('created_at', function ($date){
                return Carbon::parse($date->created_at)->format('l, d F Y - H:i:s');
            })
            ->addColumn('status', function ($item){
                if ($item->status == 'Belum di Proses') {
                    return '<span class="px-2 py-1 font-bold text-xs leading-tight text-red-700 bg-red-100 rounded-md dark:text-red-100 dark:bg-red-700">Belum di Proses</span>';
                } elseif ($item->status == 'Sedang di Proses') {
                    return '<span class="px-2 py-1 font-bold text-xs leading-tight text-orange-700 bg-orange-100 rounded-md dark:text-white dark:bg-orange-600">Sedang di Proses</span>';
                } elseif ($item->status == 'Selesai') {
                    return '<span class="px-2 py-1 font-bold text-xs leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">Selesai</span>';
                } else {
                    return $item->status;
                }
            })
            ->addColumn('action', function($row){
                $actionBtn = '<a href="'.route('pengaduan.show', $row->id).'" class="btn btn-success btn-sm">Lihat</a>';
                return $actionBtn;
            })
            ->rawColumns(['ktp', 'status', 'action'])
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
