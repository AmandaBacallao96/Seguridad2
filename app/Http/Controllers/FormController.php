<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;

class FormController extends Controller
{

 
    public function create()
    {
        return view('form');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|min:2|max:25',
            'referencia' => 'required|string|min:4|max:12|unique:productos,referencia',
            'descripcion' => 'required|string|min:20|max:150',
        ]);
      
        Form::create($validatedData);

        return redirect()->route('form.create')->with('success', 'Producto creado exitosamente.');
    }
}
