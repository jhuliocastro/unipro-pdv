<?php

namespace App\Http\Controllers;

use App\Models\ClientesModel;
use App\Models\Vendas;
use App\Models\Vendas_Produtos;
use Illuminate\Http\Request;

class Cupom extends Controller
{
    public static function gerarCupom($id){
        $dadosVenda = Vendas::find($id);
        $dadosCliente = ClientesModel::find($dadosVenda->cliente);
        $produtosVenda = Vendas_Produtos::where('id_venda', $id)->get();
        dd($produtosVenda);
    }
}
