<a href="/">Voltar</a>

@if (isset($item))
  <p>Nome: {{$item->nome}}</p>
  <p>Categoria: {{$item->categoria}}</p>
  <p>Disponível: {{$item->disponivel ? 'Sim' : 'Não'}}</p>
  <p>Onde está: {{$item->onde_esta}}</p>
  <p>Anotações: <br><pre>{{$item->anotacoes}}</pre></p>
  <a href="{{$item->nome}}/editar">Editar</a>

@elseif (!empty($itens))
  <p>{{count($itens) . (count($itens) > 1 ? ' itens:' : ' item:')}}</p>
  @foreach ($itens as $item)
    <p>Nome: <a href="itens/{{$item->nome}}">{{$item->nome}}</a></p>
    <p>Categoria: {{$item->categoria}}</p>
    <p>Disponível: {{$item->disponivel ? 'Sim' : 'Não'}}</p>
    <p>Onde está: {{$item->onde_esta}}</p>
    <p>Anotações: {{$item->anotacoes}}</p>
    <br>
  @endforeach
@else
  <p>Nenhum item.</p>
@endif
