<?php
    use test\classes\Pessoa;
    $pessoas = Pessoa::findAll();
?>

<td>Busca todos os documentos</td>
<td>::findAll(Array $filter=[])</td>
<td><?php Pessoa::testFindAll($pessoas) ?></td>