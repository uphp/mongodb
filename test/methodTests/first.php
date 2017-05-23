<?php
    use test\classes\Pessoa;
    $pessoa = Pessoa::first();
?>

<td>Busca o primeiro documento</td>
<td>::first()</td>
<td><?php Pessoa::testFirst($pessoa); ?></td>