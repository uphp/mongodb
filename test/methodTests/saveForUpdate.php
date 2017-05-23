<?php
    use test\classes\Pessoa;

    $pessoa = new Pessoa();
    $pessoa->nome = "Diego Bentes";
    $pessoa->save();
    $pessoa->nome = "Bentes, Diego";
    $pessoa->save();
?>

<td>Atualiza um novo documento utilizando o save</td>
<td>.save()</td>
<td><?php $pessoa->testUpdate() ?></td>