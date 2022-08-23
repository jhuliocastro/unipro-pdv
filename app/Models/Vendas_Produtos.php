<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendas_Produtos extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'vendas_produtos';
}
