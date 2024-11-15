<a href="/">Voltar</a>

@if (isset($movimentacao))
  <p>Data: {{$movimentacao->data}}</p>
  <p>Responsável: {{$movimentacao->responsavel}}</p>
  <p>Tipo: {{$movimentacao->tipo}}</p>
  <p>Itens: {{$movimentacao->itens}}</p>
  <p>Anotações: {{$movimentacao->anotacoes}}</p>
@elseif (isset($movimentacoes) && count($movimentacoes) > 0)
  @foreach ($movimentacoes as $movimentacao)
    <p>Data: {{$movimentacao->data}}</p>
    <p>Responsável: {{$movimentacao->responsavel}}</p>
    <p>Tipo: {{$movimentacao->tipo}}</p>
    <p>Itens: {{$movimentacao->itens}}</p>
    <p>Anotações: {{$movimentacao->anotacoes}}</p>
    <br>
  @endforeach
@else
  <p>Nenhuma movimentação.</p>
@endif
