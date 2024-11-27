@if(session('cadastrou_categoria'))
  <p>Categoria cadastrada com sucesso.</p>
@endif
@if(session('cadastrou_item'))
  <p>Item cadastrado com sucesso.</p>
@endif
@if(session('cadastrou_grupo'))
  <p>Grupo cadastrado com sucesso.</p>
@endif
@if(session('registrou_emprestimo'))
  <p>Empréstimo realizado com sucesso.</p>
@endif
@if(session('registrou_devolucao'))
  <p>Devolução realizada com sucesso.</p>
@endif

<p><a href="categorias">Ver categorias</a> - <a href="nova_categoria">Cadastrar categoria</a></p>
<p><a href="itens">Ver itens</a> - <a href="novo_item">Cadastrar item</a></p>
<p><a href="grupos">Ver grupos de itens</a> - <a href="novo_grupo">Cadastrar grupo de itens</a></p>
<p><a href="movimentacoes">Ver movimentações</a> - <a href="novo_emprestimo">Realizar empréstimo</a> - <a href="nova_devolucao">Realizar devolução</a></p>
