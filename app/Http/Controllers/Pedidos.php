<?php

namespace App\Http\Controllers;

use App\Models\Pedidos_Caixa;
use App\Models\ProdutosModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Vendas;
use App\Models\Vendas_Produtos;
use App\Models\PrintCupom;

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
        $_POST["dinheiroPagamento"] = str_replace('.', '', $_POST["dinheiroPagamento"]);
        $_POST["dinheiroPagamento"] = str_replace(',', '.', $_POST["dinheiroPagamento"]);
        $_POST["debitoPagamento"] = str_replace('.', '', $_POST["debitoPagamento"]);
        $_POST["debitoPagamento"] = str_replace(',', '.', $_POST["debitoPagamento"]);
        $_POST["creditoPagamento"] = str_replace('.', '', $_POST["creditoPagamento"]);
        $_POST["creditoPagamento"] = str_replace(',', '.', $_POST["creditoPagamento"]);
        $_POST["crediarioPagamento"] = str_replace('.', '', $_POST["crediarioPagamento"]);
        $_POST["crediarioPagamento"] = str_replace(',', '.', $_POST["crediarioPagamento"]);
        $_POST["pixPagamento"] = str_replace('.', '', $_POST["pixPagamento"]);
        $_POST["pixPagamento"] = str_replace(',', '.', $_POST["pixPagamento"]);
        $_POST["valorTotalFinalizar"] = str_replace('.', '', $_POST["valorTotalFinalizar"]);
        $_POST["valorTotalFinalizar"] = str_replace(',', '.', $_POST["valorTotalFinalizar"]);
        $_POST["descontoFinalizar"] = str_replace('.', '', $_POST["descontoFinalizar"]);
        $_POST["descontoFinalizar"] = str_replace(',', '.', $_POST["descontoFinalizar"]);

        $valorPagamento = (float)$_POST["dinheiroPagamento"] + (float)$_POST["debitoPagamento"] + (float)$_POST["creditoPagamento"] + (float)$_POST["crediarioPagamento"] + (float)$_POST["pixPagamento"];
        $valorTotal = (float)$_POST["valorTotalFinalizar"] - (float)$_POST["descontoFinalizar"];
        if($valorPagamento < $valorTotal){
            Alert::error('Valor informado é menor do que o valor da venda!', 'Verifique e tente novamente.');
        }else{
            $troco = $valorPagamento - $valorTotal;
            if($_POST["clienteFinalizar"] == null){
                $_POST["clienteFinalizar"] = 1;
            }
            $venda = Vendas::create([
                'cliente' => $_POST["clienteFinalizar"],
                'orcamento' => 0,
                'valorTotal' => (float)$_POST['valorTotalFinalizar'],
                'desconto' => (float)$_POST["descontoFinalizar"],
                'troco' => (float)$troco,
                'valorPago' => (float)$valorPagamento,
                'dinheiro' => (float)$_POST["dinheiroPagamento"],
                'debito' => (float)$_POST["debitoPagamento"],
                'credito' => (float)$_POST["creditoPagamento"],
                'crediario' => (float)$_POST["crediarioPagamento"],
                'pix' => (float)$_POST["pixPagamento"],
                'user' => Auth::user()->id
            ]);
            if($venda->exists == true){
                $produtos = Pedidos_Caixa::where('ip', env('APP_KEY'))->get();
                foreach($produtos as $produto){
                    Vendas_Produtos::create([
                        'id_venda' => $venda->id,
                        'produto' => $produto->produto,
                        'quantidade' => $produto->quantidade
                    ]);

                    $dadosProduto = ProdutosModel::find($produto->produto);
                    $dadosProduto->estoqueAtual = $dadosProduto->estoqueAtual - $produto->quantidade;
                    $dadosProduto->save();
                }
                Pedidos_Caixa::where('ip', env('APP_KEY'))->delete();
                /*PrintCupom::create([
                    'venda' => $venda->id,
                    'key' => env('APP_KEY')
                ]);*/
                Cupom::gerarCupom($venda->id);
                //Alert::success('Venda Concluída', 'Troco: R$ '.number_format($troco, 2, ',', '.'));
            }else{
                Alert::error('Erro ao concluir venda!', 'Consulte o administrador do sistema.');
            }
        }

        //return view('dashboard', ["valorTotal" => Pedidos::valorTotalCaixa()]);
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
