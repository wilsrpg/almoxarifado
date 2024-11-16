<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Item;

class GrupoController extends Controller
{
  public function index($nome = '')
  {
    if ($nome == '')
      return view('grupos', ['grupos' => Grupo::all()]);
    else
      return view('grupos', ['grupo' => Grupo::where('nome', $nome)->first()]);
  }

  public function novo_grupo() {
    return view('novo_grupo', ['itens' => Item::aggregate()->project(_id: 1, nome: 1)->get()]);
  }

  public function cadastrar_grupo() {
    $grupo = new Grupo;
    $grupo->nome = $_POST['nome'];
    $grupo->anotacoes = $_POST['anotacoes'];
    //$grupo->itens = [];
    //if (isset($_POST['itens']))
      $grupo->itens = $_POST['itens'];
    $res = $grupo->save();
    return redirect('/')->with('cadastrou_grupo', $res);
  }
}
