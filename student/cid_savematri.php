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
		$bDatos = FALSE;
		$vNum_mat = "";
		if(!empty($_POST['rNum_rec']) and !empty($_POST['rImp_pag']) and !empty($_POST['rHra_sec']) and !empty($_POST['rFch_pag']))
		{
			/*$vQuery = "SELECT num_mat, secuencia, fch_pag, imp_pag ";
			$vQuery .= "FROM banco2009 where ano_aca = '{$_SESSION['sFrameano_acai']}' and cod_mes = '{$_SESSION['sFramecod_mesi']}' and ";
			$vQuery .= "num_mat = '{$_SESSION['sUsercod_usu']}' ";
			
			$cResult = fQueryi($vQuery);
			if($aResult = mysql_fetch_array($cResult))
			{*/
				if( $_POST['rImp_pag'] == $_SESSION['sCidimp_pag'] )
				{
					//---------- Si los datos ingresados son correctos ----------------------------
					$vQuery = "select max(num_mat) as num_mat from matriculas ";
					$cResult = fQueryi($vQuery);
					if($aResult = mysql_fetch_array($cResult))
					{
						$vNum_mat = "00".($aResult['num_mat'] + 1);
					}
					
					$vCorrel = substr($_SESSION['sFrameano'], 2, 2).$_SESSION['sFramemes'].substr($_SESSION['sUsercod_usu'], 3, 4);
					
					$vQuery = "insert into matriculas (num_mat, anio, cod_mes, num_rec, fch_mat, cod_usu, cod_con, imp_pag, cod_gpo, tip_pag, ";
					$vQuery .= "escrito, oral, flg_mat, fch_rec, fch_hra, codigo) values ('$vNum_mat', '{$_SESSION['sCidano']}', ";
					$vQuery .= "'{$_SESSION['sCidmes']}', '{$_POST['rNum_rec']}', date(now()), '9999', '1', ";
					$vQuery .= "'{$_POST['rImp_pag']}', ";
					$vQuery .= "'{$_POST['rHra_sec']}', '1', '', '', '0', date(now()), now(), '{$_SESSION['sCidnum_mat']}') ";
					
					$cMatri = fInupdei($vQuery);
					
					$vQuery = "update gruposhab set num_alu = num_alu + 1 where cod_gpo = '{$_POST['rHra_sec']}' and ";
					$vQuery .= "anio = '{$_SESSION['sCidano']}' and cod_mes = '{$_SESSION['sCidmes']}'; ";
					$cMatri = fInupdei($vQuery);
					
			
					$_SESSION["sCidhra_ini"] = "";
					$_SESSION["sCidhra_fin"] = "";
					$_SESSION["sCidcod_sec"] = "";
					$_SESSION["sCidcod_cur"] = "";
					$_SESSION["sCidcod_con"] = "";
					$_SESSION["sCidtip_pag"] = "";	
					
					$vQuery = "select mat.*, esp.des_esp, esp.nom_esp, concat(doc.nombres, ' ', doc.paterno, ' ', doc.materno) as nom_doc, ";
					$vQuery .= "cur.des_cur, cur.nivel, sec.des_sec, hr1.des_hra as dhra_ini, hr2.des_hra as dhra_fin ";
					$vQuery .= "from (Select ma.*, gp.cod_esp, gp.cod_aul, gp.cod_doc, gp.cod_cur, gp.cod_sec, gp. hra_ini, gp.hra_fin, ";
					$vQuery .= "me.des_mes, co.des_con, pg.des_pag ";
					$vQuery .= "from (select ma.num_mat, ma.anio, ma.cod_mes, ma.num_rec, ma.fch_mat, ma.cod_usu, ma.cod_con, ";
					$vQuery .= "ma.imp_pag, ma.cod_gpo, ma.tip_pag, ma.escrito, ma.oral, round((ma.escrito + ma.oral)/2) as final, ";
					$vQuery .= "ma.flg_mat, ma.fch_hra, ma.codigo ";
					$vQuery .= "from matriculas ma where ma.codigo = '{$_SESSION['sCidnum_mat']}' order by  ma.anio desc, ma.cod_mes desc ";
					$vQuery .= "limit 1) ma ";
					$vQuery .= "left join gruposhab gp on ma.cod_gpo = gp.cod_gpo  left join meses me on ma.cod_mes = me.cod_mes ";
					$vQuery .= "left join condicionest co on ma.cod_con = co.cod_con  left join tipopago pg on ma.tip_pag = pg.tip_pag) mat ";
					$vQuery .= "left join especialidades esp on mat.cod_esp = esp.cod_esp  left join docentes doc on mat.cod_doc = doc.cod_doc ";
					$vQuery .= "left join cursos cur on mat.cod_cur = cur.cod_cur  left join seccion sec on mat.cod_sec = sec.cod_sec ";
					$vQuery .= "left join horas hr1 on mat.hra_ini = hr1.cod_hra  left join horas hr2 on mat.hra_fin = hr2.cod_hra ";
					
					$cResult = fQueryi($vQuery);
					if($aResult = mysql_fetch_array($cResult))
					{
						$bDatos = TRUE;
					}				
				}
			//}
		
		}

	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{
		
?>
<center>
	<table border="0" cellpadding="0" cellspacing="0" class="tventana">
	  <tr>
		<td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
		<th background="../images/ven_topcenter.jpg">Matricula Realizada </th>
		<td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
	  </tr>
	  <tr>
		<td background="../images/ven_mediumleft.jpg"></td>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
			  <tr>
				<td width="75">C&oacute;digo :</td>
				<th width="150"><?=$aResult['codigo']?></th>
				<td width="75">Condici&oacute;n : </td>
				<th width="150"><?=$aResult['des_tip']?></th>
			  </tr>
			  <tr>
				<td>Nombres :</td>
				<th colspan="3"><?=$_SESSION['sUserpaterno']?> <?=$_SESSION['sUsermaterno']?>, <?=$_SESSION['sUsernombres']?></th>
			  </tr>
			  
			  <tr>
			    <td>A&ntilde;o - Mes  :</td>
			    <th><?=$aResult['anio']?> - <?=$aResult['des_mes']?></th>
			    <td>Especialidad : </td>
			    <th><?=$aResult['des_esp']?></th>
		      </tr>
			  <tr>
			    <td>Curso : </td>
			    <th><?=$aResult['des_cur']?></th>
			    <td>Hora - Grupo  :</td>
			    <th><?=$aResult['dhra_ini']?> - <?=$aResult['dhra_fin']?> - [ <?=$aResult['des_sec']?> ]</th>
		      </tr>
			  <tr>
			    <td>Condici&oacute;n :</td>
			    <th><?=$aResult['des_con']?></th>
		        <td>Tipo pago :</td>
		        <th><?=$aResult['des_pag']?></th>
			  </tr>
			  <tr>
			    <td>Recibo - Monto :</td>
			    <th><?=$aResult['num_rec']?> - [ S/. <?=$aResult['imp_pag']?> ]</th>
			    <td>Nota : </td>
			    <th <?=ftdstylenota(1, 2, $aResult['final'])?>><?=$aResult['final']?></th>
		      </tr>
			</table>
		
		</td>
		<td background="../images/ven_mediumright.jpg"></td>
	  </tr>
	  <tr>
		<td><img src="../images/ven_bottomleft.jpg" width="16" height="16" border="0" alt="" /></td>
		<td background="../images/ven_bottomcenter.jpg"></td>
		<td><img src="../images/ven_bottomright.jpg" width="16" height="16" border="0" alt="" /></td>
	  </tr>
	</table>
</center>			

<?
	}
	else
	{
?>
	<center>
	<span class="wordi">LOS DATOS INGRESADOS NO SON V&Aacute;LIDOS, INICIE DE NUEVO LA MATR&Iacute;CULA </span>
	</center>
<?
	}
?>

