<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
  public function index($nome = '')
  {
    if ($nome == '')
      return view('categorias', ['categorias' => Categoria::all()]);
    else
      return view('categorias', ['categoria' => Categoria::where('nome', $nome)->first()]);
  }

  public function nova_categoria() {
    return view('nova_categoria');
  }

  public function cadastrar_categoria() {
    $categoria = new Categoria;
    $categoria->nome = $_POST['nome'];
    $categoria->anotacoes = $_POST['anotacoes'];
    $res = $categoria->save();
    return redirect('/')->with('cadastrou_categoria', $res);
  }

  public function editar($nome) {
    return view('editar_categoria', ['categoria' => Categoria::where('nome', $nome)->first()]);
  }

  public function atualizar_categoria($nome) {
    $categoria = Categoria::where('nome', $nome)->first();
    $categoria->nome = $_POST['nome'];
    $categoria->anotacoes = $_POST['anotacoes'];
    $res = $categoria->save();
    return redirect('/')->with('atualizou_categoria', $res);
  }
}
