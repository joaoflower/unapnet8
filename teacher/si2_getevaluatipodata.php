
<?
	if(fsafetylogin())
	{
?>
		
        <table border="0" cellpadding="0" cellspacing="1" bordercolor="#FF0000" class="tviewdata">
          <tr>
            <td width="70">Tipo : </td>
            <th width="180"><select name="rTip_eva" id="rTip_eva">
              <?=fviewtipoevalua($aResult['tip_eva'])?>
                        </select></th>
            <td width="70">Capacidad:</td>
            <th><select name="rUni_pro" id="rUni_pro">
				<?
				for($ii = 1; $ii <= $_SESSION["sSilacan_cap2"]; $ii++)
				{
				?>
					<option value="<?=$ii?>" <?=($ii == $aResult['uni_pro']?"Selected":"")?>><?=$ii?></option>
				<?
				}
				?>	
                    </select></th>
          </tr>
          
          <tr>
            <td>Descripci&oacute;n : </td>
            <th colspan="3"><textarea name="rDes_eva" cols="60" rows="2" id="rDes_eva"  onblur="fupper(this);"><?=$aResult['des_eva']?></textarea></th>
          </tr>
          <tr>
            <td> Fecha : </td>
            <th width="180"><input name="rFch_eva" type="text" class="" id="rFch_eva" value="<?=fFechad($aResult['fch_eva'])?>" size="10" maxlength="10" onblur="fupper(this);"/><img src="../images/browse.png" width="16" height="16" onclick="return showCalendar('rFch_eva', '%d/%m/%Y');" /> <span class="wordi">(dd/mm/aaaa)</span></th>
            <td width="70">Porcentaje : </td>
            <th><input name="rPor_eva" type="text" class="" id="rPor_eva" value="<?=$aResult['por_eva']?>" size="5" maxlength="5" onblur="fupper(this);"/></th>
          </tr>
        </table>
		
		<table border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><div class="dboton"><a href="" onclick = "si2_savetipoeva(document.fData); return false;" class="isave" title="Guardar">Guardar</a></div>
					</td>
			  </tr>
			</table>
            
<?
	}
?>