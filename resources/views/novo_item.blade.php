<a href="/">Voltar</a>

<form action="cadastrar_item" method="post">
  <p>Nome: <input type="text" name="nome" required></p>
  <span style="vertical-align: top;">Anotações: </span>
  <textarea name="anotacoes"></textarea>
  <p>Disponível: <input type="checkbox" name="disponivel" checked></p>
  @csrf
  <input type="submit" value="Cadastrar">
</form>