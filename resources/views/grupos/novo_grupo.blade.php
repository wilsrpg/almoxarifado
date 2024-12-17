@extends('layouts.layout')
@section('titulo', 'Novo grupo - Almoxarifado')
@section('conteudo')

<form action="/grupos/criar" method="post" onsubmit="checar_itens(event)">
  @csrf
  <p>Nome do grupo: <input name="nome" required></p>
  <div style="display: flex">
    <livewire:conjunto-de-itens :nome="'itens-do-grupo'" :name="'itens[]'" />
    <livewire:lista-de-itens :lista_de_itens="$itens" :destino="'itens-do-grupo'" />
  </div>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes"></textarea>
  </p>
  <input type="submit" value="Cadastrar">
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
