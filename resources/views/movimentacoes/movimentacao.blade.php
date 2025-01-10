@extends('layouts.layout')
@section('titulo', $movimentacao->tipo.': '.$movimentacao->id.' - Almoxarifado')
@section('conteudo')

<p>ID: {{$movimentacao->id}} <?= isset($movimentacao->deletado) ? '<i class=vermelho>(deletado)</i>' : '' ?></p>
<p>Data: {{$movimentacao->data ? date_format(date_create($movimentacao->data), 'd/m/Y') : ''}}</p>
<p>Hora: {{$movimentacao->hora}}</p>
<p>Tipo: {{$movimentacao->tipo}}</p>
<p>Responsável por entregar: {{$movimentacao->quem_entregou}}</p>
<p>Responsável por receber: {{$movimentacao->quem_recebeu}}</p>
<p>Itens:</p>
<ul>
  @foreach ($movimentacao->itens as $key => $item)
    <li>
      <a href="/item/{{$item->id}}">{{$item->nome}}</a>
      @if (isset($movimentacao->qtdes[$key]))
        <i>({{$movimentacao->qtdes[$key]}})</i>
      @endif
    </li>
  @endforeach
</ul>
<p>Anotações: <br><pre>{{$movimentacao->anotacoes}}</pre></p>

<a href="/movimentacao/{{$movimentacao->id}}/editar">Editar</a><br>

<form action="/movimentacoes/nova" method="POST">
  @csrf
  <input type="hidden" name="id" value="{{$movimentacao->id}}">
  @if ($movimentacao->tipo == 'Empréstimo' || $movimentacao->tipo == 'Transferência')
    <button name="tipo" value="Devolução">Criar devolução com base nestas informações</button><br>
    <button name="tipo" value="Transferência">Criar transferência com base nestas informações</button>
  @else
    <button name="tipo" value="Empréstimo">Criar empréstimo com base nestas informações</button>
  @endif
</form>

@if (empty($movimentacao->deletado))
  <form action="/movimentacao/{{$movimentacao->id}}/excluir" method="POST">
    @csrf
    @method('DELETE')
    <button>Excluir</button>
  </form>
@endif

@endsection
