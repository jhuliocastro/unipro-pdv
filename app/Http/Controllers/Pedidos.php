<?php

namespace App\Http\Controllers;

use App\Models\Pedidos_Caixa;
use App\Models\ProdutosModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pedidos extends Controller
{
    public static function gravaProduto(int $produto, int $quantidade){
        $pedido = new Pedidos_Caixa;
        $pedido->produto = $produto;
        $pedido->quantidade = $quantidade;
        $pedido->ip = env('APP_KEY');
        $pedido->save();
    }

    public static function valorTotalCaixa(){
        $valorTotal = 0;

        $resultado = Pedidos_Caixa::where('ip', env('APP_KEY'))->get();

        foreach($resultado as $r){
            $dadosProduto = ProdutosModel::find($r->produto);
            $valorTotal = $valorTotal + ($dadosProduto->precoVenda * $r->quantidade);
        }

        $valorTotal = number_format($valorTotal, 2, ',', '.');

        return $valorTotal;
    }

    public static function valorTotalCaixa2(){
        $valorTotal = 0;

        $resultado = Pedidos_Caixa::where('ip', env('APP_KEY'))->get();

        foreach($resultado as $r){
            $dadosProduto = ProdutosModel::find($r->produto);
            $valorTotal = $valorTotal + ($dadosProduto->precoVenda * $r->quantidade);
        }

        $valorTotal = number_format($valorTotal, 2, ',', '.');

        echo $valorTotal;
    }
}
