<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

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
    return view('novo_item');
  }

  public function cadastrar_item() {
    //echo '<pre>';print_r($_POST);
    //die();
    $item = new Item;
    $item->nome = $_POST['nome'];
    $item->anotacoes = $_POST['anotacoes'];
    $item->disponivel = isset($_POST['disponivel']) && $_POST['disponivel'] == 'on';
    //echo '<pre>';print_r($item);
    //die();
    $res = $item->save();
    //echo '<pre>';print_r($res);die();
    return redirect('/')->with('cadastrou_item', $res);
  }
}
