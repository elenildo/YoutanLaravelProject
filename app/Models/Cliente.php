<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['razao_social', 'ativo', 'slug'];

    public function cnpj ()
    {
        return $this->hasMany(Cnpj::class, 'cliente_id');
    }
}
