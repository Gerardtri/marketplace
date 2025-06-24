@extends('layout')
@section('styles')
<link rel="stylesheet" href="{{ url('css/lightbox.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .error {
        color: red;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
    .img-category {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ccc;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    .actions-column {
        white-space: nowrap;
    }
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection

@section('title')
   Editar categoría
@stop

@section('header')
<div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title">
                Editar categoría
            </h2>
            <div class="page-subtitle">         
                Aquí puedes editar los detalles de la categoría.
            </div>  
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="{{ route('categorias.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Volver a categorías
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="card-body">
                <form action="{{ route('categorias.update', $categoria->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" 
                               placeholder="Ej: Nombre de la categoría" 
                               value="{{ old('nombre', $categoria->nombre) }}">
                        @error('nombre')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Slug</label>
                            <input class="form-control" name="slug" id="slug" 
                                   placeholder="Ej: nombre-de-la-categoria" 
                                   value="{{ old('slug', $categoria->slug) }}">
                            @error('slug')
                                <div class="error">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="estado">
                                <option value="nuevo" {{ $categoria->estado == 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                                <option value="usado" {{ $categoria->estado == 'usado' ? 'selected' : '' }}>Usado</option>
                                <option value="seminuevo" {{ $categoria->estado == 'seminuevo' ? 'selected' : '' }}>Seminuevo</option>
                                <option value="reacondicionado" {{ $categoria->estado == 'reacondicionado' ? 'selected' : '' }}>Reacondicionado</option>
                                
                            </select>
                            @error('estado')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            @if($categoria->imagen)
                                <img src="{{ url($categoria->imagen) }}" class="img-category" alt="Imagen de la categoría">
                            @endif
                            
                            <label class="form-label">Imagen</label>
                            <input type="file" class="form-control" name="imagen" accept="image/*">
                      
                            @error('imagen')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" rows="3" name="descripcion">{{ old('descripcion', $categoria->descripcion) }}</textarea> 
                        @error('descripcion')
                            <div class="error">{{ $message }}</div>
                        @enderror 
                    </div>

                    <div class="form-footer">
                        <button type="button" onclick="window.location.href='{{ route('categorias.index') }}'" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left"></i> Volver
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ url('js/lightbox-plus-jquery.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nombreInput = document.getElementById('nombre');
    const slugInput = document.getElementById('slug');
    let slugManuallyEdited = false;

    nombreInput.addEventListener('input', function() {
        if (!slugManuallyEdited) {
            const slug = generateSlug(this.value);
            slugInput.value = slug;
        }
    });

    slugInput.addEventListener('change', function() {
        slugManuallyEdited = this.value !== generateSlug(nombreInput.value);
    });

    function generateSlug(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }

    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        });
    }
});
</script>
@endsection