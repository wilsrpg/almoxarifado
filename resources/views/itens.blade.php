<a href="/">Voltar</a>

@if (isset($item))
  <p>Nome: {{$item->nome}}</p>
  <p>Anotações: {{$item->anotacoes}}</p>
  <p>Categoria: {{$item->categoria}}</p>
  <p>Disponível: {{$item->disponivel ? 'Sim' : 'Não'}}</p>
@elseif (!empty($itens))
  <p>{{count($itens) . (count($itens) > 1 ? ' itens:' : ' item:')}}</p>
  @foreach ($itens as $item)
    <p>Nome: {{$item->nome}}</p>
    <p>Anotações: {{$item->anotacoes}}</p>
    <p>Categoria: {{$item->categoria}}</p>
    <p>Disponível: {{$item->disponivel ? 'Sim' : 'Não'}}</p>
    <br>
  @endforeach
@else
  <p>Nenhum item.</p>
@endif
