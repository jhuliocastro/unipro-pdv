<?php

namespace App\Http\Controllers;

use App\Models\Pedidos_Caixa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pedidos extends Controller
{
    public static function gravaProduto(int $produto, int $quantidade){
        $pedido = new Pedidos_Caixa;
        $pedido->produto = $produto;
        $pedido->quantidade = $quantidade;
        $pedido->ip = $_SERVER['REMOTE_ADDR'];
        $pedido->save();
    }
}
