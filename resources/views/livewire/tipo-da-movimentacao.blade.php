<div>
  <p>Tipo:
    <select name="tipo" wire:model.live="tipo_da_movimentacao" {{$opcional ? '' : 'required'}}>
      <option></option>
      <option value="Empréstimo" {{$tipo_da_movimentacao == 'Empréstimo' ? 'selected' : ''}}>Empréstimo</option>
      <option value="Devolução" {{$tipo_da_movimentacao == 'Devolução' ? 'selected' : ''}}>Devolução</option>
      <option value="Transferência" {{$tipo_da_movimentacao == 'Transferência' ? 'selected' : ''}}>Transferência</option>
    </select>
  </p>
</div>
