<?php
    use test\classes\Pessoa;

    $pessoa = new Pessoa();
    $pessoa->nome = "Diego Bentes";
    $pessoa->save();
    $pessoa->nome = "Bentes, Diego";
    $pessoa->update();
?>

<td>Atualiza um documento</td>
<td>.update()</td>
<td><?php $pessoa->testUpdate() ?></td>