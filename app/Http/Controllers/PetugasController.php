<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (Auth::user()->roles != 'ADMIN') {

        //     Alert::warning('Peringatan', 'Maaf Anda tidak punya akses');
        //     return back();
        // }

        if ($request->ajax()) {
            $data = DB::table('users')->where('roles', '=', 'USER')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="' . route('petugas.edit', $row->id) . '" class="btn btn-primary btn-sm">Ubah</a>';
                    $deleteBtn = '<a href="' . route('petugas.destroy', $row->id) . '" class="btn btn-danger btn-sm">Hapus</a>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.admin.petugas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.petugas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nik' => 'required|string|max:16|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'cabang' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = $request->all();

        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cabang' => $request->cabang,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return redirect()
                ->route('petugas.index')
                ->with([
                    'success' => 'Petugas baru ditambahkan'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Petugas gagal ditambahkan'
                ]);
        }

        // Alert::success('Berhasil', 'Petugas baru ditambahkan');
        // return redirect('admin/petugas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
