@extends('layouts.layout')
@section('titulo', 'Grupo: '.$grupo->nome.' - Almoxarifado')
@section('conteudo')

<livewire:ver-grupo :grupo="$grupo" />
<a href="/grupo/{{$grupo->id}}/editar">Editar</a>
@if (empty($grupo->deletado))
<form action="/grupo/{{$grupo->id}}/excluir" method="POST">
  @csrf
  @method('DELETE')
  <button>Excluir</button>
</form>
@endif

@endsection