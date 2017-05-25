<?php
    use test\classes\Pessoa;
    Pessoa::deleteAll();
?>

<td>Exclui todos os documentos</td>
<td>::deleteAll()</td>
<td><?php Pessoa::testDeleteAll() ?></td>