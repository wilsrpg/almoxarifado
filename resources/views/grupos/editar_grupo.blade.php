@extends('layouts.layout')
@section('titulo', 'Editando grupo: '.$grupo->nome.' - Almoxarifado')
@section('conteudo')

<form action="/grupo/{{$grupo->id}}/atualizar" method="post">
  @csrf
  @method('PUT')
  <p>Nome do grupo: <input name="nome" value="{{$grupo->nome}}" required></p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$grupo->anotacoes}}</textarea>
  </p>
  <div style="display: flex">
    <div>
      <p>Itens adicionados:</p>
      <?php
        $itens_do_conjunto = [];
        foreach ($grupo->itens as $it)
          $itens_do_conjunto[] = $itens->find($it);
      ?>
      <livewire:conjunto-de-itens :itens_do_conjunto="$itens_do_conjunto" :nome="'itens-do-grupo'" name="itens" />
    </div>
    <div>
      <p>Todos os itens:</p>
      <livewire:lista-de-itens :lista_de_itens="$itens" :destino="'itens-do-grupo'" />
    </div>
  </div>
  <input type="submit" value="Salvar">
</form>

@endsection