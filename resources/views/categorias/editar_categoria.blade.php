@extends('layouts.layout')
@section('titulo', 'Editando categoria: '.$categoria->nome.' - Almoxarifado')
@section('conteudo')

<form action="/categoria/{{$categoria->id}}/atualizar" method="post">
  @csrf
  @method('PUT')
  <p>Nome da categoria: <input name="nome" value="{{$categoria->nome}}" required></p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$categoria->anotacoes}}</textarea>
  </p>
  <input type="submit" value="Salvar">
</form>

@endsection