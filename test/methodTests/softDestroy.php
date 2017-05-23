<?php
    use test\classes\Pessoa;
    $pessoa = Pessoa::create(["nome" => "Diego Bentes"]);
    $pessoa = Pessoa::softDestroy($pessoa->_id);
?>

<td>Adiciona deleted_at ao timestamps</td>
<td>::softDestroy()</td>
<td><?php $pessoa->testSoftDestroy() ?></td>