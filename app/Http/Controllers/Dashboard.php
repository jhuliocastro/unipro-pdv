<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedidos_Caixa;
use App\Models\ProdutosModel;

class Dashboard extends Controller
{
    public function index(){
        $valorTotal = 0;

        $resultado = Pedidos_Caixa::where('ip', env('APP_KEY'))->get();

        foreach($resultado as $r){
            $dadosProduto = ProdutosModel::find($r->produto);
            $valorTotal = $valorTotal + ($dadosProduto->precoVenda * $r->quantidade);
        }

        $valorTotal = number_format($valorTotal, 2, ',', '.');

        return view('dashboard', ["valorTotal" => $valorTotal]);
    }
}
