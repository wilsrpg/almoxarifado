<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Item;

class GrupoController extends Controller
{
  public function index() {
    $grupos = Grupo::all();
    foreach ($grupos as $grupo)
      $grupo->itens = Item::whereIn('_id', $grupo->itens)->get();
    return view('grupos.grupos', ['grupos' => $grupos]);
  }

  public function ver($id) {
    $grupo = Grupo::where('id', $id)->first();
    $grupo->itens = Item::whereIn('_id', $grupo->itens)->get();
    return view('grupos.grupo', ['grupo' => $grupo]);
  }

  public function pagina_de_criacao() {
    return view('grupos.novo_grupo', ['itens' => Item::all()]);
  }

  public function criar() {
    $grupo = new Grupo;
    $grupo->nome = $_POST['nome'];
    $grupo->anotacoes = $_POST['anotacoes'];
    //$grupo->categoria = $_POST['categoria'];
    $grupo->itens = explode(',', $_POST['itens']);
    //var_dump($grupo->itens);
    //die();
    //$itens = [];
    //if (isset($_POST['itens'])) {
    //  $itens_db = Item::whereIn('_id', $_POST['itens'])->project(['_id' => 1])->get();
    //  foreach ($itens_db as $item)
    //    array_push($itens, $item->id);
    //}
    //$grupo->itens = $itens;
    //print_r($grupo->itens);
    //die();
    $res = $grupo->save();
    //return redirect('/')->with('cadastrou_grupo', $res);
    return redirect('/')->with('mensagem', 'Grupo cadastrado com sucesso.');
  }

  public function pagina_de_edicao($id) {
    return view('grupos.editar_grupo', [
      'grupo' => Grupo::where('id', $id)->first(),
      'itens' => Item::all()
    ]);
  }

  public function atualizar($id) {
    $grupo = Grupo::where('id', $id)->first();
    $grupo->nome = $_POST['nome'];
    $grupo->anotacoes = $_POST['anotacoes'];
    $itens = [];
    if (isset($_POST['itens'])) {
      $itens_db = Item::whereIn('_id', $_POST['itens'])->project(['_id' => 1])->get();
      foreach ($itens_db as $item)
        array_push($itens, $item->id);
    }
    $grupo->itens = $itens;
    $res = $grupo->save();
    //return redirect('/')->with('atualizou_grupo', $res);
    return redirect('/')->with('mensagem', 'Grupo atualizado com sucesso.');
  }
}
