@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid pt-4 pb-5">

            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">

                    <div class="text-center mb-5 p-4">
                        <div class="avatar-lg mx-auto mb-3">
                        <span class="avatar-title bg-soft-primary text-primary rounded-circle fs-1 display-5 shadow-sm">
                            👨‍🍳
                        </span>
                        </div>
                        <h1 class="fw-extrabold text-dark display-6">Ne Pişirsem? (AI Şef)</h1>
                        <p class="text-muted text-lg mx-auto" style="max-w: 600px;">Evdeki malzemelerinizi yazın, yapay zeka size anında harika bir tarif önersin!</p>
                    </div>

                    <div class="card shadow border-0 rounded-4 mb-4">
                        <div class="card-body p-4 p-md-5">
                            <form action="{{ route('ai.chef.generate') }}" method="POST" id="aiChefForm">
                                @csrf
                                <div class="mb-4">
                                    <label for="ingredients" class="form-label fw-bold text-muted text-uppercase tracking-wider">Elinizdeki Malzemeler</label>
                                    <textarea name="ingredients" id="ingredients" rows="4" class="form-control form-control-lg bg-light border-0 shadow-inner rounded-3" placeholder="Örn: 2 adet tavuk göğsü, krema, mantar, sarımsak, makarna..." required>{{ request('ingredients') }}</textarea>
                                    <div class="form-text mt-3 text-info d-flex align-items-center">
                                        <i class="las la-info-circle fs-4 me-2"></i> Miktarları ne kadar detaylı yazarsanız, şefimiz o kadar iyi sonuç verir.
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 fw-bold py-3 text-uppercase tracking-wider shadow rounded-3 btn-lg d-flex align-items-center justify-content-center" id="submitBtn">
                                <span class="btn-text">
                                    <i class="las la-magic me-2 fs-4"></i>AI Şef'e Tarif Ürettir
                                </span>
                                    <span class="spinner-text d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    AI Şef Düşünüyor...
                                </span>
                                </button>
                            </form>
                        </div>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger shadow-sm rounded-3">
                            <i class="las la-exclamation-triangle fs-4 me-2 align-middle"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                </div>
            </div>

            @if(isset($recipeContent))
                <div class="row justify-content-center mt-3">
                    <div class="col-12 col-lg-11 col-xl-10">

                        <div class="card shadow-lg border-0 rounded-4 result-card overflow-hidden">
                            <div class="card-body p-4 p-lg-5 bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                                    <div class="d-flex align-items-center">
                                        <span class="fs-1 me-3">✨</span>
                                        <h3 class="fw-bold text-dark mb-0 fs-3">Şefin Özel Tarifi</h3>
                                    </div>
                                    <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill shadow-sm fs-6">AI Üretimi</span>
                                </div>

                                <div class="clearfix recipe-text text-dark" style="font-size: 1.1rem; line-height: 1.8;">
                                    <img src="{{ $imageUrl }}"
                                         class="float-md-start mb-4 me-md-4 rounded-4 shadow-sm"
                                         style="width: 350px; height: 350px; object-fit: cover;"
                                         alt="Önerilen Tarif">

                                    {!! Str::markdown($recipeContent) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <style>
                    .recipe-text h1, .recipe-text h2, .recipe-text h3 {
                        color: #2c3e50;
                        font-weight: 700;
                        margin-top: 0;
                        margin-bottom: 1rem;
                        font-size: 1.75rem;
                    }
                    .recipe-text ul, .recipe-text ol {
                        padding-left: 1.5rem;
                        margin-bottom: 1.5rem;
                    }
                    .recipe-text li {
                        margin-bottom: 0.75rem;
                    }
                    .recipe-text p {
                        margin-bottom: 1.25rem;
                    }
                </style>
            @endif

        </div>
    </div>

    <script>
        document.getElementById('aiChefForm').addEventListener('submit', function() {
            var submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.querySelector('.btn-text').classList.add('d-none');
            submitBtn.querySelector('.spinner-text').classList.remove('d-none');
        });
    </script>
@endsection
