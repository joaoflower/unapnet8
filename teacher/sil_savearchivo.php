<?php
	session_start();
	include "../include/funcget.php";
	include "../include/funcsql.php";
	include "../include/funcstyle.php";
	include "../include/funcoption.php";
	
	if(fsafetylogin())
	{
		if($_SESSION['sSilaupload'] == FALSE)
		{
			$vDestino = "";
			if (is_uploaded_file($_FILES['rArchivo']['tmp_name'])) 
			{ 
//				$vDestino = "/var/www/html/unapnet8/teacher/silabus/".$_SESSION['sSilaano_aca']."/car".$_SESSION['sSilacod_car']."/".$_SESSION['sSilaano_aca'] ;
	//			//$vDestino = "C:\\AppServ\\www\\unapnet8\\teacher\\silabus\\car".$_SESSION['sSilacod_car']."\\".$_SESSION['sSilaano_aca'] ;
		//		$vDestino .= $_SESSION['sSilaper_aca'].$_SESSION['sSilacod_car'].$_SESSION["sSilapln_est"];
//				$vDestino .= $_SESSION["sSilacod_cur"].$_SESSION["sSilasec_gru"].$_SESSION["sSilamod_mat"];
//				$vDestino .= "_".$_SESSION['sUsercod_usu']."_".$_FILES['rArchivo']['name'];
				
				$vTam = strlen($_FILES['rArchivo']['name']);
				$vType = substr($_FILES['rArchivo']['name'], $vTam - 3, 3);
				
				if($vType == "doc" or $vType == "pdf")
				{
					$vDestino = "/var/www/html/unapnet8/teacher/silabus/".$_SESSION['sSilaano_aca']."/car".$_SESSION['sSilacod_car']."/".$_SESSION['sSilaano_aca'] ;
					//$vDestino = "C:\\AppServ\\www\\unapnet8\\teacher\\silabus\\car".$_SESSION['sSilacod_car']."\\".$_SESSION['sSilaano_aca'] ;
					$vDestino .= $_SESSION['sSilaper_aca'].$_SESSION['sSilacod_car'].$_SESSION["sSilapln_est"];
					$vDestino .= $_SESSION["sSilacod_cur"].$_SESSION["sSilasec_gru"].$_SESSION["sSilamod_mat"];
					$vDestino .= "_".$_SESSION['sUsercod_usu'].".".$vType;
					
					copy($_FILES['rArchivo']['tmp_name'], $vDestino);
					$_SESSION['sSilaupload'] = TRUE;
				}
			}
		}
		$_SESSION["sSilacod_car"] = "";
		$_SESSION["sSilapln_est"] = "";
		$_SESSION["sSilacod_cur"] = "";
		$_SESSION["sSilasec_gru"] = "";
		$_SESSION["sSilamod_mat"] = "";
		$_SESSION["sSilasem_anu"] = "";
		$_SESSION["sSilacaiu"] = "";
	}
	else
	{
		$_SESSION['sIni'] = "";
		header("Location:../index.php");
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/frame.css">
<link rel="stylesheet" href="../css/framelogin.css">
<link rel="stylesheet" href="../css/style.css">
<title>Un@p.Net&reg; - Sistema Acad&eacute;mico via Web - UNA - Puno</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../js/ggw3.js"></script>
<script language="JavaScript" src="../js/function.js"></script>
<script language="JavaScript" src="../js/teacher.js"></script>
<script language="JavaScript">
	function enfocar()
	{
		maximizar();
	}

</script>

</head>

<body onLoad="enfocar();">
	<center>
	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>
			<? include "../include/header1.php"; ?>
			<? include "../include/menu1.php"; ?>
			
			<div id="dcontent">
				<table width="770" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tcontent">
				  <tr id="trcontent">
					<td valign="top" id="tdsubcontent"><div id="dsubcontent">
                      <center>
                        	<? include "sil_viewcursosdata.php"; ?>
                      </center>
				    </div></td>
				  </tr>
				</table>    
			</div>
			<? include "../include/foot1.php"; ?>	
		</td>
	  </tr>
	</table>
	</center>
</body>
</html>