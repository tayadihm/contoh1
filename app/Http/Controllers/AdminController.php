<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Pengaduan;

use Barryvdh\DomPDF\Facade\Pdf;


class AdminController extends Controller
{
    public function __invoke()
    {

    }

    public function index($id) {

        $item = Pengaduan::with([
            'details', 'user'
        ])->findOrFail($id);

        return view('pages.admin.pengaduan.detail',[
        'item' => $item
        ]);
    }

    public function masyarakat() {

        $data = DB::table('users')->where('roles','=', 'USER')->get();

        return view('pages.admin.masyarakat', [
            'data' => $data
        ]);
    }

    public function laporan() {

        $pengaduan = Pengaduan::all();

        return view('pages.admin.laporan',[
            'pengaduan' => $pengaduan
        ]);
    }

    public function cetak() {

        $pengaduan = Pengaduan::all();

        $pdf = Pdf::loadview('pages.admin.pengaduan',[
            'pengaduan' => $pengaduan
        ])->setPaper('a4', 'landscape');
        return $pdf->download('Laporan Pengaduan Bansos.pdf');
    }

    public function pdf($id) {

        $pengaduan = Pengaduan::find($id);

        $pdf = Pdf::loadview('pages.admin.pengaduan.cetak', compact('pengaduan'))->setPaper('a4');
        return $pdf->download('laporan-pengaduan.pdf');
    }
}
