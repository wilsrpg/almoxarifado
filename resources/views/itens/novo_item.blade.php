@extends('layouts.layout')
@section('titulo', 'Novo item - Almoxarifado')
@section('conteudo')

<form action="/itens/criar" method="post">
  @csrf
  <p>Nome: <input name="nome" required></p>
  <p>
    <span style="vertical-align: top;">Categoria: </span>
    @if (count($categorias))
      <select name="categoria">
        <option value=""></option>
        @foreach ($categorias as $categoria)
          <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
        @endforeach
      </select>
    @else
      Não há categorias cadastradas.
    @endif
  </p>
  {{--<p>Disponível: <input type="checkbox" name="disponivel" checked></p>--}}
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes"></textarea>
  </p>
  <input type="submit" value="Cadastrar">
</form>

@endsection
