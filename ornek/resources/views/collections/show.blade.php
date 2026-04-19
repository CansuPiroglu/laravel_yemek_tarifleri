@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid pt-4 pb-5">

            <div class="row mb-3">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">{{ $collection->name }}</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('collections.index') }}">Koleksiyonlar</a></li>
                            <li class="breadcrumb-item active">{{ $collection->name }}</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h4 class="card-title mb-0">Bu Koleksiyondaki Tarifler</h4>
                    <span class="badge bg-soft-primary text-primary px-2 py-1 fs-12">{{ $collection->recipes->count() }} Tarif</span>
                </div>

                <div class="card-body pt-0">
                    @if($collection->recipes->isEmpty())
                        <div class="text-center py-5">
                            <i class="las la-utensils text-muted mb-2" style="font-size: 48px;"></i>
                            <h5 class="text-dark">Bu koleksiyonda henüz tarif yok.</h5>
                            <p class="text-muted">Tarifler sayfasına giderek bu listeye yeni tarifler ekleyebilirsiniz.</p>
                            <a href="{{ route('recipes.index') }}" class="btn btn-primary mt-2">Tariflere Git</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="border-top-0">Tarif Adı</th>
                                    <th class="border-top-0">Kategori</th>
                                    <th class="border-top-0">Süre</th>
                                    <th class="border-top-0 text-end">İşlem</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($collection->recipes as $recipe)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                @if($recipe->image_path)
                                                    <img src="{{ asset('storage/' . $recipe->image_path) }}" class="me-3 rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover;" alt="{{ $recipe->title }}">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($recipe->title) }}&background=random&color=fff&size=45" class="me-3 rounded shadow-sm" style="width: 45px; height: 45px;">
                                                @endif
                                                <h6 class="m-0 fw-semibold text-dark">{{ $recipe->title }}</h6>
                                            </div>
                                        </td>

                                        <td class="align-middle">
                                                <span class="badge bg-soft-info text-info px-2 py-1">
                                                    {{ $recipe->category ? $recipe->category->name : 'Kategorisiz' }}
                                                </span>
                                        </td>

                                        <td class="align-middle text-muted">
                                            {{ $recipe->prep_time + $recipe->cook_time }} dk
                                        </td>

                                        <td class="text-end align-middle">
                                            <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-sm btn-soft-primary me-1">
                                                <i class="las la-eye"></i> Aç
                                            </a>

                                            <form action="{{ route('recipes.toggle-list', $recipe->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                <input type="hidden" name="list_id" value="{{ $collection->id }}">
                                                <button type="submit" class="btn btn-sm btn-soft-danger" title="Koleksiyondan Çıkar">
                                                    <i class="las la-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
