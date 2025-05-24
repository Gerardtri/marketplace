@extends('layout')
@section('title')
   Lista de Ciudades
@stop
@section('content')
    <table class = " ui celled table" >
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr> </thead>
            <tbody>
                @foreach ($data as $categoria)
                <tr>
                    <td>{{ $categoria->nombre }}</td>
                    <td>{{ $categoria->estado }}</td>
                    <td>
                        <a href="{{ route('categorias.edit', $categoria->id) }}" class="ui button">Editar</a>
                        <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ui red button">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
    </table>
  </div>
    <div
    class ="ui inverted vertical footer segment">
      <div class="ui center aligned container">
        <p> Todos los derechos reservados &copy; 2025</p>
        </div>

     



</body></html>
@endsection