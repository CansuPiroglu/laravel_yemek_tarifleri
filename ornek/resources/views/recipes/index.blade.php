@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Yemek Tarifleri</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                                <li class="breadcrumb-item active">Tarifler</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Tarif Listesi</h4>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('recipes.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i> Yeni Tarif Ekle
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tarif Adı</th>
                                        <th>Kategori</th>
                                        <th>Süre (Haz/Piş)</th>
                                        <th>Kaç Kişilik</th>
                                        <th class="text-end">İşlemler</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-body bg-light rounded">
                                            <form action="{{ route('recipes.index') }}" method="GET">
                                                <div class="row g-3 align-items-end">

                                                    <div class="col-md-6">
                                                        <label for="search" class="form-label fw-bold text-muted mb-1">Tarif Ara</label>
                                                        <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                                                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control border-start-0" placeholder="Örn: Mercimek Çorbası...">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="category" class="form-label fw-bold text-muted mb-1">Kategori Filtrele</label>
                                                        <select name="category" id="category" class="form-select">
                                                            <option value="">Tüm Kategoriler</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2 d-flex gap-2">
                                                        <button type="submit" class="btn btn-primary w-100 flex-grow-1">
                                                            Araştır
                                                        </button>

                                                        @if(request('search') || request('category'))
                                                            <a href="{{ route('recipes.index') }}" class="btn btn-outline-secondary">
                                                                Temizle
                                                            </a>
                                                        @endif
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @foreach($recipes as $recipe)
                                        <tr>
                                            <td class="fw-medium align-middle">{{ $recipe->id }}</td>

                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    @if($recipe->image_path)
                                                        <img src="{{ asset('storage/' . $recipe->image_path) }}" class="me-3 rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover;" alt="{{ $recipe->title }}">
                                                    @else
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($recipe->title) }}&background=random&color=fff&size=45"
                                                             class="me-3 rounded shadow-sm" style="width: 45px; height: 45px;" alt="Varsayılan Görsel">
                                                    @endif
                                                    <div class="flex-grow-1 text-truncate">
                                                        <h6 class="m-0 fw-semibold text-dark">{{ $recipe->title }}</h6>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle">
                                                <span class="badge bg-soft-info text-info px-2 py-1">
                                                    {{ $recipe->category ? $recipe->category->name : 'Kategorisiz' }}
                                                </span>
                                            </td>
                                            <td class="align-middle">{{ $recipe->prep_time }}dk / {{ $recipe->cook_time }}dk</td>
                                            <td class="align-middle">{{ $recipe->servings }} Kişi</td>

                                            <td class="text-end align-middle">
                                                <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-sm btn-soft-info">
                                                    <i class="las la-eye"></i> İncele
                                                </a>
                                                <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-sm btn-soft-warning mx-1">
                                                    <i class="las la-pen"></i> Düzenle
                                                </a>
                                                <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-soft-danger" onclick="return confirm('Bu tarifi silmek istediğinize emin misiniz?')">
                                                        <i class="las la-trash-alt"></i> Sil
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if($recipes->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Henüz hiç tarif eklenmemiş.</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div></div></div></div></div></div>@endsection
