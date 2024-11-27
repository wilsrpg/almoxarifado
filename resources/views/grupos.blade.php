<a href="/">Voltar</a>

@if (isset($grupo))
  <p>Nome: {{$grupo->nome}}</p>
  <p>Anotações: {{$grupo->anotacoes}}</p>
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
@elseif (isset($grupos) && count($grupos) > 0)
  <p>{{count($grupos) . (count($grupos) > 1 ? ' grupos:' : ' grupo:')}}</p>
  @foreach ($grupos as $grupo)
    <p>Nome: {{$grupo->nome}}</p>
    <p>Anotações: {{$grupo->anotacoes}}</p>
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
    <br>
  @endforeach
@else
  <p>Nenhum grupo.</p>
@endif
