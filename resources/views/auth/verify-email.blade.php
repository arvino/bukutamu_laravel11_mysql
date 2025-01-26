@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Verifikasi Email Anda</h5>
                </div>

                <div class="card-body">
                    @if (app()->environment('local'))
                        <div class="alert alert-info">
                            <strong>Development Mode:</strong><br>
                            Cek storage/logs/laravel.log untuk link verifikasi<br>
                            Atau kunjungi: <a href="{{ route('dev.verify', auth()->id()) }}">Verifikasi Langsung</a>
                        </div>
                    @endif

                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Link verifikasi baru telah dikirim ke email Anda.
                        </div>
                    @endif

                    <p>
                        Sebelum melanjutkan, silakan periksa email Anda untuk link verifikasi.
                        Jika Anda tidak menerima email tersebut,
                    </p>

                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Kirim Ulang Link Verifikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 