<?php
header('Content-Type: text/html; charset=ISO-8859-1');
require_once 'membro.php';
require_once 'sessao.php';
require_once 'crudMovimento.php';
require_once '../login/autenticador.php';

$mant = ManterMovimento::instanciar();

$aut = Autenticador::instanciar();

if ($aut->esta_logado()) {
	$usuario = $aut->pegar_usuario();
	if ($usuario ['id_perfil']!=1) {
		$pdoiv = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
		$sqliv = "select igj.*
		from igreja igj where id_igreja='{$usuario ['id_igreja']}'";
		$stmiv = $pdoiv->query($sqliv);
		$dadosiv = $stmiv->fetch(PDO::FETCH_ASSOC);
		$igjVinculada="<input type='text' class='form-control' style='display:none' id='igreja' name='igreja' value='".$dadosiv['ID_IGREJA']."'>
						<input type='text' class='form-control' id='nmigreja' name='nmigreja' value='".$dadosiv['NM_IGREJA']."' readonly='readonly'>";
	}else{
		$pdoiv = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
		$sqliv = "select igj.*
				from igreja igj";
		$stmiv = $pdoiv->query($sqliv);
		
		$igjVinculada="<select class='form-control' id='igreja' name='igreja' required>
				   				<option selected ></option>";
				   				
				   			
		while($dadosiv = $stmiv->fetch(PDO::FETCH_ASSOC)){
		
			$igjVinculada.="<option value='".$dadosiv['ID_IGREJA']."'>".$dadosiv['NM_IGREJA']."";
		}
		$igjVinculada.="</select>";
	}
}else {
	$aut->expulsar();
}
date_default_timezone_set('America/Sao_Paulo');
$dataatual = date("d/m/Y");
$diaatual = date("d");
/* $mesatual = date("m");

//$igj=$_SESSION['igreja']

function verifData() */


?>
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- CSS Complementar -->
    <style type="text/css" media="all">
    b{color:#B22222}
    label{font-size:15px}
    </style>
    
    <!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bootstrap/css/style.css" rel="stylesheet">
	
	   	<title>Gest�o Crista</title>
    </head>
    <body>
    
    
    <?php include '../login/topo.php';
    
    $regiao=null;
    $cidade=null;
    
    if (isset($_GET['res'])){
	    $teste=$_GET['res'];
	    if ($teste=="erro"){
	    	//var_export("teste1");
	    	echo "	<br/><div class='alert alert-warning'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>�</span></button>
	  					<strong>O cadastro n�o foi efetuado!</strong> Favor tentar novamente.
						<alert>
					</div>";
	    }
    }
	
    
    
  ?>
<br><br>
<?php 
	//var_dump($igjLotado);var_dump("prf".$prfUsuario);
?>
    <div class="container col-sm-offset-3">

      <div class="starter-template">
        <h2>Cadastro de Movimento</h2>
        <!-- <p>  -->
        	<form  name="cadMovimento" action="../Movimento/controle.php" method="post" target="_self">
        		<div class="lead">
        			<div class="col-sm-2">
    					<label for="membro" class="control-label">Data atual:</label>
    				</div>
    				<div class="col-sm-2">
      					<input type="text" class="form-control data" id="dtatual" name="dtatual"  value='<?php echo $dataatual;?>' readonly='readonly'>
      				</div>
    				<div class="col-sm-2">
    					<label for="membro" class="control-label">Data do Movimento:<b>*</b></label>
    				</div>
    				<div class="col-sm-2">
      					<input type="text" class="form-control data" id="dtmovimento" name="dtmovimento" onBlur="verifData()" >
      				</div>
      			</div>
      			<br>
      			<br>
      			<div class="lead">
      				<div class='col-sm-2'>
    					<label for='igreja' class='control-label'>Igreja:</label>
    				</div>
    				<div class="col-sm-4">
      					<?php 	
					   		echo $igjVinculada;
					   	?>
					</div> 
    			</div>
    			<br>
    			<div class="lead">
    				<div class="col-sm-2">
    					<label for='tpMovimento' class='control-label'>Tipo de Movimento:<b>*</b></label>
    				</div>
 			   		<div class='col-sm-4'>
			   			<select class='form-control' id='tpmovimento' name='tpmovimento'>
			   				<option selected ></option>
			   				<?php
			   					//Recupera as Regi�es cadastradas
				   				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				   				$sql = "select * from tipo_movimento";
				   				$stm = $pdo->query($sql);
				   				//Monta a lista de regi�es conforme recuperado do banco.
				   				while($dados = $stm->fetch(PDO::FETCH_ASSOC)){
				   					echo "<option value='".$dados['id_tipo_movimento']."'>".$dados['ds_tipo_movimento']."</option>";
				   				}
				   			?>
			   			</select>	   	
					</div>
 				</div>
 				<br>
 				<div class="lead">
        			<div class="col-sm-2">
    					<label for="movimento" class="control-label">Valor:</label>
    				</div>
    				<div class="col-sm-2">
      					<input type="text" class="form-control vlr" id="valor" name="valor" >
      				</div>
    			</div>
 			<br/>
 			<br/>
 			<div class='lead'>
			   		<div class='col-sm-offset-6 col-sm-7'>
			   			<button type='submit' class='btn btn-primary col-sm-offset-1 col-sm-2' id='ac' name='ac' value='sv' >Salvar</button>	   	
					</div>
				</div>
 			
 			
        	</form>
        <!-- </p> -->
      </div>

    </div><!-- /.container -->
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Vers�o 3.3.6 -->
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Vers�o 1.11.1 -->
	<script src='../bootstrap/jquery/maskmoney_2.0.1/jquery.maskMoney.js'></script><!-- maskmoney_2.0.1-->
	<script src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Vers�o 1.4.1 -->
	<script type="text/javascript"> 

	 	$(document).ready(function(){
			$("input.data").mask("99/99/9999");
	       	$('#valor').maskMoney();
	       	$('#ac').prop("disabled", true);
	    });
	 	
		function verifData(){
			//recupera os valores informados
			var dtatual = document.cadMovimento.dtatual.value;
			var dtinform = document.cadMovimento.dtmovimento.value;
			var atual = dtatual.split("/");
			var informada = dtinform.split("/");

			
			//--------------------------------------------------------------------------------------------------------------------//
			// N�o permite informar movimenta��es do m�s anterior ap�s o dia 15 do m�s corrente ou movimenta��es em datas futuras //
			//--------------------------------------------------------------------------------------------------------------------//
			//if (dtinform<>''){
				if ((atual[1]>informada[1])||((atual[1]<informada[1])&&(informada[2]<atual[2])&&(atual[1]=='01'){
					if (atual[0]>=15){
						//Desabilita a op��o Salvar e exibe mensagem
						$('#ac').prop("disabled", true);
						alert("N�o podem ser realizados cadastros de movimentos referentes ao m�s anterior ap�s o dia 15.");
					}else{
						//Habilita a op��o Salvar
						$('#ac').prop("disabled", false);
					}			
				}else{
					if ((((informada[0]>atual[0])&&(informada[1]==atual[1]))||(informada[1]>atual[1]))&& informada[0]>=1){
						//Desabilita a op��o Salvar e exibe mensagem
						$('#ac').prop("disabled", true);
						alert("N�o � permitido informar movimenta��es futuras.");
					}else{
						//Habilita a op��o Salvar
						$('#ac').prop("disabled", false);
					}
				}
			//}
		}	
			
   </script>	
    
    
    </body>
    
</html>
