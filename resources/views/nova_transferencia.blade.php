<a href="/">Voltar</a>

<form action="registrar_transferencia" method="post">
  <p>Data: <input type="date" name="data" value="<?php echo date('Y-m-d'); ?>"></p>
  <p>Hora: <input type="time" name="hora" value="<?php echo date('H:i'); ?>"></p>
  <p>Responsável por transferir: <input type="text" name="quem_transferiu"></p>
  <p>Responsável por receber: <input type="text" name="quem_recebeu"></p>
  {{--<p>Tipo:
    <select name="tipo">
      <option value="" default></option>
      <option value="Empréstimo">Empréstimo</option>
      <option value="Devolução">Devolução</option>
      <option value="Aquisição">Aquisição</option>
      <option value="Exclusão">Exclusão</option>
    </select>
  </p>--}}
  <p>
    <span style="vertical-align: top;">Itens: </span>
    @if (count($itens))
      <select name="itens[]" multiple required>
        @foreach ($itens as $item)
          <option id="<?= $item['_id'] ?>" value="<?= $item['_id'] ?>" <?= $item['disponivel'] ? 'disabled' : '' ?>>
            <?= $item['nome'] ?>
          </option>
        @endforeach
      </select>
    @else
      Não há itens cadastrados.
    @endif
    <span style="vertical-align: top;">Empréstimos: </span>
    @if (count($emprestimos))
      <select id="emprestimos" multiple onchange="atualizarItens(event)">
        @foreach ($emprestimos as $emprestimo)
          <option value="<?= $emprestimo['_id'] ?>">
            <?= date_format(date_create($emprestimo['data']), 'd/m/Y') . ' ' . $emprestimo['hora'] ?>
          </option>
        @endforeach
      </select>
      @foreach ($emprestimos as $emprestimo)
        <input type=hidden id="<?= $emprestimo['_id'] ?>" value="<?= implode(',', $emprestimo['itens']) ?>">
      @endforeach
    @else
      Não há empréstimos cadastrados.
    @endif
  </p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes"></textarea>
  </p>
  @csrf
  <input type="submit" value="Registrar">
</form>

<script>
  function atualizarItens(e) {
    //console.log(e.target.children[0].selected);
    let arr = []; //pra converter HTMLCollection em Array, pra usar forEach
    for (let i = 0; i < e.target.children.length; i++) {
      arr.push(e.target.children[i]);
    }
    //console.log(arr);
    arr.forEach(op => {
      if (document.getElementById(op.value).value) {
        let ids_dos_itens = document.getElementById(op.value).value.split(',');
        //console.log(ids_dos_itens);
        if (ids_dos_itens.length)
          ids_dos_itens.forEach(id => {
            if (op.selected && !document.getElementById(id).disabled)
              document.getElementById(id).selected = op.selected;
          });
      }
    });
  }
</script>