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
		$_SESSION['sSilaend_ing'] = 'T';
		$vCont = 1;
		$bDatos = TRUE;
/*		if(fFechad(fFecha()) == '10/03/2008')
		{
			$bDatos = TRUE;
			$_SESSION['sSilaend_ing'] = 'T';
		}*/
		$_SESSION['sSilaend_ing'] = 'F';
	}
	else
	{
		header("Location:../index.php");
	}
	if($bDatos == TRUE)
	{
		include "si2_viewcursosdata.php";
	}
?>
