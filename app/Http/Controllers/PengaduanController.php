<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = Pengaduan::all();
            return DataTables::of($items)
            ->addIndexColumn()
            ->addColumn('berkas', function ($items){
                $file_path = $items->berkas; // file_path adalah atribut pada model Pengaduan yang menyimpan path file PDF
                $file_name = basename($file_path);
                return '<a href="'. Storage::url($file_path) .'" target="_blank"><img src="/assets/img/pdf-svg.svg" class="img-fluid" width="45px"></i></a>';
            })
            ->addColumn('created_at', function ($date){
                return Carbon::parse($date->created_at)->translatedFormat('d F Y - H:i:s');
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
                $actionBtn = '<a href="'.route('pengaduans.show', $row->id).'" class="btn btn-success btn-sm">Lihat</a>';
                return $actionBtn;
            })
            ->rawColumns(['berkas', 'status', 'action'])
            ->make(true);
        }
        return view('pages.admin.pengaduan.index');
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
        //
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

        $tangap = Tanggapan::where('pengaduan_id',$id)->first();

        return view('pages.admin.pengaduan.detail',[
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


        // $status->update($data);
        return redirect('admin/pengaduans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengaduan = Pengaduan::find($id);
        $pengaduan->delete();

        Alert::success('Berhasil', 'Pengaduan telah di hapus');
        return redirect('admin/pengaduan');
    }
}
