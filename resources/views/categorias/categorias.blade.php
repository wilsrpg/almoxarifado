@extends('layouts.layout')
@section('titulo', 'Categorias - Almoxarifado')
@section('conteudo')

<form action="/categorias" onformdata="remover_campos_em_branco(event)">
  <p>Nome da categoria: <input name="nome" value="{{$filtro->nome}}"></p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$filtro->anotacoes}}</textarea>
  </p>
  <input type="submit" value="Filtrar">
  <input type="button" value="Limpar" onclick="limpar_campos()">
</form>

@if (count($categorias) > 0)
  <p>{{count($categorias) . ' categoria' . (count($categorias) > 1 ? 's' : '')}}</p>
  @foreach ($categorias as $categoria)
    <livewire:ver-categoria :categoria="$categoria" :link="true" />
    <br>
  @endforeach
@else
  <p>Nenhuma categoria.</p>
@endif

<script>
  function remover_campos_em_branco(e) {
    if (document.getElementsByName('nome')[0].value == '') e.formData.delete('nome');
    if (document.getElementsByName('anotacoes')[0].value == '') e.formData.delete('anotacoes');
  }

  function limpar_campos() {
    document.getElementsByName('nome')[0].value = '';
    document.getElementsByName('anotacoes')[0].value = '';
  }
</script>

@endsection
