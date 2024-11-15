<a href="/">Voltar</a>

<form action="registrar_movimentacao" method="post">
  <p>Data: <input type="date" name="data"></p>
  <p>Responsável: <input type="text" name="responsavel"></p>
  <p>Tipo:
    <select name="tipo">
      <option value="" default></option>
      <option value="Empréstimo">Empréstimo</option>
      <option value="Devolução">Devolução</option>
      <option value="Aquisição">Aquisição</option>
      <option value="Exclusão">Exclusão</option>
    </select>
  </p>
  <p>Itens: <input type="text" name="itens"></p>
  <p>Anotações: <input type="text" name="anotacoes"></p>
  @csrf
  <input type="submit" value="Registrar">
</form>