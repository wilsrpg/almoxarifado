@extends('layouts.layout')
@section('titulo', 'Grupo: '.$grupo->nome.' - Almoxarifado')
@section('conteudo')

<p>Nome: {{$grupo->nome}} <?= isset($grupo->deletado) ? '<i class=vermelho>(deletado)</i>' : '' ?></p>
<p>Itens:</p>
<ul>
  @foreach ($grupo->itens as $key => $item)
    <li>
      <a href="/item/{{$item->id}}">{{$item->nome}}</a>
      @if (isset($grupo->qtdes[$key]))
        <i>({{$grupo->qtdes[$key]}})</i>
      @endif
    </li>
  @endforeach
</ul>
<p>Anotações: <br><pre>{{$grupo->anotacoes}}</pre></p>

<a href="/grupo/{{$grupo->id}}/editar">Editar</a>
@if (empty($grupo->deletado))
<form action="/grupo/{{$grupo->id}}/excluir" method="POST">
  @csrf
  @method('DELETE')
  <button>Excluir</button>
</form>
@endif

@endsection