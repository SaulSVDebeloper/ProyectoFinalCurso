<?php

include "funcionesProyecto.php";

if (isset($_REQUEST['valor'])) {
    $pag= $_REQUEST['valor'];
    if ($pag > 0) {
        $pagina = $pag - 3;
        echo $pagina;
    }else{
        $pag = 0;
        echo $pag;
    }
}