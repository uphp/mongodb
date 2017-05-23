<?php
    use test\classes\Pessoa;

    $pessoa = new Pessoa();
    $pessoa->nome = "Diego Bentes";
    $pessoa->save();

    $pessoa = Pessoa::findOne(["_id" => $pessoa->_id]);
?>

<td>Busca um único documento</td>
<td>::findOne(Array $filter)</td>
<td><?php $pessoa->testFindOne() ?></td>