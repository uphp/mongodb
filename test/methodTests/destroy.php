<?php
    use test\classes\Pessoa;
    $pessoa = Pessoa::create(["nome" => "Diego Bentes"]);
    $pessoa = Pessoa::destroy($pessoa->_id);
?>

<td>Exclui um documento</td>
<td>::destroy($id)</td>
<td><?php $pessoa->testDestroy() ?></td>