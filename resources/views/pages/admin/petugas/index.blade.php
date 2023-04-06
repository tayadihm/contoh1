@extends('layouts.admin')

@section('title')
    Data Petugas
@endsection

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Data Petugas
            </h2>

            <div class="my-4 mb-6">
                <a href="{{ route('petugas.create') }} "
                    class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-red-600 rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                    Tambah Petugas
                </a>
            </div>
            <div class="w-full mb-8 overflow-hidden rounded-lg shadow-md">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-lg bg-clip-border">
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
                        <table
                            class="table table-borderless w-full whitespace-normal text-slate-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 table-aln">
                            <thead>
                                <tr
                                    class="text-sm font-semibold tracking-wide text-left text-gray-500 border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-6 py-2 dark:text-gray-300">Nama</th>
                                    <th class="px-6 py-2 dark:text-gray-300">No. Karyawan</th>
                                    <th class="px-6 py-2 dark:text-gray-300">No. Hp</th>
                                    <th class="px-6 py-2 dark:text-gray-300">Email</th>
                                    <th class="px-6 py-2 dark:text-gray-300">Kantor Cabang</th>
                                    <th class="px-6 py-2 dark:text-gray-300">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 text-sm">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
    </main>
@endsection

@push('after-script')
    <script type="text/javascript">
        $(function() {
            var table = $('.table-aln').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('petugas.index') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'cabang',
                        name: 'cabang'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                console.log('Button delete clicked');
                var id = $(this).data('id'); // definisikan variabel id
                swal({
                    title: "Apakah Anda yakin?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $('form.form-delete[data-id="' + id + '"]').submit();
                    }
                });
            });
        });
    </script>
@endpush
