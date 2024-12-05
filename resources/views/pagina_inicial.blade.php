@if(session('cadastrou_categoria'))
  <p>Categoria cadastrada com sucesso.</p>
@elseif(session('cadastrou_item'))
  <p>Item cadastrado com sucesso.</p>
@elseif(session('cadastrou_grupo'))
  <p>Grupo cadastrado com sucesso.</p>
@elseif(session('registrou_emprestimo'))
  <p>Empréstimo realizado com sucesso.</p>
@elseif(session('registrou_devolucao'))
  <p>Devolução realizada com sucesso.</p>
@elseif(session('registrou_transferencia'))
  <p>Transferência realizada com sucesso.</p>
@elseif(session('atualizou_categoria'))
  <p>Categoria atualizada com sucesso.</p>
@elseif(session('atualizou_item'))
  <p>Item atualizado com sucesso.</p>
@elseif(session('atualizou_grupo'))
  <p>Grupo de itens atualizado com sucesso.</p>
@elseif(session('atualizou_emprestimo'))
  <p>Empréstimo atualizado com sucesso.</p>
@elseif(session('atualizou_devolucao'))
  <p>Devolução atualizada com sucesso.</p>
@elseif(session('atualizou_transferencia'))
  <p>Transferência atualizada com sucesso.</p>
@endif

<p><a href="/categorias">Ver categorias</a> - <a href="/nova_categoria">Cadastrar categoria</a></p>
<p><a href="/itens">Ver itens</a> - <a href="/novo_item">Cadastrar item</a></p>
<p><a href="/grupos">Ver grupos de itens</a> - <a href="/novo_grupo">Cadastrar grupo de itens</a></p>
<p><a href="/movimentacoes">Ver movimentações</a> - <a href="/nova_movimentacao">Realizar movimentação</a>
