<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
      $data = Categoria::all();
      return view('categorias.index', compact('data'));

      

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nombre' => 'required|max:250|unique:categorias,nombre',
        'slug' => 'required|unique:categorias,slug',
        'descripcion' => 'nullable|max:255',
        'imagen' => 'nullable|image',
    ]);

    if ($validator->fails()) {
        return redirect('categorias/create')
            ->withErrors($validator)
            ->withInput();
    }

    $categoria = new Categoria();
    $categoria->nombre = $request->nombre;
    $categoria->slug = $request->slug;
    $categoria->descripcion = $request->descripcion;

    if ($request->hasFile('imagen')) {
        $file = $request->file('imagen');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('imagenes/categorias'), $filename);
        $categoria->imagen = 'imagenes/categorias/' . $filename;
    }

    $categoria->save();

    return redirect('categorias')
        ->with('success', 'Categoría creada correctamente.')
        ->with('type', 'success'); // Corregido a 'success'
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)

    {
        $categoria = Categoria::findOrFail($id);
     
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'nombre' => 'required|max:250|unique:categorias,nombre,' . $id, // Con $id
        'slug' => 'required|unique:categorias,slug,' . $id, // Con $id
        'descripcion' => 'nullable|max:255',
        'imagen' => 'nullable|image',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
    $categoria = Categoria::findOrFail($id);
    $categoria->nombre = $request->nombre;
    $categoria->slug = $request->slug;
    $categoria->descripcion = $request->descripcion;
    if ($request->hasFile('imagen')) {
        $file = $request->file('imagen');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('imagenes/categorias'), $filename);
        $categoria->imagen = 'imagenes/categorias/' . $filename;
    } else {
        // Si no se sube una nueva imagen, mantener la imagen actual
        // Puedes comentar esta línea si no quieres cambiar la imagen
        // $categoria->imagen = $categoria->imagen; 
    }
    $categoria->save();
    return redirect('categorias')->with('success', 'Categoría actualizada correctamente.');

    // Lógica para actualizar el registro...
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
