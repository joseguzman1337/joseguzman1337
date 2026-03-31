<table class="table table-bordered" style="width: 80%">
    <tr id="trtituloNaranjaInst">
      <td style="border-top-color:#000000" align="center"><br> 
 <p><label style="color: #FFFFFF"><?php echo $notas;?></label></p>
<label id="labelresaltado">
<?php
if($this->observacionordenpago != "")
{
?>
          <h3><strong>Observación : </strong><?php echo $this->observacionordenpago;?></h3>
<?php
}
?>
</label>
        </div></td>
    </tr>
</table>
