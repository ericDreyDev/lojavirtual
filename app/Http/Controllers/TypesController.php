<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TypesController extends Controller
{
    public function index()
    {
        return view('types.index', [
            'types' => Type::all()
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

        ]);

        Type::create([
            'name' => $request->name,

        ]);
        return redirect('/types')->with('success', 'Tipo cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $type = Type::find($id);
        return view('types.edit', ['type' => $type]);
    }


    public function update(Request $request)
    {
        $type = Type::find($request->id);
        $type->update([
            'name' => $request->name
        ]);
        //nome da variavel de sessao é 'success'
        return redirect('/types')->with('success', 'Tipo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        try{
        $type = Type::find($id);
        $type->delete();
        return redirect('/types')->with('success', 'Tipo excluído com sucesso!');

         } catch (QueryException $e) {
        // Verifica se é uma violação de integridade (foreign key)
        if ($e->getCode() === '23000') {
            return redirect('/types')
                             ->with('error', 'Não é possível excluir: existem produtos vinculados a este tipo.');
        }

        // Caso outro erro de banco
        return redirect()('/types')
                         ->with('error', 'Erro ao excluir tipo.');
    }
    }
}
