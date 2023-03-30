@extends('layouts.admin')

@section('title')
Data Pengaduan
@endsection

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Pengaduan Nasabah
        </h2>

        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-md">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-lg bg-clip-border">
                <div class="table-responsive shadow-md dark:bg-gray-700 dark:text-gray-300 py-4 px-4">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }} </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <table class="table table-borderless w-full whitespace-no-wrap text-slate-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 pengaduan-list">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-6 py-2 text-sm dark:text-gray-300">Berkas</th>
                                <th class="px-6 py-2 text-sm dark:text-gray-300">Nomor Rekening Nasabah</th>
                                <th class="px-6 py-2 text-sm dark:text-gray-300">Nama Nasabah</th>
                                <th class="px-6 py-2 text-sm dark:text-gray-300">Jenis Pengaduan</th>
                                <th class="px-6 py-2 text-sm dark:text-gray-300">Tanggal</th>
                                <th class="px-6 py-2 text-sm dark:text-gray-300">Status</th>
                                <th class="px-6 py-2 text-sm dark:text-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 text-sm">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('after-script')
<script type="text/javascript">
    $(function() {
        var table = $('.pengaduan-list').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pengaduans.index') }}",
            order: [
                [4, 'desc']
            ],
            columns: [{
                    data: 'berkas',
                    name: 'berkas',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'norek_nasabah',
                    name: 'norek_nasabah'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'jenis_pengaduan',
                    name: 'jenis_pengaduan'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });
    });
</script>
@endpush
