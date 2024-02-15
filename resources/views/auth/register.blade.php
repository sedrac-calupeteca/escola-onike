@extends('layouts.doc')
@section('body')
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class=" d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ asset('img/logo.png') }}" alt="">
                                    <span class="d-none d-lg-block">EscolaOnika</span>
                                </a>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Cadastramento</h5>
                                    </div>

                                    <form class="row g-3 needs-validation" action="{{ route('register') }}" method="POST">
                                        @csrf
                                        @include('components.erros')
                                        @include('components.form.user',[
                                            'hidden_btn' => true
                                        ])
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100 mt-2" type="submit">Cadastrar</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="credits">
                                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

@endsection
