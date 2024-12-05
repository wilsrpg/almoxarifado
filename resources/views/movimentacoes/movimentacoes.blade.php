<a href="/">Ir para página inicial</a>

@if (isset($movimentacao))
  <p>ID: {{$movimentacao->id}}</p>
  <p>Data: {{date_format(date_create($movimentacao->data), 'd/m/Y')}}</p>
  <p>Hora: {{$movimentacao->hora}}</p>
  <p>Tipo: {{$movimentacao->tipo}}</p>
  <p>Responsável por entregar: {{$movimentacao->quem_entregou}}</p>
  <p>Responsável por receber: {{$movimentacao->quem_recebeu}}</p>
  <p>Itens:</p>
  <ul>
    @if (count($movimentacao->itens) > 0)
      @foreach ($movimentacao->itens as $item)
        <li><a href="/item/{{$item->id}}">{{$item->nome}}</a></li>
      @endforeach
    @else
      <li>Nenhum</li>{{--impossível--}}
    @endif
  </ul>
  <p>Anotações: {{$movimentacao->anotacoes}}</p>
  <a href="/movimentacao/{{$movimentacao->id}}/editar">Editar</a>

@elseif (isset($movimentacoes) && count($movimentacoes) > 0)
  <p>{{count($movimentacoes) . (count($movimentacoes) > 1 ? ' movimentacões:' : ' movimentação:')}}</p>
  @foreach ($movimentacoes as $movimentacao)
    <p>ID: <a href="/movimentacao/{{$movimentacao->id}}">{{$movimentacao->id}}</a></p>
    <p>Data: {{date_format(date_create($movimentacao->data), 'd/m/Y')}}</p>
    <p>Hora: {{$movimentacao->hora}}</p>
    <p>Tipo: {{$movimentacao->tipo}}</p>
    <p>Responsável por entregar: {{$movimentacao->quem_entregou}}</p>
    <p>Responsável por receber: {{$movimentacao->quem_recebeu}}</p>
    <p>Itens:</p>
    <ul>
      @if (count($movimentacao->itens) > 0)
        @foreach ($movimentacao->itens as $item)
          <li><a href="/item/{{$item->id}}">{{$item->nome}}</a></li>
        @endforeach
      @else
        <li>Nenhum</li>{{--impossível--}}
      @endif
    </ul>
    <p>Anotações: {{$movimentacao->anotacoes}}</p>
    <br>
  @endforeach
@else
  <p>Nenhuma movimentação.</p>
@endif
