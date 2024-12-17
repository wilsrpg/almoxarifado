@extends('layouts.layout')
@section('titulo', $movimentacao->tipo.': '.$movimentacao->id.' - Almoxarifado')
@section('conteudo')

<livewire:ver-movimentacao :movimentacao="$movimentacao" />
<a href="/movimentacao/{{$movimentacao->id}}/editar">Editar</a><br>
<a href="/movimentacoes/nova/{{$movimentacao->id}}">Criar movimentação com estes itens</a>
@if (empty($movimentacao->deletado))
<form action="/movimentacao/{{$movimentacao->id}}/excluir" method="POST">
  @csrf
  @method('DELETE')
  <button>Excluir</button>
</form>
@endif

@endsection