@extends('layouts.masyarakat')

@section('title')
    Data Pengaduan
@endsection
@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Data Pengaduan
            </h2>

            <div class="w-full max-w-full">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="table-responsive dark:bg-gray-700 dark:text-gray-300">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }} </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <table class="table table-flush text-slate-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 pengaduan-masyarakat-list">
                            <thead class="thead-light dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                <tr>
                                    <th class="px-6 py-2 text-md text-gray-500">File</th>
                                    <th class="px-6 py-2 text-md text-gray-500">Jenis Pengaduan</th>
                                    <th class="px-6 py-2 text-md text-gray-500">Tanggal</th>
                                    <th class="px-6 py-2 text-md text-gray-500">Status</th>
                                    <th class="px-6 py-2 text-md text-gray-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                <tr class="font-normal leading-normal text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('after-script')
    <<script type="text/javascript">
        $(function() {
            var table = $('.pengaduan-masyarakat-list').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('masyarakat-lihat') }}",
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        data: 'ktp',
                        name: 'ktp',
                        render: function (data, type, full, meta) {
                            return '<a href="{{ asset('storage') }}/' + data +
                                '" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
                        }
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
