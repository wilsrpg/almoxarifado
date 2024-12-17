@extends('layouts.layout')
@section('titulo', 'Editando movimentação: '.$movimentacao->nome.' - Almoxarifado')
@section('conteudo')

<form action="/movimentacao/{{$movimentacao->id}}/atualizar" method="post" onsubmit="checar_itens(event)">
  @csrf
  @method('PUT')
  <p>ID: {{$movimentacao->id}}</p>
  <p>Data: <input type="date" name="data" value="{{$movimentacao->data}}"></p>
  <p>Hora: <input type="time" name="hora" value="{{$movimentacao->hora}}"></p>
  <p>Responsável por entregar: <input name="quem_entregou" value="{{$movimentacao->quem_entregou}}"></p>
  <p>Responsável por receber: <input name="quem_recebeu" value="{{$movimentacao->quem_recebeu}}"></p>
  <livewire:tipo-da-movimentacao :tipo_da_movimentacao="$movimentacao->tipo"/>
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
    <textarea name="anotacoes">{{$movimentacao->anotacoes}}</textarea>
  </p>
  <input type="submit" value="Salvar">
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
