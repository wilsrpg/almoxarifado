@extends('layouts.layout')
@section('titulo', $movimentacao->tipo.': '.$movimentacao->id.' - Almoxarifado')
@section('conteudo')

{{--<livewire:ver-movimentacao :movimentacao="$movimentacao" />--}}
@include('movimentacoes.ver-movimentacao')
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