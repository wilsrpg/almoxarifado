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
    echo '<pre>';
    print_r($_POST);
    die();
  }
}
