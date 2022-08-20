<?php

namespace App\Http\Controllers;

use App\Models\Pedidos_Caixa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProdutosModel;

class Produtos extends Controller
{
    public function pesquisaProduto(){
        $pesquisa = $_POST["pesquisa"];
        $resultado = DB::table('produtos')->where('nome', 'LIKE', '%'.$pesquisa.'%')->get();
        echo json_encode($resultado);
    }

    public function consultaProduto(){
        $codigo = $_POST["codigo"];
        $quantidade = $_POST["quantidade"];
        $valorTotal = 0;

        $dados = DB::table('produtos')->where('codigoBarras', $codigo)->first();
        if($dados == null){
            $dados = DB::table('produtos')->where('idControle', $codigo)->first();
            if($dados === null){
                (object)$dados["erro"] = "Produto não encontrado";
            }else{
                Pedidos::gravaProduto($dados->id, $quantidade);
                $dados->valorTotal = number_format(($dados->precoVenda * $quantidade), 2, ',', '.');
                $dados->precoVenda = number_format($dados->precoVenda, 2, ',', '.');
                $resultado = Pedidos_Caixa::where('ip', env('APP_KEY'))->get();
                foreach($resultado as $r){
                    $dadosProduto = ProdutosModel::find($r->produto);
                    $valorTotal = $valorTotal + ($dadosProduto->precoVenda * $quantidade);
                }
                $dados->valorTotal = number_format($valorTotal, 2, ',', '.');
            }
        }else{
            Pedidos::gravaProduto($dados->id, $quantidade);
            $dados->valorTotal = number_format(($dados->precoVenda * $quantidade), 2, ',', '.');
            $dados->precoVenda = number_format($dados->precoVenda, 2, ',', '.');
            $resultado = Pedidos_Caixa::where('ip', env('APP_KEY'))->get();
            foreach($resultado as $r){
                $dadosProduto = ProdutosModel::find($r->produto);
                $valorTotal = $valorTotal + ($dadosProduto->precoVenda * $quantidade);
            }
            $dados->valorTotal = number_format($valorTotal, 2, ',', '.');
        }



        echo json_encode($dados);
    }
}
