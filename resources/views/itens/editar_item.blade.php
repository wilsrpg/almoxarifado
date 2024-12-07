@extends('layouts.layout')
@section('titulo', 'Editando item: '.$item->nome.' - Almoxarifado')
@section('conteudo')

<form action="/item/{{$item->id}}/atualizar" method="post">
  <p>Nome: <input name="nome" value="{{$item->nome}}" required></p>
  <span style="vertical-align: top;">Anotações: </span>
  <textarea name="anotacoes">{{$item->anotacoes}}</textarea>
  <p>
    <span style="vertical-align: top;">Categoria: </span>
    @if (count($categorias))
      <select name="categoria">
        <option value=""></option>
        @foreach ($categorias as $categoria)
          <option value="{{$categoria->id}}" {{$categoria->id == $item->categoria['id'] ? 'selected' : ''}}>
            {{$categoria->nome}}
          </option>
        @endforeach
      </select>
    @else
      Não há categorias cadastradas.
    @endif
  </p>
  <p>Disponível: <input type="checkbox" name="disponivel" {{$item->disponivel ? 'checked' : ''}} disabled></p>
  <p>Onde está: <input value="{{$item->onde_esta}}" disabled></p>
  @csrf
  <input type="submit" value="Salvar">
</form>

@endsection