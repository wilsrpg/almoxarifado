<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
  public function index() {
      return view('categorias.categorias', ['categorias' => Categoria::all()]);
  }

  public function ver($id) {
    return view('categorias.categoria', ['categoria' => Categoria::where('id', $id)->first()]);
  }

  public function pagina_de_criacao() {
    return view('categorias.nova_categoria');
  }

  public function criar() {
    $categoria = new Categoria;
    $categoria->nome = $_POST['nome'];
    $categoria->anotacoes = $_POST['anotacoes'];
    $res = $categoria->save();
    //return redirect('/')->with('cadastrou_categoria', $res);
    return redirect('/')->with('mensagem', 'Categoria cadastrada com sucesso.');
  }

  public function pagina_de_edicao($id) {
    return view('categorias.editar_categoria', ['categoria' => Categoria::where('id', $id)->first()]);
  }

  public function atualizar($id) {
    $categoria = Categoria::where('id', $id)->first();
    $categoria->nome = $_POST['nome'];
    $categoria->anotacoes = $_POST['anotacoes'];
    $res = $categoria->save();
    //return redirect('/')->with('atualizou_categoria', $res);
    return redirect('/')->with('mensagem', 'Categoria atualizada com sucesso.');
  }

  public function excluir($id) {
    //$res = Categoria::where('id', $id)->first()->delete();
    $res = Categoria::where('id', $id)->update(['deletado' => true]);
    return redirect('/')->with('mensagem', 'Categoria excluída com sucesso.');
  }
}
