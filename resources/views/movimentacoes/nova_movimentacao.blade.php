@extends('layouts.layout')
@section('titulo', 'Nova movimentação - Almoxarifado')
@section('conteudo')

<form action="/movimentacoes/criar" method="post" onsubmit="checar_itens(event)">
  @csrf
  <p>Data: <input type="date" name="data" value="<?php echo date('Y-m-d'); ?>"></p>
  <p>Hora: <input type="time" name="hora" value="<?php echo date('H:i'); ?>"></p>
  <p>Responsável por entregar: <input name="quem_entregou" value="{{$movimentacao->quem_entregou ?? ''}}" required></p>
  <p>Responsável por receber: <input name="quem_recebeu" value="{{$movimentacao->quem_recebeu ?? ''}}" required></p>
  <livewire:tipo-da-movimentacao :tipo_da_movimentacao="$movimentacao->tipo ?? ''" />
  <div style="display: flex">
    <?php
      $itens_do_conjunto = [];
      if ($movimentacao)
        foreach ($movimentacao->itens as $key => $item) {
          $itens_do_conjunto[] = $itens->find($item);
          if ($movimentacao->qtdes[$key])
            end($itens_do_conjunto)->quantidade = $movimentacao->qtdes[$key];
        }
      //echo '<pre>';print_r($movimentacao->itens);die();
    ?>
    <livewire:conjunto-de-itens
      :itens_do_conjunto="$itens_do_conjunto"
      :nome="'itens-da-movimentacao'"
      :name="'itens[]'"
      :tipo_da_movimentacao="$movimentacao->tipo ?? ''"
    />
    <livewire:lista-de-itens
      :lista_de_itens="$itens"
      :destino="'itens-da-movimentacao'"
      :em_movimentacao="true"
      :tipo_da_movimentacao="$movimentacao->tipo ?? ''"
    />
    <livewire:lista-de-grupos
      :lista_de_grupos="$grupos"
      :lista_de_itens="$itens"
      :destino="'itens-da-movimentacao'"
      :em_movimentacao="true"
      :tipo_da_movimentacao="$movimentacao->tipo ?? ''"
    />
  </div>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes"></textarea>
  </p>
  <input type="submit" value="Registrar">
  <span id="erro" class="vermelho"></span>
</form>

<script>
  function checar_itens(e) {
    e.preventDefault();
    if (document.getElementsByName('itens[]').length == 0)
      document.getElementById('erro').textContent = 'Inclua pelo menos um item.';
    else
      e.target.submit();
  }
</script>

@endsection
