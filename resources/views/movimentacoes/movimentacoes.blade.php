@extends('layouts.layout')
@section('titulo', 'Movimentações - Almoxarifado')
@section('conteudo')

<form action="/movimentacoes">
  <p>Data: <input type="date" name="data" value="{{$filtro->data}}"></p>
  <p>Hora: <input type="time" name="hora" value="{{$filtro->hora}}"></p>
  <p>Responsável por entregar: <input name="quem_entregou" value="{{$filtro->quem_entregou}}"></p>
  <p>Responsável por receber: <input name="quem_recebeu" value="{{$filtro->quem_recebeu}}"></p>
  <livewire:tipo-da-movimentacao :tipo_da_movimentacao="$filtro->tipo"/>
  <div style="display: flex">
    <?php
      $itens_do_conjunto = [];
      foreach ($movimentacao->itens as $it)
        $itens_do_conjunto[] = $itens->find($it);
      //echo '<pre>';print_r($movimentacao->itens);die();
    ?>
    <livewire:conjunto-de-itens
      :itens_do_conjunto="$itens_do_conjunto"
      :nome="'itens-da-movimentacao'"
      :name="'itens[]'"
      :tipo_da_movimentacao="$movimentacao->tipo"
    />
    <livewire:lista-de-itens
      :lista_de_itens="$itens"
      :destino="'itens-da-movimentacao'"
      :tipo_da_movimentacao="$movimentacao->tipo"
    />
    <livewire:lista-de-grupos
      :lista_de_grupos="$grupos"
      :lista_de_itens="$itens"
      :destino="'itens-da-movimentacao'"
      :tipo_da_movimentacao="$movimentacao->tipo"
    />
  </div>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$filtro->anotacoes}}</textarea>
  </p>
  <input type="submit" value="Filtrar">
  <input type="button" value="Limpar" onclick="limpar_campos()">
  </form>

@if (count($movimentacoes) > 0)
  <p>{{count($movimentacoes) . ' movimentaç' . (count($movimentacoes) > 1 ? 'ões' : 'ão')}}</p>
  @foreach ($movimentacoes as $movimentacao)
    <livewire:ver-movimentacao :movimentacao="$movimentacao" :link="true" />
    <br>
  @endforeach
@else
  <p>Nenhuma movimentação.</p>
@endif

<script>
  function limpar_campos() {
    document.getElementsByName('data')[0].value = '';
    document.getElementsByName('hora')[0].value = '';
    document.getElementsByName('quem_entregou')[0].value = '';
    document.getElementsByName('quem_recebeu')[0].value = '';
    document.getElementsByName('tipo')[0].value = '';
    document.getElementsByName('anotacoes')[0].value = '';
  }
</script>

@endsection
