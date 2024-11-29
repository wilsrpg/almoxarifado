<a href="/">Voltar</a>

@if (isset($movimentacao))
  <p>Data: {{date_format(date_create($movimentacao->data), 'd/m/Y')}}</p>
  <p>Hora: {{$movimentacao->hora}}</p>
  <p>Tipo: {{$movimentacao->tipo}}</p>
  @if ($movimentacao->tipo == 'Empréstimo')
  <p>Responsável por entregar: {{$movimentacao->quem_entregou}}</p>
  <p>Responsável por levar: {{$movimentacao->quem_levou}}</p>
  @elseif ($movimentacao->tipo == 'Devolução')
  <p>Responsável por receber: {{$movimentacao->quem_recebeu}}</p>
  <p>Responsável por devolver: {{$movimentacao->quem_devolveu}}</p>
  @elseif ($movimentacao->tipo == 'Transferência')
  <p>Responsável por transferir: {{$movimentacao->quem_transferiu}}</p>
  <p>Responsável por receber: {{$movimentacao->quem_recebeu}}</p>
  @endif
  <p>Itens:</p>
  @if (count($movimentacao->itens) > 0)
    <ul>
      @foreach ($movimentacao->itens as $item)
        <li><?= $item->nome ?></li>
      @endforeach
    </ul>
  @else
    <p>Nenhum</p>{{--impossível--}}
  @endif
  <p>Anotações: {{$movimentacao->anotacoes}}</p>
@elseif (isset($movimentacoes) && count($movimentacoes) > 0)
  <p>{{count($movimentacoes) . (count($movimentacoes) > 1 ? ' movimentacões:' : ' movimentação:')}}</p>
  @foreach ($movimentacoes as $movimentacao)
    <p>Data: {{date_format(date_create($movimentacao->data), 'd/m/Y')}}</p>
    <p>Hora: {{$movimentacao->hora}}</p>
    <p>Tipo: {{$movimentacao->tipo}}</p>
    @if ($movimentacao->tipo == 'Empréstimo')
    <p>Responsável por entregar: {{$movimentacao->quem_entregou}}</p>
    <p>Responsável por levar: {{$movimentacao->quem_levou}}</p>
    @elseif ($movimentacao->tipo == 'Devolução')
    <p>Responsável por receber: {{$movimentacao->quem_recebeu}}</p>
    <p>Responsável por devolver: {{$movimentacao->quem_devolveu}}</p>
    @elseif ($movimentacao->tipo == 'Transferência')
    <p>Responsável por transferir: {{$movimentacao->quem_transferiu}}</p>
    <p>Responsável por receber: {{$movimentacao->quem_recebeu}}</p>
    @endif
    <p>Itens:</p>
    @if (count($movimentacao->itens) > 0)
      <ul>
        @foreach ($movimentacao->itens as $item)
          <li><?= $item->nome ?></li>
        @endforeach
      </ul>
    @else
      <p>Nenhum</p>{{--impossível--}}
    @endif
    <p>Anotações: {{$movimentacao->anotacoes}}</p>
    <br>
  @endforeach
@else
  <p>Nenhuma movimentação.</p>
@endif
