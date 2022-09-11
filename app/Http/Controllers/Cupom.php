<?php

namespace App\Http\Controllers;

use App\Models\ClientesModel;
use App\Models\ProdutosModel;
use App\Models\VendasModel;
use App\Models\Vendas_Produtos;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class Cupom extends Controller
{
    public static function gerarCupom($id){
        $dadosVenda = VendasModel::find($id);
        $dadosCliente = ClientesModel::find($dadosVenda->cliente);
        $produtosVenda = Vendas_Produtos::where('id_venda', $id)->get();

        $html = file_get_contents("modelos/cupom.html"); //PEGA O HTML

        $produtos = null;
        foreach ($produtosVenda as $produto){
            $dadosProduto = ProdutosModel::find($produto->produto);

            $valorTotalProduto = $dadosProduto->precoVenda * $produto->quantidade;
            $valorTotalProduto = number_format($valorTotalProduto, 2, ",", ".");
            $dadosProduto->precoVenda = number_format($dadosProduto->precoVenda, 2, ",", '.');


            $produtos .= "
            <div class='row'>
                <div class='col-12'>$dadosProduto->nome</div>
                <div class='col-6'>$produto->quantidade X R$ $dadosProduto->precoVenda | $dadosProduto->unidadeMedida</div>
                <div class='col-6' style='text-align: right;'>R$ $valorTotalProduto</div>
            </div>
            ";
        }

        $subTotal = $dadosVenda->valorTotal - $dadosVenda->desconto;
        $subTotal = number_format($subTotal, 2, ",", ".");

        //SUBSTITUI OS DADOS NO HTML
        $html = str_replace("{{RAZAO_SOCIAL}}", config('global.razao_social'), $html);
        $html = str_replace("{{ENDERECO}}", config('global.endereco'), $html);
        $html = str_replace("{{CNPJ}}", config('global.cnpj'), $html);
        $html = str_replace("{{PRODUTOS}}", $produtos, $html);
        $html = str_replace("{{CLIENTE}}", $dadosCliente->nome, $html);
        $html = str_replace("{{CPF}}", $dadosCliente->cpf_cnpj, $html);
        $html = str_replace("{{TOTAL}}", number_format($dadosVenda->valorTotal, 2, ",", "."), $html);
        $html = str_replace("{{DESCONTO}}", number_format($dadosVenda->desconto, 2, ",", "."), $html);
        $html = str_replace("{{SUB_TOTAL}}",$subTotal, $html);
        $html = str_replace("{{TOTAL_PAGO}}", number_format($dadosVenda->valorPago, 2, ",", "."), $html);
        $html = str_replace("{{TROCO}}", number_format($dadosVenda->troco, 2, ",", "."), $html);
        $html = str_replace("{{DINHEIRO}}", number_format($dadosVenda->dinheiro, 2, ",", "."), $html);
        $html = str_replace("{{PIX}}", number_format($dadosVenda->pix, 2, ",", "."), $html);
        $html = str_replace("{{CREDITO}}", number_format($dadosVenda->credito, 2, ",", "."), $html);
        $html = str_replace("{{DEBITO}}", number_format($dadosVenda->debito, 2, ",", "."), $html);
        $html = str_replace("{{CREDIARIO}}", number_format($dadosVenda->crediario, 2, ",", "."), $html);
        $html = str_replace("{{ID_VENDA}}", $dadosVenda->id, $html);
        $html = str_replace("{{DATA_HORA}}", date('d/m/Y H:i:s', strtotime($dadosVenda->created_at)), $html);

        //CRIA O PDF
        file_put_contents('temp/cupom.html', $html);
    }
}
