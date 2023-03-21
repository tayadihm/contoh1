@extends('layouts.admin')

@section('title')
    Detail Pengaduan
@endsection

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-center text-gray-700 dark:text-gray-200">
            </h2>

            <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    @foreach ($item->details as $ite)
                        <div class="row w-full">
                            <div class="col-md-3">
                                <h3 class="my-3 font-semibold mx-3 dark:text-gray-300">Berkas</h3>
                                <img src="/assets/img/pdf-svg.svg" class="img-fluid mb-2 w-auto" loading="lazy"
                                    alt="Berkas">
                                <a href="{{ Storage::url($item->berkas) }}" target="_blank"
                                    class="btn btn-primary btn-sm w-full">Download</a>
                            </div>
                            <div class="col-md-9">
                                <h3 class="my-3 dark:text-gray-300">Detail Pengaduan</h3>
                                <ul>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label dark:text-gray-300">Jenis Pengaduan :</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                class="form-input col-sm-9 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                value="{{ $ite->jenis_pengaduan }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label dark:text-gray-300">Nama Nasabah :</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                class="form-input col-sm-9 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                value="{{ $ite->name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label dark:text-gray-300">NIK Nasabah :</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                class="form-input col-sm-9 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                value="{{ $ite->id_nasabah }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label dark:text-gray-300">Nomor Rekening Nasabah
                                            :</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                class="form-input col-sm-9 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                value="{{ $ite->norek_nasabah }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label dark:text-gray-300">Nomor Telepon Nasabah
                                            :</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                class="form-input col-sm-9 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                value="{{ $ite->phone_nasabah }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label dark:text-gray-300">Nama ALN :</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                class="form-input col-sm-9 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                value="{{ $ite->user->name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label dark:text-gray-300">Kantor Layanan :</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                class="form-input col-sm-9 bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                value="{{ $ite->user->cabang }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label dark:text-gray-300">Nomor Telepon ALN
                                            :</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                class="form-input col-sm-9 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                value="{{ $ite->user->phone }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label dark:text-gray-300">Tanggal :</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                class="form-input col-sm-9 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                                value="{{ $ite->created_at->translatedFormat('l, d F Y - H:i:s') }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label dark:text-gray-300">Status :</label>
                                        <div class="col-sm-5">
                                            @if ($item->status == 'Belum di Proses')
                                                <span
                                                    class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-md dark:text-red-100 dark:bg-red-700">
                                                    {{ $item->status }}
                                                </span>
                                            @elseif ($item->status == 'Sedang di Proses')
                                                <span
                                                    class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-md dark:text-white dark:bg-orange-600">
                                                    {{ $item->status }}
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md dark:bg-green-700 dark:text-green-100">
                                                    {{ $item->status }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </ul>
                                <h3 class="my-3 dark:text-gray-300">Deskripsi Pengaduan</h3>
                                <textarea class="form-input col-sm-9 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700" name="description"
                                    rows="4" disabled>{{ $item->description }}</textarea>
                                <h3 class="my-3 font-semibold dark:text-gray-300">Tanggapan</h3>
                                <p class="text-gray-800 dark:text-gray-400">

                                    @if (empty($tangap->tanggapan))
                                        Belum ada tanggapan
                                    @else
                                        {{ $tangap->tanggapan }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="flex justify-center my-4">
                    <a href="{{ url('admin/pengaduan/cetak', $item->id) }}"
                        class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                        Export ke PDF
                    </a>
                </div>
                <div class="flex justify-center my-6">
                    <a href="{{ route('tanggapan.show', $item->id) }}"
                        class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                        Berikan Tanggapan
                    </a>
                </div>
            </div>

    </main>
@endsection
