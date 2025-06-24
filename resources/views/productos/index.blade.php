@extends('layout')
@section('title')
   Lista de Productos
@stop
@section('content')
    <table class="ui celled table">
        <thead>
            <tr>
                <th>id</th>
                <th>nombre</th>              
                <th>Slug</th>  
                <th>descripcion</th>
                <th>valor</th>            
                <th>imagen</th>
                <th>estado</th>
                <th>estado_producto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $categoria)
                <tr>
                    <td>{{ $categoria->id }}</td>
                    <td>{{ $categoria->nombre }}</td>
                    <td>{{ $categoria->slug }}</td>
                    <td>{{ $categoria->descripcion }}</td>
                    <td>{{ $categoria->valor }}</td>
                    <td>
                        @if($categoria->imagen)
                            <img src="{{ asset('storage/' . $categoria->imagen) }}" alt="Imagen de {{ $categoria->nombre }}" style="width: 50px; height: 50px;">
                        @else
                            No hay imagen
                        @endif
                    </td>
                    <td>
                        @if($categoria->estado)
                            Activo
                        @else
                            Inactivo
                        @endif
                    </td>
                    <td>
                        {{ $categoria->estado_producto ?? 'N/A' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection


@section('modals')
    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Nueva categoría</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ej: Nombre de la categoría" autofocus>
              </div>
             
              <div class="row">
                <div class="col-lg-6 mb-3">
                  <label class="form-label">Slug</label>
                  <input class="form-control" name="slug" id="slug" placeholder="Ej: slug-de-la-categoria">
                </div>
                
                <div class="col-lg-6 mb-3">
                  <label class="form-label">Imagen</label>
                  <input type="file" class="form-control" name="imagen" accept="image/*">
                </div>
              </div>
              
              <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" rows="3" name="descripcion"></textarea>
              </div>
            </div>
            
            <div class="modal-footer">
              <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                Cancelar
              </button>
              <button type="submit" class="btn btn-primary ms-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M12 5l0 14" />
                  <path d="M5 12l14 0" />
                </svg>
                Enviar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
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
});
</script>
@endsection
