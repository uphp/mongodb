<?php
    use test\classes\Pessoa;

    $pessoa = new Pessoa();
    $pessoa->nome = "Diego Bentes Primeiro";
    $pessoa->save();
?>

<td>Cria um novo documento</td>
<td>.save()</td>
<td><?php $pessoa->testSave() ?></td>