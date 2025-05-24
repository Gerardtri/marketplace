@extends('layout')
@section('title')
   Lista de Usuarios
@stop
@section('content')
    <table class = " ui celled table" >
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Movil</th>
                <th>Email</th>
                <th>Password</th>
                <th>Estado</th>
                <th>Rol</th>
                <th>Ciudad_id</th>
            </tr> </thead>
            <tbody>
                @foreach ($data as $usuarios)
                <tr>
                    <td>{{ $usuarios->nombre }}</td>
                    <td>{{ $usuarios->movul }}</td>
                    <td>{{ $usuarios->email }}</td>
                    <td>{{ $usuarios->password }}</td>
                    <td>{{ $usuarios->estado }}</td>
                    <td>{{ $usuarios->rol }}</td>
                    <td>{{ $usuarios->ciudad_id }}</td>
                    <td>
                        <a href="{{ route('usuarios.edit', $usuarios->id) }}" class="ui button">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuarios->id) }}" method="POST" style="display:inline;">
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