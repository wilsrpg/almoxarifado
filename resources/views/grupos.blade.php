<a href="/">Voltar</a>

@if (isset($grupo))
  <p>Nome: {{$grupo->nome}}</p>
  {{--<p>Disponível: {{$grupo->disponivel ? 'Sim' : 'Não'}}</p>--}}
  <p>Itens:</p>
  @if (count($grupo->itens) > 0)
    <ul>
      @foreach ($grupo->itens as $item)
        <li><?= $item->nome ?></li>
      @endforeach
    </ul>
  @else
    <p>Nenhum</p>
  @endif
  <p>Anotações: <br><pre>{{$grupo->anotacoes}}</pre></p>
  <a href="{{$grupo->nome}}/editar">Editar</a>

@elseif (isset($grupos) && count($grupos) > 0)
  <p>{{count($grupos) . (count($grupos) > 1 ? ' grupos:' : ' grupo:')}}</p>
  @foreach ($grupos as $grupo)
    <p>Nome: <a href="grupos/{{$grupo->nome}}">{{$grupo->nome}}</a></p>
    {{--<p>Disponível: {{$grupo->disponivel ? 'Sim' : 'Não'}}</p>--}}
    <p>Itens:</p>
    @if (count($grupo->itens) > 0)
      <ul>
        @foreach ($grupo->itens as $item)
          <li><?= $item->nome ?></li>
        @endforeach
      </ul>
    @else
      <p>Nenhum</p>
    @endif
    <p>Anotações: {{$grupo->anotacoes}}</p>
    <br>
  @endforeach
@else
  <p>Nenhum grupo.</p>
@endif
