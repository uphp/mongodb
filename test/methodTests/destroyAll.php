<?php
    use test\classes\Pessoa;
    $pessoa = new Pessoa();
    $pessoa->nome = "Diego Bentes";
    $pessoa->save();
    Pessoa::destroyAll();
?>

<td>Exclui todos os documentos</td>
<td>::destroyAll()</td>
<td><?php Pessoa::testDestroyAll() ?></td>