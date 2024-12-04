<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Categoria;

class ItemController extends Controller
{
  public function index($nome = '')
  {
    if ($nome == '')
      return view('itens', ['itens' => Item::all()]);
    else
      return view('itens', ['item' => Item::where('nome', $nome)->first()]);
  }

  public function novo_item() {
    return view('novo_item', ['categorias' => Categoria::all()]);
  }

  public function cadastrar_item() {
    //echo '<pre>';print_r($_POST);
    //die();
    $item = new Item;
    $item->nome = $_POST['nome'];
    $item->anotacoes = $_POST['anotacoes'];
    $item->categoria = $_POST['categoria'] ?? '';
    $item->disponivel = isset($_POST['disponivel']) && $_POST['disponivel'] == 'on';
    //echo '<pre>';print_r($item);
    //die();
    $res = $item->save();
    //echo '<pre>';print_r($res);die();
    return redirect('/')->with('cadastrou_item', $res);
  }

  public function editar($nome) {
    return view('editar_item', ['item' => Item::where('nome', $nome)->first(), 'categorias' => Categoria::all()]);
  }

  public function atualizar_item($nome) {
    $item = Item::where('nome', $nome)->first();
    $item->nome = $_POST['nome'];
    $item->anotacoes = $_POST['anotacoes'];
    $item->categoria = $_POST['categoria'] ?? '';
    $res = $item->save();
    return redirect('/')->with('atualizou_item', $res);
  }
}
