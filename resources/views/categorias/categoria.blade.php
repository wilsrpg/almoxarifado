@extends('layouts.layout')
@section('titulo', 'Categoria: '.$categoria->nome.' - Almoxarifado')
@section('conteudo')

<p>Nome: {{$categoria->nome}} <?= isset($categoria->deletado) ? '<i class=vermelho>(deletado)</i>' : '' ?></p>
<p>Anotações: <br><pre>{{$categoria->anotacoes}}</pre></p>

<a href="/categoria/{{$categoria->id}}/editar">Editar</a>
@if (empty($categoria->deletado))
<form action="/categoria/{{$categoria->id}}/excluir" method="POST">
  @csrf
  @method('DELETE')
  <button>Excluir</button>
</form>
@endif

@endsection