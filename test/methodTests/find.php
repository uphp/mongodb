<?php
    use test\classes\Pessoa;

    $pessoa = new Pessoa();
    $pessoa->nome = "Diego Bentes Último";
    $pessoa->save();

    $pessoa = Pessoa::find($pessoa->_id);
?>

<td>Busca um único documento</td>
<td>::find($id)</td>
<td><?php $pessoa->testFind() ?></td>