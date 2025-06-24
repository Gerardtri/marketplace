@extends('layout')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Estilos generales */
    .error {
        color: red;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
    
    .actions-column {
        white-space: nowrap;
    }
    
    .badge {
        font-size: 0.9em;
        padding: 0.35em 0.65em;
    }
    
    /* Eliminar bordes de Semantic UI */
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
        background-color: #f8f9fa;
    }
    
    /* Estilos para la contraseña */
    .password-field {
        font-family: monospace;
        font-size: 0.9em;
        color: #6c757d;
    }
</style>
@endsection

@section('title')
   Lista de Usuarios
@stop

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lista de Usuarios</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-usuario">
            <i class="fas fa-user-plus"></i> Nuevo Usuario
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Móvil</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $usuario)
                    <tr>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->movil ?? 'N/A' }}</td>
                        <td>{{ $usuario->email }}</td>
                       
                        <td>
                            @if($usuario->estado)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">{{ ucfirst($usuario->rol) }}</span>
                        </td>
                        <td class="actions-column">
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este usuario?');">
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

    <!-- Modal para nuevo usuario -->
    <div class="modal fade" id="modal-usuario" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="movil" class="form-label">Teléfono Móvil</label>
                                <input type="tel" class="form-control" id="movil" name="movil">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="rol" class="form-label">Rol</label>
                                <select class="form-select" id="rol" name="rol" required>
                                    <option value="admin">Administrador</option>
                                    <option value="user" selected>Usuario</option>
                                    <option value="editor">Editor</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="estado" name="estado" value="1" checked>
                                <label class="form-check-label" for="estado">
                                    Usuario Activo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Inicialización de tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection