<?php
    use test\classes\Pessoa;
    $pessoas = Pessoa::all();
?>

<td>Busca todos os documentos</td>
<td>::all()</td>
<td><?php Pessoa::testAll($pessoas) ?></td>