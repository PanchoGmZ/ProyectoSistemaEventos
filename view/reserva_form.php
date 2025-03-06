<?php

require_once "seguranca.php";
require_once '../controller/reservaController.php';
$reserva = new ReservaController();

// salvar dados
$reserva->salvarController();

if(isset($_GET['id']) && is_numeric($_GET['id']))
{
	
	$reg_id = $_GET['id'];
	$sala_id = $_GET['sala_id'];
	$periodo_id = $_GET['periodo_id'];
	
	if( $reg_id  > 0  )
	{
		$row = $reserva->abrirController($reg_id );
		extract($row[0]);
	}
	else
	{
		$status = 1; // reservado	
	
		// sugerir data do calendario atual
		if(isset($_GET['data']))
			$hoje =  date_create_from_format('d/m/Y',$_GET['data']);
		else
			$hoje = new DateTime();
	
		$dia = $hoje->format("d/m/Y");
		$professor_desc ='';
		$disciplina_desc = '';
		$observacao = '';
		$periodo= '';
		$sala = '';

	}

//1 reservada, 2 confirmada, 3 cancelada 
$a_options_status = array("Reservado", "Confirmado","Cancelado");
$val = 1;
$options_status = '';

foreach($a_options_status as $opt_stat)
{
	if($status == $val)$selected = ' selected="selected" '; else $selected= '';
	$options_status .= "<option value=\"$val\" $selected>$opt_stat</option>";
	$val++;
}


?>
<form name="frm_reserva" id="frm_reserva" onsubmit="return salvaFormularioReserva()">

<h3> Reserva</h3>

<input type="hidden" name="id" value="<?= $reg_id ?>" />
<input type="hidden" name="sala" value="<?= $sala ?>" />
<input type="hidden" name="periodo" value="<?= $periodo ?>" />
<input type="hidden" name="sala_id" value="<?= $sala_id ?>" />
<input type="hidden" name="periodo_id" value="<?= $periodo_id ?>" />


<input type="text" placeholder="dia" name="dia" id="dia" value="<?= $dia ?>"><BR>

<input type="text" placeholder="Nombre de evento" name="professor" id="professor" value="<?= $professor_desc ?>" ><BR>

<input type="text" placeholder="Tipo de Evento" name="disciplina" id="disciplina" value="<?= $disciplina_desc ?>"><BR>

<input type="text" placeholder="Observaciones" name="observacao" id="observacao" value="<?= $observacao ?>" ><BR>

<select name="status" id="status" ><?= $options_status; ?></select><BR>

<h3> Repetir semanalmente hasta que</h3>
<input type="text" placeholder="data final" name="data_final" id="data_final" value=""><BR>

<input type="button" name="Fechar" value="Cerrar" onClick="fecharForm()" class="btn1">
<input type="button" name="Excluir" value="Cancelar" class="btn1" onclick="excluirFormularioReserva(<?= $reg_id ?>)">
<input type="submit" name="Salvar" value="Guardar" class="btn2">
</form>
<script>
    // Al hacer clic en "Guardar", el formulario será enviado y redirigido a pagosform.php
    document.getElementById("frm_reserva").onsubmit = function() {
        this.action = "pagosform.php"; // Redirige a pagosform.php
        return true; // No evita el envío
    }
</script>
<?php

}

?>