<?php
header('Content-Type: text/html; charset=ISO-8859-1');
//require_once 'movimento.php';
require_once 'sessao.php';
include_once 'crudRelatFin.php';
require_once '../login/autenticador.php';

$mant = ManterRelatFin::instanciar();

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
}
else {
	$aut->expulsar();
}
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
    .form-control{height:30px;}
    </style>
    
    <!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bootstrap/css/style.css" rel="stylesheet">
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Vers�o 3.3.6 -->
	<script src='../bootstrap/js/jquery.js'></script><!-- Vers�o 1.11.1 -->
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Vers�o 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Vers�o 1.4.1 -->
        	<title>Gest�o Crista</title>
    </head>
    <body>
    
     <?php 	include '../login/topo.php';
     	$anoatual = date("Y");
		if (isset($_REQUEST['resultado'])){
    		$teste=$_REQUEST['resultado'];
    		if ($teste=="1"){
    		//var_export("teste1");
    			echo "	<br/><div class='alert alert-success'>
  							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>�</span></button>
							<strong>Registro salvo com sucesso!</strong>
							<alert>
						</div>";
    		}
	    	if ($teste=="2"){
	    			//var_export("teste1");
	    			echo "	<br/><div class='alert alert-success'>
	  							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>�</span></button>
								<strong>Registro exclu�do com sucesso!</strong>
								<alert>
							</div>";
	    	}
		    if ($teste=="3"){
		    			//var_export("teste1");
		    			echo "	<br/><div class='alert alert-success'>
		  							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>�</span></button>
									<strong>Registro alterado com sucesso!</strong>
									<alert>
								</div>";
		    }
		}
    ?>
<br/>
    <div class="container col-sm-offset-3">
      <div class="starter-template">
        <h2>Relat�rio de Movimento Financeiro</h2>
        <!-- <p> -->
        	<form action="../RelatFinanc/resultado.php" method="get" target="_self">
        		<div class="lead">
	   	 			<div class="col-sm-2">
	   	 				<label for="membro" class="control-label">Igreja:</label>
	   	 			</div>
    				<div class="col-sm-4">
				   		<?php 	
					   		echo $igjVinculada;
					   		
					   	?>
				   	</div>
				</div>
				<br/>
				<br/>
        		<!-- <div class="lead">
    				<div class="col-sm-2">
    					<label for='tpMovimento' class='control-label'>Tipo de Relat�rio:<b>*</b></label>
    				</div>
 			   		<div class='col-sm-4'>
			   			<select class='form-control' id='tpmovimento' name='tpmovimento'>
			   				<option selected ></option> -->
			   				<!--<//?php 
			   					//Recupera as Regi�es cadastradas
				   				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				   				$sql = "select * from tipo_movimento";
				   				$stm = $pdo->query($sql);
				   				//Monta a lista de regi�es conforme recuperado do banco.
				   				while($dados = $stm->fetch(PDO::FETCH_ASSOC)){
				   					echo "<option value='".$dados['id_tipo_movimento']."'>".$dados['ds_tipo_movimento']."</option>";
				   				}
				   			?> -->
			   			<!-- </select>	   	
					</div>
 				</div>
 				<br> -->
        		<div class="lead">
        			<div class="col-sm-2">
    					<label for="movimento" class="control-label">M�s:</label>
    				</div>
    				<div class="col-sm-2">
      					<select class='form-control' id='mesRelat' name='mesRelat'>
			   				<option selected ></option>
			   				<option value=01 >Janeiro</option>
			   				<option value=02 >Fevereiro</option>
			   				<option value=03 >Mar�o</option>
			   				<option value=04 >Abril</option>
			   				<option value=05 >Maio</option>
			   				<option value=06 >Junho</option>
			   				<option value=07 >Julho</option>
			   				<option value=08 >Agosto</option>
			   				<option value=09 >Setembro</option>
			   				<option value=10>Outubro</option>
			   				<option value=11>Novembro</option>
			   				<option value=12>Dezembro</option>
			   			</select>
    				</div>
    			</div>
    			<br/>
    			<div class="lead">
    				<div class="col-sm-2">
    					<label for="movimento" class="control-label">Ano:</label>
    				</div>
    				<div class="col-sm-2">
      					<select class='form-control' id='anoRelat' name='anoRelat'>
			   				<option value='<?php echo $anoatual;?>' selected ><?php echo $anoatual;?></option>
			   				<?php 
		   						$ref=2010;
		   						while($ref < $anoatual ){
		   							$anoatual--;
		   							echo "<option value='".$anoatual."'>".$anoatual."</option>";
		   							
		   						}	
			   				?>
			   			</select>
      					
    				</div>
 				</div>
 				<br/>
				<br/>
				<div class="lead">
			   		<div class="col-sm-offset-5 col-sm-4">
			   			<!-- <button type="button" class="btn btn-lg btn-default" formaction="../Movimento/cadastro.php" name="resultado" >Cadastrar</button> -->
			   			<button type="submit" class="btn btn-lg col-sm-offset-1 btn-primary" id="acao">Gerar Relat�rio</button>	   	
					</div>
				</div>
        	</form>
        	<br/>
        	<br/>
        	<br/>
        </div>	

    </div><!-- /.container -->

	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../Bootstrap/js/bootstrap.min.js"></script>
    <script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Vers�o 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Vers�o 1.4.1 -->
    <script type="text/javascript">
    $(document).ready(function(){
			$("input.data").mask("99/99/9999");
	       		
		});
    </script>   
    </body>
</html>
<?php 
			   						$mesatual = date("m");
			   						$anoatual = date("Y");
			   						
			   					?>
