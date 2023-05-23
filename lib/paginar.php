<?php 

if($inicio+$cuantos<$totalFilas)
    $siguiente=$inicio+$cuantos;
else
    $siguiente=$inicio;
if($inicio-$cuantos>=0)
    $anterior=$inicio-$cuantos;
else
    $anterior=$inicio;

    ?>