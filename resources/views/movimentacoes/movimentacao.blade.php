@extends('layouts.layout')
@section('titulo', $movimentacao->tipo.': '.$movimentacao->id.' - Almoxarifado')
@section('conteudo')

<livewire:ver-movimentacao :movimentacao="$movimentacao" />
<a href="/movimentacao/{{$movimentacao->id}}/editar">Editar</a>
<form action="/movimentacao/{{$movimentacao->id}}/excluir" method="POST">
  @csrf
  @method('DELETE')
  <button>Excluir</button>
</form>

@endsection