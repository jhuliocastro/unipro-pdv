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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [Dashboard::class, 'index']);

Route::post('/consulta/produto', [Produtos::class, 'consultaProduto'])->name('consulta.produto');

Route::view('listagemProdutosCaixa', 'listagemProdutos', [
    'data' => \App\Models\Pedidos_Caixa::all()->where('ip', $_SERVER[""])->get()
]);
