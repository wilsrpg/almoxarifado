@if(session('mensagem'))
  <p>{{session('mensagem')}}</p>
@endif

<p><a href="/itens">Ver itens</a> - <a href="/itens/novo">Cadastrar item</a></p>
<p><a href="/categorias">Ver categorias</a> - <a href="/categorias/nova">Cadastrar categoria</a></p>
<p><a href="/grupos">Ver grupos de itens</a> - <a href="/grupos/novo">Cadastrar grupo de itens</a></p>
<p><a href="/movimentacoes">Ver movimentações</a> - <a href="/movimentacoes/nova">Realizar movimentação</a>
