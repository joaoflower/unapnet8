<?php
	session_start();
	include "include/funcget.php";
	include "include/funcsql.php";	

	$_SESSION['sUserlogin'] = $_POST['rLogin'];
	
	if(!(empty($_SESSION['sUserlogin']) or empty($_POST['rPasswd'])))
	{
		$bUsuest = FALSE;
		$bUsudoc = FALSE;
		$bUsuidio = FALSE;
		
		$bPasswd = FALSE;
		$bEstudiante = FALSE;
		$bDocente = FALSE;

		$vQuery = "Select us.login, us.passwd, us.num_mat, es.paterno, es.materno, es.nombres, ";
		$vQuery .= "us.cod_car, ca.car_des, es.num_doc, us.recorda, us.oemail, es.con_est, es.ult_mat, es.ult_per ";
		$vQuery .= "from usuest us left join estudiante es on us.num_mat = es.num_mat and us.cod_car = es.cod_car ";	
		$vQuery .= "left join carrera ca on us.cod_car = ca.cod_car ";	
		$vQuery .= "where us.login = '{$_SESSION['sUserlogin']}' ";
		$cUser = fQuery($vQuery);
		if($aUser = mysql_fetch_array($cUser))
		{
			$bUsuest = TRUE;
			if($aUser['passwd'] === fgetpassword($_POST['rPasswd']) and $aUser['num_doc'] === $_POST['rNum_doc'])
				$bPasswd = TRUE;
			
			if($bPasswd)
			{					
				$_SESSION['sUsercod_usu'] = $aUser['num_mat'];
				$_SESSION['sUsertip_usu'] = 'student';				
				$_SESSION['sUserpaterno'] = $aUser['paterno'];
				$_SESSION['sUsermaterno'] = $aUser['materno'];
				$_SESSION['sUsernombres'] = $aUser['nombres'];
				$_SESSION['sUsercod_car'] = $aUser['cod_car'];
				$_SESSION['sUsercar_des'] = $aUser['car_des'];
				$_SESSION['sUsernum_doc'] = $aUser['num_doc'];
				$_SESSION['sUserrecorda'] = $aUser['recorda'];
				$_SESSION['sUseroemail'] = $aUser['oemail'];
				$_SESSION['sUsercon_est'] = $aUser['con_est'];
				$_SESSION['sUserult_mat'] = $aUser['ult_mat'];
				$_SESSION['sUserult_per'] = $aUser['ult_per'];
				$_SESSION['sUserip'] = $_SERVER['REMOTE_ADDR'];
			}
		}
		if($bUsuest == FALSE)
		{
			$vQuery = "Select us.login, us.passwd, us.cod_prf, es.paterno, es.materno, es.nombres, ";
			$vQuery .= "us.cod_car, ca.car_des, es.num_doc, us.recorda, us.oemail ";
			$vQuery .= "from usudoc us left join docente es on us.cod_prf = es.cod_prf ";	
			$vQuery .= "left join carrera ca on us.cod_car = ca.cod_car ";	
			$vQuery .= "where us.login = '{$_SESSION['sUserlogin']}' ";
			$cUser = fQuery($vQuery);
			if($aUser = mysql_fetch_array($cUser))
			{
				$bUsudoc = TRUE;
				if($aUser['passwd'] === fgetpassword($_POST['rPasswd']) and $aUser['num_doc'] === $_POST['rNum_doc'])
					$bPasswd = TRUE;
				
				if($bPasswd)
				{					
					$_SESSION['sUsercod_usu'] = $aUser['cod_prf'];
					$_SESSION['sUsertip_usu'] = 'teacher';				
					$_SESSION['sUserpaterno'] = $aUser['paterno'];
					$_SESSION['sUsermaterno'] = $aUser['materno'];
					$_SESSION['sUsernombres'] = $aUser['nombres'];
					$_SESSION['sUsercod_car'] = $aUser['cod_car'];
					$_SESSION['sUsercar_des'] = $aUser['car_des'];
					$_SESSION['sUsernum_doc'] = $aUser['num_doc'];
					$_SESSION['sUserrecorda'] = $aUser['recorda'];
					$_SESSION['sUseroemail'] = $aUser['oemail'];
					$_SESSION['sUserip'] = $_SERVER['REMOTE_ADDR'];
				}
			}
		}
		if($bUsuest == FALSE and $bUsudoc == FALSE)
		{
			$vQuery = "Select us.login, us.passwd, us.num_mat, es.paterno, es.materno, es.nombres, ";
			$vQuery .= "us.cod_car, ca.car_des, es.num_doc, us.recorda, us.oemail ";
			$vQuery .= "from unapnet.usuidio us left join dbcidiomas.estudiantes es on us.num_mat = es.cod_unap ";
			$vQuery .= "left join carrera ca on us.cod_car = ca.cod_car ";	
			$vQuery .= "where us.login = '{$_SESSION['sUserlogin']}' ";
			
			$cUser = fQuery($vQuery);
			if($aUser = mysql_fetch_array($cUser))
			{
				$bUsuidio = TRUE;
				if($aUser['passwd'] === fgetpassword($_POST['rPasswd']) and $aUser['num_doc'] === $_POST['rNum_doc'])
					$bPasswd = TRUE;
				
				if($bPasswd)
				{					
					$_SESSION['sUsercod_usu'] = $aUser['num_mat'];
					$_SESSION['sUsertip_usu'] = 'student';				
					$_SESSION['sUserpaterno'] = $aUser['paterno'];
					$_SESSION['sUsermaterno'] = $aUser['materno'];
					$_SESSION['sUsernombres'] = $aUser['nombres'];
					$_SESSION['sUsercod_car'] = $aUser['cod_car'];
					$_SESSION['sUsercar_des'] = $aUser['car_des'];
					$_SESSION['sUsernum_doc'] = $aUser['num_doc'];
					$_SESSION['sUserrecorda'] = $aUser['recorda'];
					$_SESSION['sUseroemail'] = $aUser['oemail'];
					$_SESSION['sUserip'] = $_SERVER['REMOTE_ADDR'];
				}
			}
		}
		
		//------------------------------------------
		if($bPasswd)
		{
		
			// ---------
			$_SESSION['sFrameano_aca'] = '2009';
			$_SESSION['sFrameper_aca'] = '01';
			
			$_SESSION['sFrameano_acai'] = '2010';
			$_SESSION['sFramecod_mesi'] = '01';
			
			if($bUsuest == TRUE)
			{
				$_SESSION['sFrameano_aca'] = '2009';
				$_SESSION['sFrameper_aca'] = '01';
				
				$_SESSION['sFrameano_acai'] = '2010';
				$_SESSION['sFramecod_mesi'] = '02';
			
				$_SESSION['sSafetylogin'] = '*E64C43A32CDCA595E9F49426B88646EEAA618E0D';
				header("Location:student/");
			}
			elseif($bUsudoc == TRUE)
			{
				$_SESSION['sSilaano_aca'] = '2009';
				$_SESSION['sSilaper_aca'] = '01';
				
				$_SESSION['sFrameano_acai'] = '2010';
				$_SESSION['sFramecod_mesi'] = '01';
				
				$_SESSION['sSafetylogin'] = '*4D3135D9A09A85FE3E45C245957210F8818F880A';
				header("Location:teacher/");
			}			
			elseif($bUsuidio == TRUE)
			{
				$_SESSION['sFrameano_acai'] = '2010';
				$_SESSION['sFramecod_mesi'] = '02';
				
				$_SESSION['sSafetylogin'] = '*E64C43A32CDCA595E9F49426B88646EEAA618E0D';
				header("Location:student/");
			}			
			else
			{
				$_SESSION["sLoginError"] = TRUE;
				$_SESSION["sLoginMessage"] = 'ERROR, El Usuario o la Contraseña es Incorrecta !!!';
				header("Location:index.php");
			}		
		}
		else
		{
			$_SESSION["sLoginError"] = TRUE;
			$_SESSION["sLoginMessage"] = 'ERROR, El Usuario o la Contraseña es Incorrecta !!!';
			header("Location:index.php");				
		}		
	}
	else
	{
		$_SESSION['sIni'] = "";
		header("Location:index.php");		
	}
?>
