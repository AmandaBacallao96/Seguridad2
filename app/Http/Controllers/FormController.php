<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function showForm()
    {
        return view('form'); // Retorna la vista del formulario
    }

    public function submitForm(Request $request)
    {
        // Aquí puedes manejar la lógica para procesar los datos del formulario
        // Ejemplo: guardar en la base de datos, enviar un correo, etc.

        return redirect()->route('form.show')->with('success', 'Formulario enviado correctamente.');
    }
}
