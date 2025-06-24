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
<div class = "col">
    <h2 class="page-title">
        Bienvenido {{ Auth::user()->nombre }} a tu panel de control
        <br>
    </h2>
     <small class="text-muted">Rol[{{ Auth::user()->rol }}]</small>
</div>
@stop

@section('content')
<div class="ui grid">
    <div class="eight wide column">
        <div class="ui segment">
            <h4 class="ui header">Ventas Mensuales</h4>
            <canvas id="ventasMensualesChart"></canvas>
        </div>
    </div>
    <div class="eight wide column">
        <div class="ui segment">
            <h4 class="ui header">Usuarios Registrados</h4>
            <canvas id="usuariosRegistradosChart"></canvas>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ejemplo de datos, reemplaza con tus datos reales
    const ventasMensualesData = {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
        datasets: [{
            label: 'Ventas',
            data: [120, 150, 180, 90, 200, 170],
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2
        }]
    };

    const usuariosRegistradosData = {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
        datasets: [{
            label: 'Usuarios',
            data: [30, 45, 60, 40, 80, 70],
            backgroundColor: 'rgba(255, 206, 86, 0.5)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 2
        }]
    };

    new Chart(document.getElementById('ventasMensualesChart'), {
        type: 'bar',
        data: ventasMensualesData,
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    new Chart(document.getElementById('usuariosRegistradosChart'), {
        type: 'line',
        data: usuariosRegistradosData,
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
});
</script>
@endsection
  



@endsection

@section('scripts')
<script>
    // Scripts adicionales si los necesitas
    document.addEventListener('DOMContentLoaded', function() {
        // Inicialización de elementos si es necesario
    });
</script>
@endsection