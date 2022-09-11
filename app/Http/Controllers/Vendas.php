<?php

namespace App\Http\Controllers;

use App\Models\ClientesModel;
use App\Models\PrintCupom;
use Illuminate\Http\Request;
use App\Models\VendasModel;

class Vendas extends Controller
{
    public function home(){
        $data = date('Y-m-d').' 00:00:00';
        $vendas = VendasModel::where('created_at', '>=', $data)->orderBy('id', 'DESC')->get();
        foreach($vendas as $venda){
            $dadosCliente = ClientesModel::find($venda->cliente);
            $venda->cliente = $dadosCliente->nome;
            $venda->valorTotal = 'R$ '.number_format($venda->valorTotal, 2, ',', '.');
            $venda->valorPago = 'R$ '.number_format($venda->valorPago, 2, ',', '.');
            $venda->troco = 'R$ '.number_format($venda->troco, 2, ',', '.');
            $venda->desconto = 'R$ '.number_format($venda->desconto, 2, ',', '.');
            $venda->dinheiro = 'R$ '.number_format($venda->dinheiro, 2, ',', '.');
            $venda->debito = 'R$ '.number_format($venda->debito, 2, ',', '.');
            $venda->credito = 'R$ '.number_format($venda->credito, 2, ',', '.');
            $venda->crediario = 'R$ '.number_format($venda->crediario, 2, ',', '.');
            $venda->pix = 'R$ '.number_format($venda->pix, 2, ',', '.');
        }
        return view('vendas', ['vendas' => $vendas]);
    }

    public function imprimirCupom(){
        PrintCupom::create([
            'venda' => $_POST['id'],
            'key' => env('APP_KEY')
        ]);
    }
}
