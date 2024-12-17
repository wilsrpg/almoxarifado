@extends('layouts.layout')
@section('titulo', 'Nova movimentação - Almoxarifado')
@section('conteudo')

<form action="/movimentacoes/criar" method="post" onsubmit="checar_itens(event)">
  @csrf
  <p>Data: <input type="date" name="data" value="<?php echo date('Y-m-d'); ?>"></p>
  <p>Hora: <input type="time" name="hora" value="<?php echo date('H:i'); ?>"></p>
  <p>Responsável por entregar: <input name="quem_entregou"></p>
  <p>Responsável por receber: <input name="quem_recebeu"></p>
  <livewire:tipo-da-movimentacao />
  <div style="display: flex">
    <livewire:conjunto-de-itens
      :nome="'itens-da-movimentacao'"
      :name="'itens[]'"
    />
    <livewire:lista-de-itens
      :lista_de_itens="$itens"
      :destino="'itens-da-movimentacao'"
      :em_movimentacao="true"
    />
    <livewire:lista-de-grupos
      :lista_de_grupos="$grupos"
      :lista_de_itens="$itens"
      :destino="'itens-da-movimentacao'"
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
