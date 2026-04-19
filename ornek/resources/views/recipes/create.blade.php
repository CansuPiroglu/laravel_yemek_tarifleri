@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Yeni Tarif Ekle</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('recipes.index') }}">Tarifler</a></li>
                                <li class="breadcrumb-item active">Yeni Ekle</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tarif Detayları</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <label class="form-label">Tarif Adı</label>
                                        <input type="text" name="title" class="form-control" placeholder="Örn: Fırında Sütlaç" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Kategori</label>
                                        <select name="category_id" class="form-select">
                                            <option value="">Kategori Seçin...</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tarif Görseli</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tarif Açıklaması / Yapılışı</label>
                                    <textarea name="description" class="form-control" rows="5" placeholder="Adım adım yapılışını anlatın..." required></textarea>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Hazırlama Süresi <small class="text-muted">(Dk)</small></label>
                                        <input type="number" name="prep_time" class="form-control" placeholder="Örn: 15" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Pişirme Süresi <small class="text-muted">(Dk)</small></label>
                                        <input type="number" name="cook_time" class="form-control" placeholder="Örn: 40" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Kaç Kişilik <small class="text-muted">(Porsiyon)</small></label>
                                        <input type="number" name="servings" class="form-control" placeholder="Örn: 4" required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('recipes.index') }}" class="btn btn-soft-danger me-2">İptal</a>
                                    <button type="submit" class="btn btn-primary">Kaydet</button>
                                </div>
                            </form>
                        </div></div></div></div></div></div>@endsection
