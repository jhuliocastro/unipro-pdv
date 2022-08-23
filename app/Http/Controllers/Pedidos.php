<?php

namespace App\Http\Controllers;

use App\Models\Pedidos_Caixa;
use App\Models\ProdutosModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class Pedidos extends Controller
{

    public static function gravaProduto(int $produto, int $quantidade){
        $pedido = new Pedidos_Caixa;
        $pedido->produto = $produto;
        $pedido->quantidade = $quantidade;
        $pedido->ip = env('APP_KEY');
        $pedido->save();
    }

    public function novaVenda(){
        $return = Pedidos_Caixa::where('ip', env('APP_KEY'))->delete();
        echo $return;
    }

    public function finalizarVenda(){
        $valorPagamento = (float)$_POST["dinheiroPagamento"] + (float)$_POST["debitoPagamento"] + (float)$_POST["creditoPagamento"] + (float)$_POST["crediarioPagamento"] + (float)$_POST["pixPagamento"];
        $valorTotal = (float)$_POST["valorTotalFinalizar"] - (float)$_POST["descontoFinalizar"];
        if($valorPagamento < $valorTotal){
            Alert::error('Valor informado é menor do que o valor da venda!', 'Verifique e tente novamente.');
        }else{

        }

        return view('dashboard', ["valorTotal" => Pedidos::valorTotalCaixa()]);
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

    public function cancelarItem(){
        $id = $_GET["id"];
        $item = Pedidos_Caixa::find($id);
        $item = $item->delete();
        echo $item;
    }
}
