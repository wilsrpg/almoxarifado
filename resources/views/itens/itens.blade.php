@extends('layouts.layout')
@section('titulo', 'Itens - Almoxarifado')
@section('conteudo')

<form action="/itens">
  <p>Nome: <input name="nome" value="{{$filtro->nome}}"></p>
  <p>
    <span style="vertical-align: top;">Categoria: </span>
    <select name="categoria">
      <option value="">Qualquer</option>
      <option value="sem_categoria" {{$filtro->categoria == 'sem_categoria' ? 'selected' : ''}}>
        Sem categoria
      </option>
      @foreach ($categorias as $categoria)
        <option value="{{$categoria->nome}}" {{$categoria->nome == $filtro->categoria ? 'selected' : ''}}>
          {{$categoria->nome}}
        </option>
      @endforeach
    </select>
  </p>
  <p>Disponível:
    <select name="disponivel">
      <option value="">Qualquer</option>
      <option value="sim" {{$filtro->disponivel === true ? 'selected' : ''}}>Sim</option>
      <option value="nao" {{$filtro->disponivel === false ? 'selected' : ''}}>Não</option>
    </select>
    </p>
  <p>Onde está: <input name="onde_esta" value="{{$filtro->onde_esta}}"></p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$filtro->anotacoes}}</textarea>
  </p>
  <input type="submit" value="Filtrar">
  <input type="button" value="Limpar" onclick="limpar_campos()">
</form>

@if (count($itens) > 0)
  <p>{{count($itens) . ' ite' . (count($itens) > 1 ? 'ns' : 'm')}}</p>
  @foreach ($itens as $item)
    <livewire:ver-item :item="$item" :link="true" />
    <br>
  @endforeach
@else
  <p>Nenhum item.</p>
@endif

<script>
  function limpar_campos() {
    document.getElementsByName('nome')[0].value = '';
    document.getElementsByName('categoria')[0].value = '';
    document.getElementsByName('disponivel')[0].value = '';
    document.getElementsByName('onde_esta')[0].value = '';
    document.getElementsByName('anotacoes')[0].value = '';
  }
</script>

@endsection
