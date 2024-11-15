<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postagem;

class PostagemController extends Controller
{
  public function index($titulo='')
  {
    //echo '<pre>';
    //echo $titulo.'<br>';
    //print_r(Postagem::where('titulo_do_blog', '=', $titulo)->first()->nome_da_imagem_do_blog);
    //die();

    //$post = new Postagem;
    //$post->titulo_do_blog = 'aaa';
    //$post->descricao_do_blog = 'descricao_do_blogs';
    //$post->nome_da_imagem_do_blog = "img.png";
    //$post->publicado = false;
    //$res = $post->save();

    //echo '<pre>';
    ////print_r($post);
    //print_r($res);
    //die();

    if ($titulo == '')
      return view('postagens', ['postagens' => Postagem::all()]);
    else
      return view('postagens', ['postagem' => Postagem::where('titulo_do_blog', $titulo)->first()]);
  }
}
