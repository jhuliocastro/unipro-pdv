<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Produtos extends Controller
{
    public function consultaProduto(){
        $codigo = $_POST["codigo"];
        $quantidade = $_POST["quantidade"];
        $dados = DB::table('produtos')->where('codigoBarras', $codigo)->first();
        if($dados == null){
            $dados = DB::table('produtos')->where('idControle', $codigo)->first();
            if($dados == null){
                $dados["erro"] = "Produto não encontrado";
            }else{
                Pedidos::gravaProduto($dados->id, $quantidade);
                echo json_encode($dados);
            }
        }else{
            Pedidos::gravaProduto($dados->id, $quantidade);
            echo json_encode($dados);
        }
    }
}
