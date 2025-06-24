@extends('layout')
@section('styles')
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
   
@stop

@section('content')
@if (session('message'))
    <div class="alert alert-{{ session('type') }}">
        {{ session('message') }}
    </div>
@endif 

    
    @if(session('message'))
    <div class = "alert alert-{{ session ('type')}} ">
        {{session('message')}}
    </div>
    @endif


    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lista de Categorías</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-report">
            <i class="fas fa-plus"></i>Nueva Categoría
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $categoria)
                    <tr>
                        <td>
                            @if ($categoria->imagen)
                                <a href="{{ url( $categoria->imagen) }}" data-lightbox="{{ $categoria->nombre }}" data-title="{{ $categoria->nombre }}">
                                    <img src="{{ url( $categoria->imagen) }}" class="img-category">
                                </a>
                            @else
                                <a href="{{ url('img/categorias/avatar.png') }}" data-lightbox="{{ $categoria->nombre }}" data-title="{{ $categoria->nombre }}">
                                    <img src="{{ url('img/categorias/avatar.png') }}" class="img-category">
                                </a>
                            @endif
                        </td>
                        <td>{{ $categoria->nombre }}</td>
                        <td>{{ $categoria->slug }}</td>
                        <td>{{ Str::limit($categoria->descripcion, 50) }}</td>
                        <td>
                            @if($categoria->estado)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </td>
                        <td class="actions-column">
                            <a href="{{ url('categorias/'. $categoria->id .'/edit') }}" class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta categoría?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('modals')
    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Nueva categoría</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ej: Nombre de la categoría" autofocus value="{{ old('nombre') }}">
                            @error ('nombre')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Slug</label>
                                <input class="form-control" name="slug" id="slug" placeholder="Ej: nombre-de-la-categoria" value="{{ old('slug') }}">
                                @error ('slug')
                                    <div class="error">{{ $message }}</div> 
                                @enderror
                            </div>

                            <div class="col-lg-6 mb-3">

                                </select>
                                @error ('estado')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Imagen</label>
                                <input type="file" class="form-control" name="imagen" accept="image/*">
                                @error ('imagen')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" rows="3" name="descripcion">{{ old('descripcion') }}</textarea> 
                            @error ('descripcion')
                                <div class="error">{{ $message }}</div>
                            @enderror 
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                    </div>
                </form>
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