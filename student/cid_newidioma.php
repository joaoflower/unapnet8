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
		$vQuery = "select codigo from estudiantes ";
		$vQuery .= "where paterno = '{$_SESSION['sUserpaterno']}' and materno = '{$_SESSION['sUsermaterno']}' and nombres = '{$_SESSION['sUsernombres']}' ";
		
		$cResult = fQueryi($vQuery);
		
		while($aResult = mysql_fetch_array($cResult))
		{
			$vQuery = "update estudiantes set cod_unap = '{$_SESSION['sUsercod_usu']}' ";
			$vQuery .= "where codigo = '{$aResult['codigo']}' ";
			$cResult2 = fInupdei($vQuery);
		}				
				
		include "cid_viewidiomasdata.php";
	}
	else
	{
		header("Location:../index.php");
	}
	
?>