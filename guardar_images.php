<?php

$vConexion = mysql_connect("10.1.1.134","unapmatri","master2005");

$vConsulta = "select num_mat, cod_car from unap.solcarne2008";
$cr_usuario = mysql_query($vConsulta, $vConexion);
$vContador = 1;

while ($ar_usuario = mysql_fetch_array($cr_usuario) )
{
        //if ($ar_usuario['cod_car'] == '23')
        //{
                $archivo = "/nauj/fotos/0120000" .$ar_usuario['num_mat']. ".jpg";

                $tamanio  = filesize($archivo);
                $tipo     = "image/jpg";
                $nombre  = $ar_usuario['num_mat']. ".jpg";
                $titulo   = $ar_usuario['num_mat'];

                echo $vContador++ . "<Br>";

                if ( $archivo != "" )
                {
                        $fp = fopen($archivo, "rb");
                        $contenido = fread($fp, $tamanio);
                        $contenido = addslashes($contenido);
                        fclose($fp);

                        //echo $contenido. "<br>";

                        //$conn = mysql_connect("localhost","bingo","holahola");

                        $qry = "insert into unap.picture2 values ('".$ar_usuario['num_mat']."', '".$ar_usuario['cod_car']."', '$nombre', '$contenido', '$tipo', '2')";
                        /*$qry = "insert into unap.picture set archivo = '$nombre', contenido = '$contenido', tipo = '$tipo' ";
                        $qry .= "where num_mat = '" .$ar_usuario['num_mat']. "'";*/

                        mysql_query($qry);

                        if(mysql_affected_rows($vConexion) > 0)
                                print "Se ha guardado el archivo en la base de datos.";
                        else
                                print "NO se ha podido guardar el archivo en la base de datos.";
                }
                else
                        echo "NO se pudo subir al servidor";
        //}

}

?>
