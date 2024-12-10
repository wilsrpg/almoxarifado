@extends('layouts.layout')
@section('titulo', 'Novo grupo - Almoxarifado')
@section('conteudo')

<form action="/grupos/criar" method="post">
  <p>Nome do grupo: <input name="nome" required></p>
  <span style="vertical-align: top;">Anotações: </span>
  <textarea name="anotacoes"></textarea>
  {{--<p>
    <span style="vertical-align: top;">Itens: </span>
    @if (count($itens))
      <select name="itens[]" multiple>
        @foreach ($itens as $item)
          <option value="{{$item['_id']}}">{{$item['nome']}}</option>
        @endforeach
      </select>
    @else
      Não há itens cadastrados.
    @endif
  </p>--}}
  <div style="display: flex">
    <div>
      <p>Itens adicionados:</p>
      <livewire:conjunto-de-itens :nome="'itens-do-grupo'" name="itens" />
    </div>
    <div>
      <p>Todos os itens:</p>
      <livewire:conjunto-de-itens :itens="$itens" :tipo="'envio'" :destino="'itens-do-grupo'" :texto_botao="'<'" />
    </div>
  </div>
  @csrf
  <input type="submit" value="Cadastrar">
</form>

@endsection