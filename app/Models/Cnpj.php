<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnpj extends Model
{
    use HasFactory;

    protected $table = 'cnpj';

    protected $fillable = ['cnpj', 'filial', 'ativo', 'cliente_id'];
}
