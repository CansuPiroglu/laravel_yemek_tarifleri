@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid pt-4 pb-5">
        
        <!-- Sayfa Başlığı -->
        <div class="row mb-4">
            <div class="col-sm-12">
                <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                    <div>
                        <h4 class="page-title d-flex align-items-center">
                            <i class="las la-robot text-primary fs-2 me-2"></i> AI Tariflerim
                        </h4>
                        <p class="text-muted mb-0 mt-1">Yapay zeka şefine ürettirip kaydettiğin tüm özel tarifler burada.</p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <a href="{{ route('ai.chef.index') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="las la-plus me-1"></i> Yeni Tarif Ürettir
                        </a>
                        <a href="{{ route('collections.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm ms-2">
                            Geri Dön
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarifler Listesi -->
        @if($aiRecipes->isEmpty())
            <div class="text-center py-5 bg-white rounded-4 shadow-sm border mt-3">
                <span class="display-1 text-muted"><i class="las la-folder-open"></i></span>
                <h4 class="mt-4 text-dark fw-bold">Henüz hiç AI tarifi kaydetmedin.</h4>
                <p class="text-muted">Hemen mutfağa dön ve elindeki malzemelerle harikalar yarat!</p>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($aiRecipes as $recipe)
                    <div class="col">
                        <!-- position-relative eklendi ki silme butonu sağ üste tam otursun -->
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden transition-hover position-relative">
                            
                            <!-- 🔴 SİLME BUTONU (Sağ Üst Köşe Sabit) 🔴 -->
                            <div class="position-absolute top-0 end-0 p-3" style="z-index: 10;">
                                <form action="{{ route('ai.chef.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('Bu tarifi koleksiyonunuzdan silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Tarifi Sil">
                                        <i class="las la-trash-alt fs-5"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Yemeğin Resmi -->
                            @if($recipe->image_url)
                                <img src="{{ $recipe->image_url }}" class="card-img-top object-fit-cover" style="height: 220px;" alt="{{ $recipe->title }}">
                            @endif
                            
                            
                            <div class="card-body p-4 bg-white text-center">
                                <div class="badge bg-soft-primary text-primary mb-3 rounded-pill px-3 py-2">
                                    <i class="las la-magic me-1"></i> AI Üretimi
                                </div>
                                <h5 class="card-title fw-bold text-dark mb-3" style="min-height: 48px;">{{ $recipe->title }}</h5>
                                
                                <!-- İçeriğin sadece bir kısmını gösteriyoruz -->
                                <div class="text-muted mb-4 text-start" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; font-size: 0.9rem;">
                                    {!! Str::markdown($recipe->content) !!}
                                </div>
                                
                                <!-- Detayları Görmek İçin Modal Tetikleyici Buton -->
                                <button type="button" class="btn btn-outline-primary w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#recipeModal{{ $recipe->id }}">
                                    Tarifin Tamamını Oku
                                </button>
                            </div>
                            
                            <div class="card-footer bg-white border-top-0 text-muted text-center pb-3 pt-0" style="font-size: 0.8rem;">
                                {{ $recipe->created_at->format('d.m.Y H:i') }} tarihinde kaydedildi
                            </div>
                        </div>
                    </div>

                    <!-- Her Tarif İçin Gizli Okuma Modalı (Açılır Pencere) -->
                    <div class="modal fade" id="recipeModal{{ $recipe->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content rounded-4 border-0 shadow-lg">
                                <div class="modal-header bg-white border-bottom-0 pb-0 pt-4 px-4">
                                    <h5 class="modal-title text-dark fw-bold fs-4 d-flex align-items-center">
                                        <i class="las la-robot me-2 fs-2"></i> {{ $recipe->title }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4 p-md-5 pt-3">
                                    @if($recipe->image_url)
                                        <img src="{{ $recipe->image_url }}" class="img-fluid rounded-4 mb-4 w-100 object-fit-cover shadow-sm" style="max-height: 400px;" alt="Recipe Image">
                                    @endif
                                    <div class="recipe-text text-dark prose prose-zinc max-w-none" style="font-size: 1.05rem; line-height: 1.8;">
                                        {!! Str::markdown($recipe->content) !!}
                                    </div>
                                </div>
                                <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Kapat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

<style>
    /* Modal içindeki ve kartlardaki markdown yazılarının düzgün görünmesi için CSS ayarları */
    .recipe-text h1, .recipe-text h2, .recipe-text h3 { color: #2c3e50; font-weight: 700; margin-top: 1.5rem; margin-bottom: 1rem; font-size: 1.4rem; }
    .recipe-text ul, .recipe-text ol { padding-left: 1.5rem; margin-bottom: 1.5rem; }
    .recipe-text li { margin-bottom: 0.5rem; }
    .object-fit-cover { object-fit: cover; }
    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
</style>
@endsection