@extends('admin.layouts.layout')

@section('title')
    Login -
@endsection

@section('body-class')
    auth-bg
@endsection

@push('styles')
    <style>
        body {
            background: url('{{ asset('images/bg-participant.jpg') }}') no-repeat center;
            background-size: cover;
        }

        [data-bs-theme="dark"] body {
            background: url('{{ asset('images/bg-participant.jpg') }}') no-repeat center;
            background-size: cover;
        }
    </style>
@endpush

@section('body')
    <div class="d-flex flex-column flex-center flex-column-fluid">
        <div class="d-flex flex-column flex-center text-center p-10">
            <div class="card card-flush w-lg-650px py-5">
                <div class="card-body py-15 py-lg-20">
                    <form action="{{ route('login.proses') }}" method="post">
                        @csrf
                        <a href="{{ url('/') }}" class=""><img alt="Logo" src="{{ asset('images/logo.png') }}" class="h-70px mb-6"/></a>
                        <h1 class="fw-bolder text-gray-900 mb-2">Login</h1>
                        <div class="fs-6 fw-semibold text-gray-500 mb-10">Login dengan menggunakan akun {{ env('APP_NAME') }}</div>

                        <div class="d-flex flex-column mx-lg-20 mb-6">
                            <x-metronic-input name="email" type="text" caption="Email" placeholder="Email" :viewtype="2" />
                            <x-metronic-input name="password" type="password" caption="Password" placeholder="Password" :viewtype="2" />
                            <div class="d-flex flex-column align-items-start mt-3">
                                <x-checkbox name="remember" caption="Simpan Login" />
                            </div>
                        </div>

                        <div class="d-flex flex-column mx-lg-20 mb-6">
                            <button type="submit" class="btn btn-primary mb-3 ps-8">
                                <i class="ki-duotone ki-entrance-left fs-3 me-0 ms-1"><span class="path1"></span><span class="path2"></span></i>
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
