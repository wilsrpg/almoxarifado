<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MovimentacaoController;

use App\Http\Livewire\Pag;

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

Route::get('/', function () {return view('pagina_inicial');});

Route::get('/itens', [ItemController::class, 'index']);
Route::get('/itens/novo', [ItemController::class, 'pagina_de_criacao']);
Route::post('/itens/criar', [ItemController::class, 'criar']);
Route::get('/item/{id}', [ItemController::class, 'ver']);
Route::get('/item/{id}/editar', [ItemController::class, 'pagina_de_edicao']);
Route::post('/item/{id}/atualizar', [ItemController::class, 'atualizar']);
Route::delete('/item/{id}/excluir', [ItemController::class, 'excluir']);

Route::get('/categorias', [CategoriaController::class, 'index']);
Route::get('/categorias/nova', [CategoriaController::class, 'pagina_de_criacao']);
Route::post('/categorias/criar', [CategoriaController::class, 'criar']);
Route::get('/categoria/{id}', [CategoriaController::class, 'ver']);
Route::get('/categoria/{id}/editar', [CategoriaController::class, 'pagina_de_edicao']);
Route::post('/categoria/{id}/atualizar', [CategoriaController::class, 'atualizar']);
Route::delete('/categoria/{id}/excluir', [CategoriaController::class, 'excluir']);

Route::get('/grupos', [GrupoController::class, 'index']);
Route::get('/grupos/novo', [GrupoController::class, 'pagina_de_criacao']);
Route::post('/grupos/criar', [GrupoController::class, 'criar']);
Route::get('/grupo/{id}', [GrupoController::class, 'ver']);
Route::get('/grupo/{id}/editar', [GrupoController::class, 'pagina_de_edicao']);
Route::post('/grupo/{id}/atualizar', [GrupoController::class, 'atualizar']);
Route::delete('/grupo/{id}/excluir', [GrupoController::class, 'excluir']);

Route::get('/movimentacoes', [MovimentacaoController::class, 'index']);
Route::get('/movimentacoes/nova', [MovimentacaoController::class, 'pagina_de_criacao']);
Route::post('/movimentacoes/criar', [MovimentacaoController::class, 'criar']);
Route::get('/movimentacao/{id}', [MovimentacaoController::class, 'ver']);
Route::get('/movimentacao/{id}/editar', [MovimentacaoController::class, 'pagina_de_edicao']);
Route::post('/movimentacao/{id}/atualizar', [MovimentacaoController::class, 'atualizar']);
Route::delete('/movimentacao/{id}/excluir', [MovimentacaoController::class, 'excluir']);

Route::get('/pag', Pag::class);
