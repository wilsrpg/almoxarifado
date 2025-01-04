<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Item;

class GrupoController extends Controller
{
  public function index() {
    //echo '<pre>';
    //print_r($_GET);die();
    $filtro = (object)[];
    $filtro->nome = $_GET['nome'] ?? '';
    $filtro->itens = $_GET['itens'] ?? [];
    $filtro->qtdes = $_GET['qtdes'] ?? [];
    $filtro->anotacoes = $_GET['anotacoes'] ?? '';
    $grupos = Grupo::where('nome', 'like', '%'.$filtro->nome.'%')
      ->where('anotacoes', 'regexp', '/.*'.$filtro->anotacoes.'.*/ms')
      ->get();
    //$grupos = Grupo::all();
    $grupos = $grupos->filter(function ($grupo) use ($filtro) {
      return count(array_diff($filtro->itens, $grupo->itens))==0;
    });
    foreach ($grupos as $grupo) {
      $itens_db = Item::whereIn('_id', $grupo->itens)->get();
      $itens_em_ordem = [];
      foreach ($grupo->itens as $it)
        $itens_em_ordem[] = $itens_db->find($it);
      $grupo->itens = $itens_em_ordem;
    }
    return view('grupos.grupos', ['grupos' => $grupos, 'itens' => Item::all(), 'filtro' => $filtro]);
  }

  public function ver($id) {
    $grupo = Grupo::where('id', $id)->first();
    $itens_db = Item::whereIn('_id', $grupo->itens)->get();
    $itens_em_ordem = [];
    foreach ($grupo->itens as $it)
      $itens_em_ordem[] = $itens_db->find($it);
    $grupo->itens = $itens_em_ordem;
    return view('grupos.grupo', ['grupo' => $grupo]);
  }

  public function pagina_de_criacao() {
    return view('grupos.novo_grupo', ['itens' => Item::all()]);
  }

  public function criar() {
    $grupo = new Grupo;
    $grupo->nome = $_POST['nome'];
    $grupo->anotacoes = $_POST['anotacoes'] ?? '';
    //$grupo->categoria = $_POST['categoria'];
    //$grupo->itens = explode(',', $_POST['itens']);
    $grupo->itens = $_POST['itens'];
    $grupo->qtdes = $_POST['qtdes'];
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
    $grupo->anotacoes = $_POST['anotacoes'] ?? '';
    //$grupo->itens = explode(',', $_POST['itens']);
    $grupo->itens = $_POST['itens'];
    $grupo->qtdes = $_POST['qtdes'];
    $res = $grupo->save();
    //return redirect('/')->with('atualizou_grupo', $res);
    return redirect('/')->with('mensagem', 'Grupo atualizado com sucesso.');
  }

  public function excluir($id) {
    $res = Grupo::where('id', $id)->update(['deletado' => true]);
    return redirect('/')->with('mensagem', 'Grupo excluído com sucesso.');
  }
}
