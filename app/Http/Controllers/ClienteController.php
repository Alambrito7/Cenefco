<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClientesExport;


class ClienteController extends Controller
{
    public function index()
{
    $clientes = Cliente::withTrashed()->get();
    return view('clientes.index', compact('clientes'));
}

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'ci' => 'required|unique:clientes,ci',
            'email' => 'required|email|unique:clientes,email',
            'celular' => 'required',
            'departamento' => 'required',
            'provincia' => 'required',
            'genero' => 'required',
            'pais' => 'required',
            'profesion' => 'nullable|string|max:255',
            'grado_academico' => 'nullable|string',
            'edad' => 'nullable|integer|min:0|max:150',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'ci' => 'required|unique:clientes,ci,' . $cliente->id,
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'celular' => 'required',
            'departamento' => 'required',
            'provincia' => 'required',
            'genero' => 'required',
            'pais' => 'required',
            'profesion' => 'nullable|string|max:255',
            'grado_academico' => 'nullable|string',
            'edad' => 'nullable|integer|min:0|max:150',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
    $cliente->delete();
    return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }  
    
    public function restore($id)
{
    $cliente = Cliente::withTrashed()->findOrFail($id);
    $cliente->restore();

    return redirect()->route('clientes.index')->with('success', 'Cliente restaurado correctamente.');
}

public function exportPdf()
{
    $clientes = Cliente::withTrashed()->get();
    $pdf = Pdf::loadView('clientes.pdf', compact('clientes'))->setPaper('A4', 'landscape');



    return $pdf->download('clientes.pdf');
}

public function exportExcel()
{
    return Excel::download(new ClientesExport, 'clientes.xlsx');
}


}
