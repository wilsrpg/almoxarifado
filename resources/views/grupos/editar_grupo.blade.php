@extends('layouts.layout')
@section('titulo', 'Editando grupo: '.$grupo->nome.' - Almoxarifado')
@section('conteudo')

<form action="/grupo/{{$grupo->id}}/atualizar" method="post" onsubmit="checar_itens(event)">
  @csrf
  @method('PUT')
  <p>Nome do grupo: <input name="nome" value="{{$grupo->nome}}" required></p>
  <div style="display: flex">
    <?php
      $itens_do_conjunto = [];
      //for ($i=0; $i < count($grupo->itens); $i++) { 
      //  $itens_do_conjunto[] = $itens->find($grupo->itens[$i]);
      //  if ($grupo->qtdes[$i])
      //    end($itens_do_conjunto)->quantidade = $grupo->qtdes[$i];
      //}
      foreach ($grupo->itens as $key => $item) {
        $itens_do_conjunto[] = $itens->find($item);
        if ($grupo->qtdes[$key])
          end($itens_do_conjunto)->quantidade = $grupo->qtdes[$key];
      }
    ?>
    <livewire:conjunto-de-itens :itens_do_conjunto="$itens_do_conjunto" :nome="'itens-do-grupo'" :name="'itens[]'" />
    <livewire:lista-de-itens :lista_de_itens="$itens" :destino="'itens-do-grupo'" />
  </div>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$grupo->anotacoes}}</textarea>
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
