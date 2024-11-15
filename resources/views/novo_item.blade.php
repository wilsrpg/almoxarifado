<a href="/">Voltar</a>

<form action="cadastrar_item" method="post">
  <p>Nome: <input type="text" name="nome" required></p>
  <p>Anotações: <input type="text" name="anotacoes"></p>
  {{--<p>Disponível: <input type="text" name="disponivel"></p>--}}
  <p>Itens associados: <input type="text" name="itens_associados"></p>
  @csrf
  <input type="submit" value="Cadastrar">
</form>