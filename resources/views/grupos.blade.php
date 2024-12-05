<a href="/">Ir para página inicial</a>

@if (isset($grupo))
  <p>Nome: {{$grupo->nome}}</p>
  {{--<p>Disponível: {{$grupo->disponivel ? 'Sim' : 'Não'}}</p>--}}
  <p>Itens:</p>
  <ul>
    @if (count($grupo->itens) > 0)
      @foreach ($grupo->itens as $item)
        <li><a href="/itens/{{$item->nome}}">{{$item->nome}}</a></li>
      @endforeach
    @else
      <li>Nenhum</li>
    @endif
  </ul>
  <p>Anotações: <br><pre>{{$grupo->anotacoes}}</pre></p>
  <a href="/grupos/{{$grupo->nome}}/editar">Editar</a>

@elseif (isset($grupos) && count($grupos) > 0)
  <p>{{count($grupos) . (count($grupos) > 1 ? ' grupos:' : ' grupo:')}}</p>
  @foreach ($grupos as $grupo)
    <p>Nome: <a href="/grupos/{{$grupo->nome}}">{{$grupo->nome}}</a></p>
    {{--<p>Disponível: {{$grupo->disponivel ? 'Sim' : 'Não'}}</p>--}}
    <p>Itens:</p>
    <ul>
      @if (count($grupo->itens) > 0)
        @foreach ($grupo->itens as $item)
          <li><a href="/itens/{{$item->nome}}">{{$item->nome}}</a></li>
        @endforeach
      @else
        <li>Nenhum</li>
      @endif
    </ul>
    <p>Anotações: {{$grupo->anotacoes}}</p>
    <br>
  @endforeach
@else
  <p>Nenhum grupo.</p>
@endif
