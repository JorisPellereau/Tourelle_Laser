<?php
function connectMaBase(){
    $base = mysql_connect ('localhost', 'root', 'JorisP');  
    mysql_select_db ('Tourelle_laser', $base) ;
}
?>
