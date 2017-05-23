<?php
    use test\classes\Pessoa;
    
    $pessoa = new Pessoa();
    $pessoa->nome = "Diego Bentes";
    $pessoa->save();
    $pessoa->delete();
?>

<td>Exclui um documento</td>
<td>.delete()</td>
<td><?php $pessoa->testDelete() ?></td>