<STYLE type=text/css>
@import url( ../css/main.css );
@import url( ../css/frame.css );
@import url( ../css/framelogin.css );
@import url( ../css/style.css );
</STYLE>

<?
	session_start();
	include "../include/funcget.php";
	include "../include/funcsql.php";
	include "../include/funcstyle.php";
	if(fsafetylogin())
	{
		$bDatos = TRUE;
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
		include "psw_getpasswddata.php";		
	}
?>