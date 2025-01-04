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
  <p>Disponível: <input type="checkbox" checked disabled></p>
  <p>Onde está: <input value="Comunidade" disabled></p>
  <p>
    Em quantidade: <input type="checkbox" name="emQuantidade" onchange="alternarQuantidade(event)">
    <input type="number" name="quantidade" min="0" size="5" disabled>
  </p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes"></textarea>
  </p>
  <input type="submit" value="Cadastrar">
</form>

<script>
  function alternarQuantidade(e) {
    document.getElementsByName("quantidade")[0].disabled = !e.target.checked;
    document.getElementsByName("quantidade")[0].required = e.target.checked;
  }
</script>

@endsection
