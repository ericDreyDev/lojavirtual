<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TypesController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('search');
        
        if ($filter) {
            $types = Type::where('name', 'like', "%$filter%")
                         ->orderBy('name', 'asc')
                         ->get();
        } else {
            $types = Type::orderBy('name', 'asc')->get();
        }

        return view('types.index', [
            'types' => $types,
            'filter' => $filter
        ]);
    }

    public function create()
    {
        return view('types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'name.max' => 'O nome deve ter no máximo 50 caracteres.',
        ]);

        Type::create([
            'name' => $request->name,
        ]);
        
        return redirect('/types')->with('success', 'Tipo cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $type = Type::find($id);
        
        if (!$type) {
            return redirect('/types')->with('error', 'Tipo não encontrado.');
        }

        return view('types.edit', ['type' => $type]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:types,id',
            'name' => 'required|min:2|max:50',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'name.max' => 'O nome deve ter no máximo 50 caracteres.',
        ]);

        $type = Type::find($request->id);
        $type->update([
            'name' => $request->name
        ]);
        
        return redirect('/types')->with('success', 'Tipo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        try {
            $type = Type::find($id);
            
            if (!$type) {
                return redirect('/types')->with('error', 'Tipo não encontrado.');
            }

            $type->delete();
            return redirect('/types')->with('success', 'Tipo excluído com sucesso!');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect('/types')
                    ->with('error', 'Não é possível excluir: existem produtos vinculados a este tipo.');
            }

            return redirect('/types')
                ->with('error', 'Erro ao excluir tipo.');
        }
    }
}