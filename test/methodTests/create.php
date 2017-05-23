<?php
    use test\classes\Pessoa;
    $pessoa = Pessoa::create(["nome" => "Diego Bentes"]);
?>

<td>Cria um novo documento</td>
<td>::create(Array $object_array)</td>
<td><?php $pessoa->testCreate() ?></td>