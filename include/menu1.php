<?
	if(fsafetylogin())
	{
	}
	else
	{
		$_SESSION['sIni'] = "";
		header("Location:../index.php");
	}
?>
<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
</STYLE>
<div id="dmenu"> 
	<a href="" onclick="clickmisdatos();  return false;" class="imydata" title="Mis datos personales" >Mis datos </a> 
	<a href="" onclick="clickpasswd();  return false;" class="ipasswd" title="cambiar contraseña" >Contrase&ntilde;a</a> 
	<a href="" onclick="clicklistado();  return false;" class="imatriculas" title="Mostrar matriculas anteriores" >Listados</a> 
	<a href="" onclick="clickacta();  return false;" class="iplan" title="Ver plan de estudios" >Actas</a> 	
	<a href="" onclick="clicksilabo();  return false;" class="ihorario" title="Silabo" >Silabo</a>
	<a href="../close.php" class="iexit" title="Salir del Sistema" >Salir</a> </div>
