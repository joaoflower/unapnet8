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
		if(!empty($_POST['rOldpasswd']) and !empty($_POST['rNewpasswd']) and !empty($_POST['rReppasswd']) and 
			$_POST['rNewpasswd'] === $_POST['rReppasswd'])
		{
			if(strlen($_POST['rNewpasswd']) >= 4)
			{
				$vQuery = "select passwd from usudoc where cod_prf = '{$_SESSION['sUsercod_usu']}' and ";
				$vQuery .= "login = '{$_SESSION['sUserlogin']}' ";
				$cResult = fQuery($vQuery);
				if($aResult = mysql_fetch_array($cResult))
				{
					if($aResult['passwd'] === fgetpassword($_POST['rOldpasswd']))
					{
						$vQuery = "update usudoc set passwd = password('{$_POST['rNewpasswd']}') ";
						$vQuery .= "where cod_prf = '{$_SESSION['sUsercod_usu']}' and ";
						$vQuery .= "login = '{$_SESSION['sUserlogin']}' ";
						$cUser = fQuery($vQuery);
						if($cUser)
							$bDatos = TRUE;
					}
					else
						$_SESSION['sPswMessage'] = TRUE;
				}
				else
					$_SESSION['sPswMessage'] = TRUE;
			}
			else
				$_SESSION['sPswMessage'] = TRUE;
		}	
		else
			$_SESSION['sPswMessage'] = TRUE;
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
?>
	<center>
	<span class="wordi">LA CONTRASE&Ntilde;A SE CAMBIO CORRECTAMENTE ...! </span>
	</center>
<?			
	}
	else
	{
		include "psw_getpasswddata.php";	
	}
?>
	