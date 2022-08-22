<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
use App\Models\Pedidos_Caixa;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [Dashboard::class, 'index']);

Route::post('/consulta/produto', [Produtos::class, 'consultaProduto'])->name('consulta.produto');
Route::post('/pesquisa/produto', [Produtos::class, 'pesquisaProduto'])->name('pesquisa.produto');

Route::get('/valorTotalCaixa', [Pedidos::class, 'valorTotalCaixa2'])->name('valorTotalCaixa.pedidos');
Route::get('/cancelarItem', [Pedidos::class, 'cancelarItem'])->name('cancelar.item');

Route::view('listagemProdutosCaixa', 'listagemProdutosCaixa', [
    'data' => DB::table('pedidos_caixa')->where('ip', env('APP_KEY'))->orderBy('id', 'desc')->get()
]);
