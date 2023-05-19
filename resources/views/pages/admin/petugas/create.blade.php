@extends('layouts.admin')

@section('title')
    Data Petugas
@endsection

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Tambah Petugas
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

            <form action="{{ route('petugas.store') }} " method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-4 py-3 mb-8 bg-gray-100 rounded-lg shadow-md dark:bg-gray-800">

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">No. Karyawan</span>
                        <input
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-red-400 focus:outline-none focus:shadow-outline-red dark:focus:shadow-outline-gray"
                            type="text" placeholder="NIK" value="{{ old('nik') }}" name="nik"></input>
                    </label>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Nama ALN</span>
                        <input
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-red-400 focus:outline-none focus:shadow-outline-red dark:focus:shadow-outline-gray"
                            type="text" placeholder="John Doe" value="{{ old('name') }}" name="name"></input>
                    </label>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Kantor Cabang</span>
                        <input
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-red-400 focus:outline-none focus:shadow-outline-red dark:focus:shadow-outline-gray"
                            type="text" placeholder="KCP Fatmawati" value="{{ old('cabang') }}" name="cabang"></input>
                    </label>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Email</span>
                        <input
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-red-400 focus:outline-none focus:shadow-outline-red dark:focus:shadow-outline-gray"
                            type="email" placeholder="email@email.com" value="{{ old('email') }}" name="email"></input>
                    </label>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">No. Hp</span>
                        <input
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-red-400 focus:outline-none focus:shadow-outline-red dark:focus:shadow-outline-gray"
                            type="text" placeholder="0123456789" value="{{ old('phone') }}" name="phone"></input>
                    </label>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Role</span>
                        <select
                            class="block w-full text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-red-400 focus:outline-none focus:shadow-outline-red dark:focus:shadow-outline-gray"
                            name="roles">
                            <option selected disabled
                                class="text-gray-700 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-700">
                                -Pilih Role-</option>
                            <option value="ADMIN" class="dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">HBL</option>
                            {{-- <option value="USER">Petugas</option> --}}
                        </select>
                    </label>

                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Password</span>
                        <input
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-red-400 focus:outline-none focus:shadow-outline-red dark:focus:shadow-outline-gray"
                            type="password" placeholder="password" value="{{ old('password') }}" name="password"></input>
                    </label>
                    <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Konfirmasi Password</span>
                        <input
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-red-400 focus:outline-none focus:shadow-outline-red dark:focus:shadow-outline-gray"
                            type="password" placeholder="password" value="{{ old('password') }}"
                            name="password_confirmation"></input>
                    </label>


                    <button type="submit"
                        class="mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                        Tambah Petugas
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
