@extends('layouts.layout')
@section('titulo', 'Categoria: '.$categoria->nome.' - Almoxarifado')
@section('conteudo')

<livewire:ver-categoria :categoria="$categoria" />
<a href="/categoria/{{$categoria->id}}/editar">Editar</a>
<form action="/categoria/{{$categoria->id}}/excluir" method="POST">
  @csrf
  @method('DELETE')
  <button>Excluir</button>
</form>

@endsection