<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Item;

class GrupoController extends Controller
{
  public function index($nome = '')
  {
    if ($nome == '') {
      $grupos = Grupo::all();
      foreach ($grupos as $grupo) {
        $grupo->itens = Item::whereIn('_id', $grupo->itens)->get();
      }
      return view('grupos', ['grupos' => $grupos]);
    } else {
      $grupo = Grupo::where('nome', $nome)->first();
      $grupo->itens = Item::whereIn('_id', $grupo->itens)->get();
      return view('grupos', ['grupo' => $grupo]);
    }
  }

  public function novo_grupo() {
    return view('novo_grupo', ['itens' => Item::aggregate()->project(_id: 1, nome: 1)->get()]);
  }

  public function cadastrar_grupo() {
    $grupo = new Grupo;
    $grupo->nome = $_POST['nome'];
    $grupo->anotacoes = $_POST['anotacoes'];
    //$grupo->categoria = $_POST['categoria'];
    $itens = [];
    if (isset($_POST['itens'])) {
      $itens_db = Item::whereIn('_id', $_POST['itens'])->project(['_id' => 1])->get();
      foreach ($itens_db as $item)
        array_push($itens, $item->id);
    }
    $grupo->itens = $itens;
    //print_r($grupo->itens);
    //die();
    $res = $grupo->save();
    return redirect('/')->with('cadastrou_grupo', $res);
  }
}
