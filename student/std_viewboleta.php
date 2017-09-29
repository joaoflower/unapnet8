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
		$tBoleta = "boleta".$_SESSION['sFrameano_aca'];
		$_SESSION['sEstusql_bol'] = "";
		$vTot_pag = 0;
		
		if(!empty($_POST['rSecuencia1']) and !empty($_POST['rFch_pag1']) and !empty($_POST['rImp_pag1']))
		{
			$bDatos = TRUE;
		}		
	}
	else
	{
		header("Location:../index.php");
	}
	
	if($bDatos == TRUE)
	{	
?>
		<span class="wordi"><strong>VERIFIQUE QUE LOS DATOS INGRESADOS SEAN LOS CORRECTOS ...!<br />
		EN EL CASO DE QUE LOS DATOS NO SEAN REALES, REINICIE 
		EL PROCESO; <br />
		EN EL CASO DE NO REINICIAR SE ANULARA LA MATRICULA <br />
		Y SE SANCIONARA AL ESTUDIANTE.<br />
		HAGA CLICK EN CONTINUAR PARA PROCEGUIR CON LA MATRICULA. </strong></span>
		<table border="0" cellpadding="0" cellspacing="0" class="tventana">
          <tr>
            <td><img src="../images/ven_topleft.jpg" width="16" height="25" border="0" alt="" /></td>
            <th background="../images/ven_topcenter.jpg">Boleta(s) de pago del Banco de la Naci&oacute;n </th>
            <td><img src="../images/ven_topright.jpg" width="16" height="25" border="0" alt="" /></td>
          </tr>
          <tr>
            <td background="../images/ven_mediumleft.jpg"></td>
            <td align="center"><div id="dsilabo">
              <table border="0" cellpadding="0" cellspacing="0" bordercolor="#FF0000" class="tlistdata">
                <tr>
                  <th width="10" class="tdultimo">&nbsp;</th>
                  <th width="80" class="tdultimo">Secuencia</th>
                  <th width="115" class="tdultimo">Fecha (dd/mm/aaaa) </th>
                  <th width="70" class="tdultimo">Importe</th>
                </tr>
                <?
			$_SESSION['sEstusql_bol'] = "insert into $tBoleta (ano_aca, per_aca, num_mat, cod_car, secuencia, fch_pag, imp_pag, est_bol, fch_bol) values ";
		  	for($ii = 1; $ii <= $_SESSION['sEstucan_bol']; $ii++)
			{
				$vFecha = fFechamy($_POST['rFch_pag'.$ii]);
				if($ii > 1)
					$_SESSION['sEstusql_bol'] .= ", ";
				$_SESSION['sEstusql_bol'] .= "('{$_SESSION['sFrameano_aca']}', '{$_SESSION['sFrameper_aca']}', '{$_SESSION['sUsercod_usu']}', ";
				$_SESSION['sEstusql_bol'] .= "'{$_SESSION['sUsercod_car']}', '{$_POST['rSecuencia'.$ii]}', '$vFecha', ";
				$_SESSION['sEstusql_bol'] .= "'{$_POST['rImp_pag'.$ii]}', '1', now()) ";
				$vTot_pag += $_POST['rImp_pag'.$ii];
		  ?>
                <tr>
                  <td class="tdultimo"><?=$ii?></td>
                  <td class="tdultimo"><?=$_POST['rSecuencia'.$ii]?></td>
                  <td class="tdultimo"><?=$_POST['rFch_pag'.$ii]?></td>
                  <td class="tdultimo"><?=$_POST['rImp_pag'.$ii]?></td>
                </tr>                
                <?
		  	}
		  ?>
		  		<tr>
                  <th colspan="3" class="tdultimo">TOTAL PAGADO EN EL BANCO: </th>
                  <th class="tdultimo"><?=$vTot_pag?></th>
                </tr>
              </table>
              <div id="dboleta"></div>
            </div></td>
            <td background="../images/ven_mediumright.jpg"></td>
          </tr>
          <tr>
            <td><img src="../images/ven_bottomleft.jpg" width="16" height="16" border="0" alt="" /></td>
            <td background="../images/ven_bottomcenter.jpg"></td>
            <td><img src="../images/ven_bottomright.jpg" width="16" height="16" border="0" alt="" /></td>
          </tr>
        </table>
		<table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div class="dboton"><a href="" onclick = "std_saveboleta('ok'); return false;" class="icontinue" title="Continuar">Continuar</a></div></td>
          </tr>
        </table>
		<?	
	}	
?>
		