<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Pag;
use App\Http\Controllers\PostagemController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MovimentacaoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pagina_inicial');
});
Route::get('/pag', Pag::class);
Route::get('/postagens/{titulo?}', [PostagemController::class, 'index']);
Route::get('/itens/{nome?}', [ItemController::class, 'index']);
Route::get('/movimentacoes/{data?}', [MovimentacaoController::class, 'index']);
Route::get('/novo_item', [ItemController::class, 'novo_item']);
Route::get('/nova_movimentacao', [MovimentacaoController::class, 'nova_movimentacao']);
Route::post('/cadastrar_item', [ItemController::class, 'cadastrar_item']);
Route::post('/registrar_movimentacao', [MovimentacaoController::class, 'registrar_movimentacao']);
