<?php
    use test\classes\Pessoa;
    $pessoa = Pessoa::last();
?>

<td>Busca o último documento</td>
<td>::last()</td>
<td><?php Pessoa::testLast($pessoa); ?></td>