@extends('layouts.layout')
@section('titulo', 'Editando item: '.$item->nome.' - Almoxarifado')
@section('conteudo')

<form action="/item/{{$item->id}}/atualizar" method="post">
  @csrf
  @method('PUT')
  <p>Nome: <input name="nome" value="{{$item->nome}}" required></p>
  <p>
    <span style="vertical-align: top;">Categoria: </span>
    @if (count($categorias))
      <select name="categoria">
        <option value=""></option>
        @foreach ($categorias as $categoria)
          <option value="{{$categoria->id}}" {{$categoria->id == $item->categoria['id'] ? 'selected' : ''}}>
            {{$categoria->nome}}
          </option>
        @endforeach
      </select>
    @else
      Não há categorias cadastradas.
    @endif
  </p>
  <p>Disponível: <input type="checkbox" name="disponivel" {{$item->disponivel ? 'checked' : ''}} disabled></p>
  <p>Onde está:
  @if (gettype($item->onde_esta) == 'string')
    {{$item->onde_esta}}</p>
  @else
  </p><ul>
    @foreach ($item->onde_esta as $onde)
      <li>{{$onde['onde']}}: {{$onde['qtde']}}</li>
    @endforeach
  </ul>
  @endif
  <p>
    Em quantidade: <input type="checkbox" name="emQuantidade" onchange="alternarQuantidade(event)" {{$item->quantidade ? 'checked' : ''}}>
    <input type="number" name="quantidade" min="0" size="5" {{$item->quantidade ? '' : 'disabled'}} value="{{$item->quantidade ? $item->quantidade : ''}}">
  </p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$item->anotacoes}}</textarea>
  </p>
  <input type="submit" value="Salvar">
</form>

<script>
  function alternarQuantidade(e) {
    document.getElementsByName("quantidade")[0].disabled = !e.target.checked;
    document.getElementsByName("quantidade")[0].required = e.target.checked;
  }
</script>

@endsection
