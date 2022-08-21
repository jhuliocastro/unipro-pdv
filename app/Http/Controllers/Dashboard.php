<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedidos_Caixa;
use App\Models\ProdutosModel;

class Dashboard extends Controller
{
    public function index(){
        return view('dashboard', ["valorTotal" => Pedidos::valorTotalCaixa()]);
    }
}
