<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientesModel;

class Clientes extends Controller
{
    public function pesquisaClientes(){
        $pesquisa = $_POST["pesquisa"];
        $resultado = ClientesModel::where('nome', 'like', '%'.$pesquisa.'%')->get();
        echo json_encode($resultado);
    }

    public function dadosCliente(){
        $id = $_POST["id"];
        $dados = ClientesModel::find($id);
        echo json_encode($dados);
    }
}
