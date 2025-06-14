<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'nome_razao',
        'cpf_cnpj',
        'telefone'
    ];

    // Relacionamento com produtos (se necessário no futuro)
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Accessor para tipo por extenso
    public function getTipoFullAttribute()
    {
        return $this->tipo === 'F' ? 'Pessoa Física' : 'Pessoa Jurídica';
    }

    // Accessor para formatar CPF/CNPJ
    public function getFormattedCpfCnpjAttribute()
    {
        $documento = preg_replace('/\D/', '', $this->cpf_cnpj);

        if (strlen($documento) === 11) {
            // CPF: 000.000.000-00
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $documento);
        } else {
            // CNPJ: 00.000.000/0000-00
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $documento);
        }
    }

    // Accessor para formatar telefone
    public function getFormattedTelefoneAttribute()
    {
        $telefone = preg_replace('/\D/', '', $this->telefone);

        if (strlen($telefone) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
        }
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
    }

    // Validar se é CPF ou CNPJ válido
    public function getDocumentTypeAttribute()
    {
        $documento = preg_replace('/\D/', '', $this->cpf_cnpj);
        return strlen($documento) === 11 ? 'CPF' : 'CNPJ';
    }
}
