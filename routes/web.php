<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Produtos;
use App\Http\Controllers\Pedidos;
use App\Http\Controllers\Clientes;
use App\Models\Pedidos_Caixa;

Route::get('/', function () {
    return redirect('/login');
});

require __DIR__.'/auth.php';

Route::get('/dashboard', [Dashboard::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::post('/consulta/produto', [Produtos::class, 'consultaProduto'])->middleware(['auth'])->name('consulta.produto');
Route::post('/pesquisa/produto', [Produtos::class, 'pesquisaProduto'])->middleware(['auth'])->name('pesquisa.produto');

Route::post('/pesquisa/cliente', [Clientes::class, 'pesquisaClientes'])->middleware(['auth'])->name('pesquisa.cliente');
Route::post('/dados/cliente', [Clientes::class, 'dadosCliente'])->middleware(['auth'])->name('dados.cliente');;

Route::get('/valorTotalCaixa', [Pedidos::class, 'valorTotalCaixa2'])->middleware(['auth'])->name('valorTotalCaixa.pedidos');
Route::get('/cancelarItem', [Pedidos::class, 'cancelarItem'])->middleware(['auth'])->name('cancelar.item');

Route::get('/novavenda', [Pedidos::class, 'novaVenda'])->middleware(['auth'])->name('nova.venda');
Route::post('/finalizarVenda', [Pedidos::class, 'finalizarVenda'])->middleware(['auth'])->name('finalizar.venda');

Route::view('listagemProdutosCaixa', 'listagemProdutosCaixa', [
    'data' => DB::table('pedidos_caixa')->where('ip', env('APP_KEY'))->orderBy('id', 'desc')->get()
]);
