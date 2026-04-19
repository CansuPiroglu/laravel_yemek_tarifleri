@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid pt-4 pb-5">

            <div class="row mb-3">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Koleksiyonlarım</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('recipes.index') }}">Tarifler</a></li>
                            <li class="breadcrumb-item active">Koleksiyonlar</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="row">
                @forelse($collections as $collection)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 shadow-sm border-0 transition-hover">
                            <div class="card-body text-center p-4">
                                <div class="avatar-lg mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary fs-24 shadow-sm">
                                        <i class="las la-bookmark"></i>
                                    </span>
                                </div>
                                <h5 class="mb-1 text-dark fw-bold">{{ $collection->name }}</h5>
                                <p class="text-muted fs-13 mb-3">{{ $collection->recipes_count }} Tarif Kaydedildi</p>
                                <a href="{{ route('collections.show', $collection->id) }}" class="btn btn-sm btn-outline-primary w-100 rounded-pill">
                                    İçine Bak
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="las la-folder-open text-muted" style="font-size: 64px;"></i>
                        <h5 class="mt-3 text-dark">Henüz Bir Koleksiyonunuz Yok</h5>
                        <p class="text-muted">Tarif detay sayfasından sevdiğiniz tarifleri kaydederek koleksiyon oluşturabilirsiniz.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection
