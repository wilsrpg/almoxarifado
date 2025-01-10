@extends('layouts.layout')
@section('titulo', 'Itens - Almoxarifado')
@section('conteudo')

<a href="/itens/novo">Novo item</a>
<p>Filtros</p>
<form action="/itens" onsubmit="enviar(event)" onformdata="remover_campos_em_branco(event)">
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
    Emprestado:
    <select name="emprestado">
      <option value="">Qualquer</option>
      <option value="sim" {{$filtro->emprestado == 'sim' ? 'selected' : ''}}>Sim</option>
      <option value="nao" {{$filtro->emprestado == 'nao' ? 'selected' : ''}}>Não</option>
    </select>
  </p>
  <p>
    Em quantidade:
    <select name="emQuantidade" onchange="alternarQuantidade(event)">
      <option value="">Qualquer</option>
      <option value="sim" {{$filtro->emQuantidade == 'sim' ? 'selected' : ''}}>Sim</option>
      <option value="nao" {{$filtro->emQuantidade == 'nao' ? 'selected' : ''}}>Não</option>
    </select>
    <input type="number" name="quantidade" min="0" size="5" value="{{$filtro->quantidade != '' ? $filtro->quantidade : ''}}">
  </p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$filtro->anotacoes}}</textarea>
  </p>
  <input type="submit" value="Filtrar">
  <input type="button" value="Limpar" onclick="limpar_campos()">
</form>

@if (count($itens) > 0)
  <p>{{count($itens) . ' ite' . (count($itens) > 1 ? 'ns' : 'm')}}</p>
  <table>
    <tr>
      <th>Nome</th>
      <th>Categoria</th>
      <th>Disponível</th>
      <th>Quantidade</th>
      <th>Onde está</th>
      <th>Anotações</th>
      <th>Movimentações</th>
    </tr>
    @foreach ($itens as $item)
      <tr>
        <td>
          <a href="/item/{{$item->id}}" {{isset($item->deletado) ? 'class=vermelho' : ''}}>{{$item->nome}}</a>
        </td>
        <td><a href="/categoria/{{$item->categoria['id']}}">{{$item->categoria['nome']}}</a></td>
        <td>{{$item->disponivel ? 'Sim' : 'Não'}}</td>
        <td> {{$item->quantidade ?? ''}}</td>
        <td>
          @if (gettype($item->onde_esta) == 'string')
            {{$item->onde_esta}}
          @else
            <ul>
              @foreach ($item->onde_esta as $onde)
                <li>{{$onde['onde']}}: {{$onde['qtde']}}</li>
              @endforeach
            </ul>
          @endif
        </td>
        <td><pre>{{$item->anotacoes}}</pre></td>
        <td>{{count($item->movimentacoes)}} <a href="/movimentacoes?itens[]={{$item->id}}">(Ver tudo)</a></td>
      </tr>
    @endforeach
  </table>
@else
  <p>Nenhum item.</p>
@endif

<script>
  function remover_campos_em_branco(e) {
    if (document.getElementsByName('nome')[0].value == '') e.formData.delete('nome');
    if (document.getElementsByName('categoria')[0].value == '') e.formData.delete('categoria');
    if (document.getElementsByName('disponivel')[0].value == '') e.formData.delete('disponivel');
    if (document.getElementsByName('onde_esta')[0].value == '') e.formData.delete('onde_esta');
    if (document.getElementsByName('emQuantidade')[0].value == '') e.formData.delete('emQuantidade');
    if (document.getElementsByName('quantidade')[0].value == '') e.formData.delete('quantidade');
    if (document.getElementsByName('anotacoes')[0].value == '') e.formData.delete('anotacoes');
  }

  function enviar(e) {
    e.preventDefault();
    const form = new FormData(document.getElementsByTagName('form')[0]);
    if (Array.from(form.entries()).length > 0)
      e.target.submit();
    else
      window.location = e.target.action;
  }

  function alternarQuantidade(e) {
    document.getElementsByName("quantidade")[0].disabled = e.target.value == 'nao';
  }

  function limpar_campos() {
    document.getElementsByName('nome')[0].value = '';
    document.getElementsByName('categoria')[0].value = '';
    document.getElementsByName('disponivel')[0].value = '';
    document.getElementsByName('onde_esta')[0].value = '';
    document.getElementsByName('emQuantidade')[0].value = '';
    document.getElementsByName('quantidade')[0].value = '';
    document.getElementsByName('anotacoes')[0].value = '';
  }
</script>

@endsection
