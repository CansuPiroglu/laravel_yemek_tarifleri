@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid pt-4">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Tarifi Düzenle</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('recipes.index') }}">Tarifler</a></li>
                                <li class="breadcrumb-item active">Düzenle</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">"{{ $recipe->title }}" Tarifini Güncelliyorsunuz</h4>
                        </div>
                        <div class="card-body">
                            {{-- Form action kısmında update rotasına tarifin ID'si ile gidiyoruz --}}
                            <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- HTML formları standart olarak sadece GET ve POST destekler.
                                     Güncelleme (PUT) işlemi için Laravel'in bu sihirli direktifini eklemeliyiz. --}}
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <label class="form-label">Tarif Adı</label>
                                        {{-- value kısmına tarifin mevcut başlığını yazdırıyoruz --}}
                                        <input type="text" name="title" class="form-control" value="{{ $recipe->title }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Kategori</label>
                                        <select name="category_id" class="form-select">
                                            <option value="">Kategori Seçin...</option>
                                            @foreach($categories as $category)
                                                {{-- Eğer döngüdeki kategori, tarifin kendi kategorisiyle eşleşiyorsa onu 'selected' (seçili) yap --}}
                                                <option value="{{ $category->id }}" {{ $recipe->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
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
                                    {{-- Textarea'larda value olmaz, veri iki etiket arasına yazılır --}}
                                    <textarea name="description" class="form-control" rows="5" required>{{ $recipe->description }}</textarea>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Hazırlama Süresi <small class="text-muted">(Dk)</small></label>
                                        <input type="number" name="prep_time" class="form-control" value="{{ $recipe->prep_time }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Pişirme Süresi <small class="text-muted">(Dk)</small></label>
                                        <input type="number" name="cook_time" class="form-control" value="{{ $recipe->cook_time }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Kaç Kişilik <small class="text-muted">(Porsiyon)</small></label>
                                        <input type="number" name="servings" class="form-control" value="{{ $recipe->servings }}" required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('recipes.index') }}" class="btn btn-soft-danger me-2">İptal</a>
                                    <button type="submit" class="btn btn-warning">Değişiklikleri Kaydet</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
