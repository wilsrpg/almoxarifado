<a href="/">Voltar</a>

@if (isset($item))
  <p>Nome: {{$item->nome}}</p>
  <p>Anotações: {{$item->anotacoes}}</p>
  <p>Disponível: {{$item->disponivel}}</p>
  <p>Itens associados: {{$item->associados}}</p>
@elseif (isset($itens) && count($itens) > 0)
  @foreach ($itens as $item)
    <p>Nome: {{$item->nome}}</p>
    <p>Anotações: {{$item->anotacoes}}</p>
    <p>Disponível: {{$item->disponivel}}</p>
    <p>Itens associados: {{$item->associados}}</p>
    <br>
  @endforeach
@else
  <p>Nenhum item.</p>
@endif
