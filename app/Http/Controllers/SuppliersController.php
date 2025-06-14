<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('search');
        
        if ($filter) {
            $suppliers = Supplier::where('nome_razao', 'like', "%$filter%")
                               ->orWhere('cpf_cnpj', 'like', "%$filter%")
                               ->orderBy('nome_razao', 'asc')
                               ->get();
        } else {
            $suppliers = Supplier::orderBy('nome_razao', 'asc')->get();
        }

        return view('suppliers.index', [
            'suppliers' => $suppliers,
            'filter' => $filter
        ]);
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:F,J',
            'nome_razao' => 'required|min:3|max:100',
            'cpf_cnpj' => 'required|unique:suppliers,cpf_cnpj',
            'telefone' => 'required|min:10|max:15|regex:/^[0-9()\-\s]+$/',
        ], [
            'tipo.required' => 'O tipo é obrigatório.',
            'tipo.in' => 'O tipo deve ser Física (F) ou Jurídica (J).',
            'nome_razao.required' => 'O nome/razão social é obrigatório.',
            'nome_razao.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'cpf_cnpj.required' => 'O CPF/CNPJ é obrigatório.',
            'cpf_cnpj.unique' => 'Este CPF/CNPJ já está cadastrado.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.regex' => 'O telefone deve ter um formato válido.',
        ]);

        // Validação específica para CPF/CNPJ baseado no tipo
        $documento = preg_replace('/\D/', '', $request->cpf_cnpj);
        
        if ($request->tipo === 'F' && strlen($documento) !== 11) {
            return back()->withErrors(['cpf_cnpj' => 'CPF deve ter 11 dígitos.'])->withInput();
        }
        
        if ($request->tipo === 'J' && strlen($documento) !== 14) {
            return back()->withErrors(['cpf_cnpj' => 'CNPJ deve ter 14 dígitos.'])->withInput();
        }

        Supplier::create([
            'tipo' => $request->tipo,
            'nome_razao' => $request->nome_razao,
            'cpf_cnpj' => $documento, // Salva apenas números
            'telefone' => preg_replace('/\D/', '', $request->telefone) // Salva apenas números
        ]);

        return redirect('/suppliers')->with('success', 'Fornecedor cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        
        if (!$supplier) {
            return redirect('/suppliers')->with('error', 'Fornecedor não encontrado.');
        }

        return view('suppliers.edit', ['supplier' => $supplier]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:suppliers,id',
            'tipo' => 'required|in:F,J',
            'nome_razao' => 'required|min:3|max:100',
            'cpf_cnpj' => 'required|unique:suppliers,cpf_cnpj,' . $request->id,
            'telefone' => 'required|min:10|max:15|regex:/^[0-9()\-\s]+$/',
        ], [
            'tipo.required' => 'O tipo é obrigatório.',
            'tipo.in' => 'O tipo deve ser Física (F) ou Jurídica (J).',
            'nome_razao.required' => 'O nome/razão social é obrigatório.',
            'nome_razao.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'cpf_cnpj.required' => 'O CPF/CNPJ é obrigatório.',
            'cpf_cnpj.unique' => 'Este CPF/CNPJ já está cadastrado para outro fornecedor.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.regex' => 'O telefone deve ter um formato válido.',
        ]);

        // Validação específica para CPF/CNPJ baseado no tipo
        $documento = preg_replace('/\D/', '', $request->cpf_cnpj);
        
        if ($request->tipo === 'F' && strlen($documento) !== 11) {
            return back()->withErrors(['cpf_cnpj' => 'CPF deve ter 11 dígitos.'])->withInput();
        }
        
        if ($request->tipo === 'J' && strlen($documento) !== 14) {
            return back()->withErrors(['cpf_cnpj' => 'CNPJ deve ter 14 dígitos.'])->withInput();
        }

        $supplier = Supplier::find($request->id);
        $supplier->update([
            'tipo' => $request->tipo,
            'nome_razao' => $request->nome_razao,
            'cpf_cnpj' => $documento,
            'telefone' => preg_replace('/\D/', '', $request->telefone)
        ]);

        return redirect('/suppliers')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    public function destroy($id)
    {
        try {
            $supplier = Supplier::find($id);
            
            if (!$supplier) {
                return redirect('/suppliers')->with('error', 'Fornecedor não encontrado.');
            }

            $supplier->delete();
            return redirect('/suppliers')->with('success', 'Fornecedor excluído com sucesso!');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect('/suppliers')
                    ->with('error', 'Não é possível excluir: existem produtos vinculados a este fornecedor.');
            }

            return redirect('/suppliers')
                ->with('error', 'Erro ao excluir fornecedor.');
        }
    }
}