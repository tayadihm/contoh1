<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
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
                    $deleteBtn = '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '">Hapus</button>';
                    $deleteForm = '<form action="' . route('petugas.destroy', $row->id) . '" method="POST" class="d-none form-delete" data-id="' . $row->id . '">
                                    ' . method_field('DELETE') . csrf_field() . '</form>';
                    return $editBtn . ' ' . $deleteBtn . ' ' . $deleteForm;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response()->view('pages.admin.petugas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('pages.admin.petugas.create');
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
            return response()
                ->redirect()
                ->route('petugas.index')
                ->with([
                    'success' => 'Petugas baru ditambahkan'
                ]);
        } else {
            return response()
                ->redirect()
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
        $petugas = User::findOrFail($id);
        return response()->view('pages.admin.petugas.edit', [
            'petugas' => $petugas
        ]);
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
        $this->validate($request, [
            'nik' => 'required|string|max:16|unique:users,nik,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',
            'cabang' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $petugas = User::findOrFail($id);

        $petugas->nik = $request->nik;
        $petugas->name = $request->name;
        $petugas->email = $request->email;
        $petugas->phone = $request->phone;
        $petugas->cabang = $request->cabang;
        if ($request->filled('password')) {
            $petugas->password = Hash::make($request->password);
        }

        if ($petugas->update()) {
            return redirect()
                ->route('petugas.index')
                ->with([
                    'success' => 'Petugas berhasil diupdate'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Petugas gagal diupdate'
                ]);
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
        $petugas = User::findOrFail($id);

        if ($petugas->delete()) {
            return redirect()
                ->route('petugas.index')
                ->with([
                    'success' => 'Petugas ' .$petugas->name. ' berhasil dihapus'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Petugas ' .$petugas->name. ' gagal dihapus'
                ]);
        }
    }
}
