@extends('layout')

@section('styles')
<style>
    .error {
        color: red;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
    .actions-column {
        white-space: nowrap;
    }
    /* Estilos para eliminar bordes azules de Semantic UI */
    .ui.celled.table {
        border: none !important;
        box-shadow: none !important;
    }
    .ui.celled.table tr td, 
    .ui.celled.table tr th {
        border-left: none !important;
        border-right: none !important;
    }
    .ui.celled.table tr td {
        border-bottom: 1px solid rgba(34,36,38,.1) !important;
    }
    .ui.celled.table thead tr th {
        border-top: none !important;
    }
</style>
@endsection

@section('title')
   
@stop

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lista de Ciudades</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-report">
            <i class="fas fa-plus"></i> Nueva Ciudad
        </button>
    </div>

    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $ciudad)
                <tr>
                    <td>{{ $ciudad->nombre }}</td>
                    <td>
                        @if($ciudad->estado)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td class="actions-column">
                            <a href="{{ route('ciudades.edit', $ciudad->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('ciudades.destroy', $ciudad->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta categoría?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal para nueva ciudad -->
    <div class="modal fade" id="modal-ciudad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('ciudades.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Nueva Ciudad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="estado">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer mt-5 py-3 bg-light">
        <div class="container text-center">
            <p class="mb-0">Todos los derechos reservados &copy; {{ date('Y') }}</p>
        </div>
    </footer>
@endsection

@section('scripts')
<script>
    // Scripts adicionales si los necesitas
    document.addEventListener('DOMContentLoaded', function() {
        // Inicialización de elementos si es necesario
    });
</script>
@endsection