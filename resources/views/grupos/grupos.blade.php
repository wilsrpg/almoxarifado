@extends('layouts.layout')
@section('titulo', 'Grupos - Almoxarifado')
@section('conteudo')

<form action="/grupos" onformdata="remover_campos_em_branco(event)">
  <p>Nome do grupo: <input name="nome" value="{{$filtro->nome}}"></p>
  <div style="display: flex">
    <?php
      $itens_do_conjunto = [];
      foreach ($filtro->itens as $it)
        $itens_do_conjunto[] = $itens->find($it);
    ?>
    <livewire:conjunto-de-itens :itens_do_conjunto="$itens_do_conjunto" :nome="'itens-do-grupo'" :name="'itens[]'" />
    <livewire:lista-de-itens :lista_de_itens="$itens" :destino="'itens-do-grupo'" />
  </div>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$filtro->anotacoes}}</textarea>
  </p>
  <input type="submit" value="Filtrar">
  <input type="button" value="Limpar" onclick="limpar_campos()">
</form>

@if (count($grupos) > 0)
  <p>{{count($grupos) . ' grupo' . (count($grupos) > 1 ? 's' : '')}}</p>
  @foreach ($grupos as $grupo)
    <livewire:ver-grupo :grupo="$grupo" :link="true" />
    <br>
  @endforeach
@else
  <p>Nenhum grupo.</p>
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
