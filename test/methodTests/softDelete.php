<?php
    use test\classes\Pessoa;
    $pessoa = Pessoa::create(["nome" => "Diego Bentes"]);
    $pessoa->softDelete();
?>

<td>Adiciona deleted_at ao timestamps</td>
<td>.softDelete()</td>
<td><?php $pessoa->testSoftDelete() ?></td>