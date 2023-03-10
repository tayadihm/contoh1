@extends('layouts.masyarakat')

@section('title')
    Dashboard
@endsection
@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        {{-- @foreach ($liat as $li)
 <li>{{ $li->nik }}</li>
  @endforeach --}}
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-center text-gray-700 dark:text-gray-200">
            </h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }} </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('pengaduan.store') }} " method="POST" enctype="multipart/form-data">
                @csrf

                <div class="px-4 py-3 mb-8 bg-red-300 rounded-lg shadow-xl border-2 dark:bg-gray-800">
                    <h2 class="my-6 text-2xl font-semibold text-center text-gray-700 dark:text-gray-200">
                        Form Laporan
                    </h2>
                    <div class="form-group">
                        <label for="name" class="text-gray-700 dark:text-gray-400">Nama Nasabah</label>
                        <input type="text" class="form-control dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                            name="name" id="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="norek_nasabah" class="text-gray-700 dark:text-gray-400">Nomor Rekening Nasabah</label>
                        <input type="text" class="form-control dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                            name="norek_nasabah" id="norek_nasabah" placeholder="Nomor Rekening"
                            value="{{ old('norek_nasabah') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_nasabah" class="text-gray-700 dark:text-gray-400">Nomor Telepon Nasabah</label>
                        <input type="text" class="form-control dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                            name="phone_nasabah" id="phone_nasabah" placeholder="Nomor Telepon"
                            value="{{ old('phone_nasabah') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_pengaduan" class="text-gray-700 dark:text-gray-400">Jenis Pengaduan</label>
                        <select name="jenis_pengaduan" id="jenis_pengaduan"
                            class="form-control dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                            <option selected>-Pilih Jenis Pengaduan-</option>
                            <option value="KJP">KJP</option>
                            <option value="KJMU">KJMU</option>
                            <option value="BPMS">BPMS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ktp" class="text-gray-700 dark:text-gray-400">Upload File (PDF)</label>
                        <input type="file"
                            class="form-control-file dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                            name="ktp" value="{{ old('ktp') }}" accept="application/pdf">
                    </div>
                    <div class="form-group">
                        <label for="description" class="text-gray-700 dark:text-gray-400">Deskripsi Pengaduan</label>
                        <textarea class="block w-full mt-1 border-2 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea"
                            rows="8" type="text" placeholder="Deskripsikan laporan Anda dengan jelas" value="{{ old('description') }}"
                            name="description"></textarea>
                    </div>
                    <div class="form-row">
                        <button type="submit" class="btn btn-primary">
                            Laporkan
                        </button>&nbsp;
                        <a href="{{ route('masyarakat-lihat') }}" class="btn btn-danger" role="button">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
