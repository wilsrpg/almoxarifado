<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimentacao;

class MovimentacaoController extends Controller
{
  public function index($data = '')
  {
    //print_r(Movimentacao::all());die();
    if ($data == '')
      return view('movimentacoes', ['movimentacoes' => Movimentacao::all()]);
    else
      return view('movimentacoes', ['movimentacao' => Movimentacao::where('data', $data)->first()]);
  }

  public function nova_movimentacao() {
    return view('nova_movimentacao');
  }

  public function registrar_movimentacao() {
    echo '<pre>';
    print_r($_POST);
    die();
  }
}
