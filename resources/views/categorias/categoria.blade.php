@extends('layouts.layout')
@section('titulo', 'Categoria: '.$categoria->nome.' - Almoxarifado')
@section('conteudo')

{{--<livewire:ver-categoria :categoria="$categoria" />--}}
@include('categorias.ver-categoria')
<a href="/categoria/{{$categoria->id}}/editar">Editar</a>
@if (empty($categoria->deletado))
<form action="/categoria/{{$categoria->id}}/excluir" method="POST">
  @csrf
  @method('DELETE')
  <button>Excluir</button>
</form>
@endif

@endsection