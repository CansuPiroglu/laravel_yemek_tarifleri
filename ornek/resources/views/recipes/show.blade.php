@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid pt-4 pb-5 mb-5">

            <div class="row mb-3">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Tarif Detayı</h4>
                        <div>
                            <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-sm btn-warning me-2">
                                <i class="las la-pen"></i> Düzenle
                            </a>
                            <a href="{{ route('recipes.index') }}" class="btn btn-sm btn-light">
                                <i class="las la-arrow-left"></i> Listeye Dön
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">

                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-4 mt-3">
                                @if($recipe->image_path)
                                    {{-- Eğer veritabanında resim varsa, storage köprüsünden onu getir --}}
                                    <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="img-fluid rounded shadow-sm mb-3" style="max-height: 250px; width: 100%; object-fit: cover;">
                                @else
                                    {{-- Resim yoksa eski otomatik görseli göster --}}
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($recipe->title) }}&background=random&color=fff&size=120" alt="Recipe Image" class="rounded-circle shadow-sm mb-3">
                                @endif
                                <h4 class="mb-0 fw-bold">{{ $recipe->title }}</h4>
                                <span class="badge bg-soft-info text-info mt-2 px-3 py-2">
                                    {{ $recipe->category ? $recipe->category->name : 'Kategorisiz' }}
                                </span>
                            </div>

                            <ul class="list-group list-group-flush mb-0">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="text-muted"><i class="las la-clock fs-20 me-1 align-middle"></i> Hazırlama</span>
                                    <span class="fw-semibold">{{ $recipe->prep_time }} dk</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="text-muted"><i class="las la-fire fs-20 me-1 align-middle"></i> Pişirme</span>
                                    <span class="fw-semibold">{{ $recipe->cook_time }} dk</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="text-muted"><i class="las la-user-friends fs-20 me-1 align-middle"></i> Porsiyon</span>
                                    <span class="fw-semibold">{{ $recipe->servings }} Kişilik</span>
                                </li>
                            </ul>
                            <div class="mt-3 pt-3 border-top">
                                <button type="button" class="btn btn-sm btn-soft-danger w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#addToListModal">
                                    <i class="las la-bookmark fs-16 align-middle me-1"></i> Koleksiyona Ekle
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Malzemeler</h4>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Malzemeler</h4>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('recipes.ingredients.store', $recipe->id) }}" method="POST" class="mb-4 bg-light p-3 rounded">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-12 mb-1">
                                        <label class="form-label mb-0 fs-12 text-muted">Malzeme Adı</label>
                                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Örn: Domates" required>
                                    </div>

                                    <div class="col-5">
                                        <label class="form-label mb-0 fs-12 text-muted">Miktar</label>
                                        <input type="number" step="0.1" name="quantity" class="form-control form-control-sm" placeholder="Örn: 2" required>
                                    </div>
                                    <div class="col-5">
                                        <label class="form-label mb-0 fs-12 text-muted">Birim</label>
                                        <input type="text" name="unit" class="form-control form-control-sm" placeholder="Örn: Adet" required>
                                    </div>
                                    <div class="col-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-sm btn-primary w-100"><i class="las la-plus"></i></button>
                                    </div>
                                </div>
                            </form>

                            <hr>

                            @if($recipe->ingredients->isEmpty())
                                <div class="alert alert-light border-0 text-center text-muted" role="alert">
                                    Henüz malzeme eklenmemiş.
                                </div>
                            @else
                                <ul class="list-unstyled mb-0">
                                    @foreach($recipe->ingredients as $ingredient)
                                        <li class="mb-2 border-bottom pb-2">
                                            <i class="las la-check-circle text-success me-2 fs-18 align-middle"></i>
                                            <span class="fw-bold text-dark">{{ (float)$ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}</span>
                                            <span class="text-muted">{{ $ingredient->name }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tarif Hakkında</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-0 lh-lg">{{ $recipe->description }}</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Adım Adım Yapılışı</h4>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('recipes.steps.store', $recipe->id) }}" method="POST" class="mb-4 bg-light p-3 rounded">
                                @csrf
                                <div class="row g-2 align-items-start">
                                    <div class="col-md-2">
                                        <label class="form-label mb-0 fs-12 text-muted">Adım No</label>
                                        <input type="number" name="step_number" class="form-control form-control-sm" value="{{ $recipe->steps->count() + 1 }}" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label mb-0 fs-12 text-muted">Ne Yapılacak?</label>
                                        <textarea name="instruction" class="form-control form-control-sm" rows="2" placeholder="Örn: Soğanları ince ince doğrayıp pembeleşinceye kadar kavurun." required></textarea>
                                    </div>
                                    <div class="col-md-2 mt-auto">
                                        <button type="submit" class="btn btn-sm btn-primary w-100"><i class="las la-plus"></i> Ekle</button>
                                    </div>
                                </div>
                            </form>

                            <hr>

                            @if($recipe->steps->isEmpty())
                                <div class="alert alert-light border-0 text-center text-muted" role="alert">
                                    Henüz hazırlama adımı eklenmemiş.
                                </div>
                            @else
                                <div class="timeline">
                                    @foreach($recipe->steps as $step)
                                        <div class="d-flex mb-4">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-md">
                                <span class="avatar-title bg-soft-primary text-primary rounded-circle fw-bold fs-18 shadow-sm">
                                    {{ $step->step_number }}
                                </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3 mt-2">
                                                <p class="text-muted mb-0 lh-lg">{{ $step->instruction }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div> <div class="card mt-3">
                        <div class="card-header bg-white border-bottom-0 pb-0">
                            <h4 class="card-title">Yorumlar ({{ $recipe->reviews->count() }})</h4>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('recipes.reviews.store', $recipe->id) }}" method="POST" class="mb-4 bg-light p-3 rounded border border-light">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <label class="form-label fs-12 text-muted mb-1">Puanınız</label>
                                        <select name="rating" class="form-select form-select-sm text-warning fw-bold" required>
                                            <option value="5">★★★★★ (5)</option>
                                            <option value="4">★★★★☆ (4)</option>
                                            <option value="3">★★★☆☆ (3)</option>
                                            <option value="2">★★☆☆☆ (2)</option>
                                            <option value="1">★☆☆☆☆ (1)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-7 mb-2 mb-md-0">
                                        <label class="form-label fs-12 text-muted mb-1">Yorumunuz</label>
                                        <textarea name="comment" class="form-control form-control-sm" rows="1" placeholder="Bu tarif hakkında ne düşünüyorsunuz?" required></textarea>
                                    </div>
                                    <div class="col-md-2 mt-auto">
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Gönder</button>
                                    </div>
                                </div>
                            </form>

                            @if($recipe->reviews->isEmpty())
                                <div class="text-center text-muted py-3">
                                    <i class="las la-comment-slash fs-1 mb-2"></i>
                                    <p class="mb-0">İlk yorumu siz yapın!</p>
                                </div>
                            @else
                                <div class="review-list mt-4">
                                    @foreach($recipe->reviews as $review)
                                        <div class="d-flex mb-3 border-bottom pb-3">
                                            <div class="flex-shrink-0">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user ? $review->user->name : 'Misafir') }}&background=random&color=fff&size=40" class="rounded-circle shadow-sm" alt="User">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="m-0 fw-semibold">{{ $review->user ? $review->user->name : 'Gizemli Şef' }}</h6>
                                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                                </div>
                                                <div class="text-warning mb-1" style="font-size: 14px;">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating) ★ @else ☆ @endif
                                                    @endfor
                                                </div>
                                                <p class="text-muted mb-0 fs-13">{{ $review->comment }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addToListModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-blue">
                        <h5 class="modal-title fw-bold">Tarifi Koleksiyona Kaydet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('recipes.toggle-list', $recipe->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <h6 class="fs-13 text-muted mb-3">Mevcut Listelerinize Ekleyin:</h6>
                            <div class="list-group mb-4">
                                @php
                                    // Şimdilik 1 numaralı kullanıcının listelerini çekiyoruz
                                    $userLists = \App\Models\RecipeList::where('user_id', 1)->get();
                                @endphp

                                @forelse($userLists as $list)
                                    <label class="list-group-item d-flex justify-content-between align-items-center bg-light-alt border-dashed mb-2 rounded">
                                        <div class="fw-medium">
                                            <input class="form-check-input me-2" type="radio" name="list_id" value="{{ $list->id }}">
                                            {{ $list->name }}
                                        </div>
                                        <span class="badge bg-soft-primary text-primary rounded-pill">{{ $list->recipes->count() }} Tarif</span>
                                    </label>
                                @empty
                                    <p class="text-muted fs-13 text-center mb-0">Henüz hiç listeniz yok.</p>
                                @endforelse
                            </div>

                            <hr class="border-dashed">

                            <h6 class="fs-13 text-muted mb-2">Veya Yeni Liste Oluşturun:</h6>
                            <input type="text" name="list_name" class="form-control" placeholder="Örn: Hafta Sonu Tatlıları">
                        </div>
                        <div class="modal-footer bg-light border-0">
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
