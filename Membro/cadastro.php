<?php
header('Content-Type: text/html; charset=ISO-8859-1');
require_once 'membro.php';
require_once 'sessao.php';
require_once 'crudMembro.php';
require_once '../login/autenticador.php';

$mant = ManterMembro::instanciar();

$aut = Autenticador::instanciar();

if ($aut->esta_logado()) {
	$usuario = $aut->pegar_usuario();
	
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
    </style>
    
    <!-- Bootstrap -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bootstrap/css/style.css" rel="stylesheet">
	
	   	<title>Gestão Crista</title>
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
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
	  					<strong>O cadastro não foi efetuado!</strong> Favor tentar novamente.
						<alert>
					</div>";
	    }
    }
    
  ?>

    <div class="container col-sm-offset-2">

      <div class="starter-template">
        <h2>Ficha do Membro</h2>
        <!-- <p> -->
        	<form action="../Membro/controle.php" method="post" target="_self" name="cadMembro">
        		<div class="lead">
        			<div class="col-sm-2">
    					<label for="membro" class="control-label">Nº de ROL:</label>
    				</div>
    				<div class="col-sm-1">
      					<input type="text" class="form-control " id="nrrol" name="nrrol" readonly='readonly'>
    				</div>
    				<div class="col-sm-2">
    					<label for="membro" class="control-label">Nº do local:<b>*</b></label>
    				</div>
    				<div class="col-sm-1">
      					<input type="text" class="form-control" id="nrlocal" name="nrlocal" required>
    				</div>
    			</div>
    			<br>
    			<br>
    			<div class="lead">
    				<div class="col-sm-2">
    					<label for='igreja' class='control-label'>Igreja:<b>*</b></label>
    				</div>
 			   		<div class='col-sm-4'>
			   			<select class='form-control igreja' id='igreja' name='igreja' onchange='alimentarCampo();'>
			   				<option selected ></option>
			   				<?php
			   					//Recupera as Regiões cadastradas
				   				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				   				$sql = "select igj.*, reg.ds_regiao 
				   				from igreja igj left join regiao reg
								on igj.id_regiao=reg.id_regiao";
				   				$stm = $pdo->query($sql);
				   				//Monta a lista de regiões conforme recuperado do banco.
				   				while($dados = $stm->fetch(PDO::FETCH_ASSOC)){
				   					echo "<option value='".$dados['ID_IGREJA']."' title='".$dados['NM_CIDADE']."' id='".$dados['ds_regiao']."'>".$dados['NM_IGREJA']."";
				   				}
				   			?>
			   			</select>	   	
					</div>
 				</div>
 			<br/>
 			
 			<div class="lead">
 				<div class="col-sm-2">
 					<label for='igreja' class='control-label'>Região:</label>
    			</div>
    			<div class='col-sm-3'>
      				<input type='text' class='form-control' id='regiao' name='regiao' readonly='readonly'>
    			</div>
 				<div class="col-sm-2">
 					<label for='igreja' class='control-label'>Cidade:</label>
    			</div>
    			<div class='col-sm-2'>
      				<input type='text' class='form-control' id='cidade' name='cidade' readonly='readonly'>
    			</div>
			</div>
 			<br/>
 			<div class="lead">
    			<div class="col-sm-2">
    				<label for="igreja" class="control-label">Cargo:</label>
    			</div>
    			<div class="col-sm-3">
    				<select class='form-control' id='cargo' name='cargo'>
			   			<?php 
		   					echo "<option selected></option>";
		   					$pdoc = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
		   					//Recupera as Regiões cadastradas
			   				$sqlc = 'select * from cargo';
			   				$stmc = $pdoc->query($sqlc);
			   				//var_dump("teste");
			   				//Monta a lista de regiões conforme recuperado do banco.
			   				while($listac = $stmc->fetch(PDO::FETCH_ASSOC)){
			   					if ($idcargo!=$listac['id_cargo'])	{
			   						echo "<option value='".$listac['id_cargo']."'>".$listac['ds_cargo']."</option>";
			   					}
			   				}
				   		?>
			   		</select>
      			</div>
 				<div class="col-sm-2">
	 				<label for="igreja" class="control-label">Data de membrecia:<b>*</b></label>
	    		</div>
	    		<div class="col-sm-2">
	      			<input type="text" class="form-control data" id="dtmembrecia" name="dtmembrecia" required>
	    		</div>
	    	</div>
 			<br/>
 			<div class="lead col-sm-offset-4 ">
 				<h3><strong>Dado Pessoais</strong></h3>
 			</div>
 			<br/>
 			<div class="lead">
				<div class="col-sm-2">
					<label for="membro" class="control-label">Nome:<b>*</b></label>
				</div>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="membro" name="membro" placeholder="Nome do membro" required>	   	
				</div>
			</div>
			<br/>	
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="rg" class="control-label">RG:</label>
			   		</div>
			   		<div class="col-sm-3">
			   			<input type="text" class="form-control" id="rg" name="rg">	   	
					</div>
					<div class="col-sm-2">
			   			<label for="cpf" class="control-label">CPF:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-2">
			   			<input type="text" class="form-control cpf" id="cpf" name="cpf"  required>	   	
					</div>
				</div>
			<br/>	
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="escolaridade" class=" control-label">Escolaridade:</label>
			   		</div>
			   		<div class="col-sm-3">
			   			<select class='form-control' id='escolaridade' name='escolaridade'>
			   				<option selected ></option>
			   				<option value=1>Fundamental</option>
			   				<option value=2>Médio</option>
			   				<option value=3>Superior</option>
			   			</select>	   	
					</div>
			   		<div class=" col-sm-2">
						<label for="dtnascimento" class=" control-label">Data de nascimento:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-2">
			   			<input type="text" class="form-control data" id="dtnascimento" name="dtnascimento" required>	   	
					</div>
				</div>
			<br/>
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="sexo" class="control-label">Sexo:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-2">
			   			<select class='form-control' id='sexo' name='sexo'>
			   				<option selected ></option>
			   				<option value=1>Feminino</option>
			   				<option value=2>Masculino</option>
			   			</select>	   	
					</div>
					<div class="col-sm-offset-1 col-sm-2">
						<label for="civil" class="control-label">Estado civil:<b>*</b></label>
					</div>
			   		<div class="col-sm-2">
			   			<select class='form-control' id='civil' name='civil'>
			   				<option selected ></option>
			   				<option value=1>Casado</option>
			   				<option value=2>Divorciado</option>
			   				<option value=3>Solteiro</option>
			   				<option value=4>União Estável</option>
			   				<option value=5>Viúvo</option>
			   			</select>
			   		</div>
				</div>
			<br/>	
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="endereco" class="control-label">Endereço:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-5">
			   			<input type="text" class="form-control" id="endereco" name="endereco" required>	   	
					</div>
				</div>
			<br/>	
				<div class="lead">
					<div class="col-sm-2">
						<label for="email" class="control-label">E-mail:</label>
			   		</div>
			   		<div class="col-sm-3">
			   			<input type="email" class="form-control" id="email" name="email">	   	
					</div>
					<div class="col-sm-2">
			   			<label for="telefone" class="control-label">Telefone:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-2">
			   			<input type="text" class="form-control telefone" id="telefone" name="telefone" required>	   	
					</div>
				</div>
				<br/>
				<div class="lead">
					<div class="col-sm-2">
			   			<label for="filiacao" class="control-label">Filiação:</label>
			   		</div>
			   		<div class="col-sm-2">
			   			<label for="pai" class="control-label">Nome do Pai:</label>
			   		</div>
			   		<div class="col-sm-5">
			   			<input type="text" class="form-control" id="pai" name="pai">	   	
					</div>
				</div>
			<br>
				<div class="lead">
					<div class="col-sm-offset-2 col-sm-2">
			   			<label for="mae" class="control-label">Nome da mãe:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-5">
			   			<input type="text" class="form-control" id="mae" name="mae" required>	   	
					</div>
				</div>
				<br>
				<div class="lead">
					<div class="col-sm-2">
			   			<label for="conjugue" class="control-label">Nome do conjugue:</label>
			   		</div>
			   		<div class="col-sm-5">
			   			<input type="text" class="form-control" id="conjugue" name="conjugue">	   	
					</div>
				</div>
			<br>
				<div class="lead">
					<div class="col-sm-2">
			   			<label for="filhos" class="control-label">Nº de filhos:</label>
			   		</div>
			   		<div class="col-sm-2">
			   			<label for="filhos" class="control-label">Homens:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-1">
			   			<input type="number" class="form-control" min=0 id="homens" name="homens" required>	   	
					</div>
					<div class="col-sm-offset-1 col-sm-2">
						<label for="filhas" class="control-label">Mulher:<b>*</b></label>
			   		</div>
			   		<div class="col-sm-1">
			   			<input type="number" class="form-control" min=0 id="mulher" name="mulher" required>	   	
					</div>
				</div>
				<br/>
				<div class="lead col-sm-offset-4">
 					<h3><strong>Dado Religiosos</strong></h3>
 				</div>
 				<br/>
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="conversao" class="control-label">Conversão:</label>
			   		</div>
			   		<div class="col-sm-2">
			   			<input type="text" class="form-control data" id="conversao" name="conversao">	   	
					</div>
					<div class="col-sm-2">
						<label for="lugarconv" class="control-label">Lugar:</label>
					</div>
			   		<div class="col-sm-3">
			   			<input type="text" class="form-control" id="lugarconv" name="lugarconv">	   	
					</div>
				</div>
				<br/>
				<div class="lead">
					<div class="col-sm-2">
			   			<label for="bataguas" class="control-label">Bat. Aguas:</label>
			   		</div>
			   		<div class="col-sm-2">
			   			<input type="text" class="form-control data" id="bataguas" name="bataguas">	   	
					</div>
					<div class="col-sm-2">
						<label for="lugarbat" class="control-label">Lugar:</label>
					</div>
			   		<div class="col-sm-3">
			   			<input type="text" class="form-control" id="lugarbat" name="lugarbat">	   	
					</div>
				</div>
				<br/>
				<div class="lead">
					<div class="col-sm-2">
			   			<label for="ministro" class="control-label">Ministro:</label>
			   		</div>
			   		<div class="col-sm-5">
			   			<input type="text" class="form-control" id="ministro" name="ministro">	   	
					</div>
				</div>
				<br/>
				<div class="lead">
					<div class="col-sm-2">
			   			<label for="bates" class="control-label">Bat. E. S.:</label>
			   		</div>
			   		<div class="col-sm-2">
			   			<input type="text" class="form-control data" id="bates" name="bates">	   	
					</div>
					<div class="col-sm-2">
						<label for="lugares" class="control-label">Lugar:</label>
			   		</div>
			   		<div class="col-sm-3">
			   			<input type="text" class="form-control" id="lugares" name="lugares">	   	
					</div>
				</div>
				<br/>
				<div class="lead  col-sm-offset-4">
 					<h3><strong>Dado do Antigo Ministério</strong></h3>
 				</div>
 				<br/>
				<div class="lead">
					<div class="col-sm-2">
			   			<label for="nomemin" class="control-label">Nome:</label>
			   		</div>
			   		<div class="col-sm-4">
			   			<input type="text" class="form-control" id="nomemin" name="nomemin">	   	
					</div>
				</div>
 				<br/>
				<div class="lead">
					<div class="col-sm-2">
						<label for="cargoant" class="control-label">Cargo:</label>
			   		</div>
			   		<div class="col-sm-3">
			   			<input type="text" class="form-control" id="cargoant" name="cargoant">	   	
					</div>
				</div>
				<br/>
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="datamemant" class="control-label">Data Membrecia:</label>
			   		</div>
			   		<div class="col-sm-2">
			   			<input type="text" class="form-control data" id="datamemant" name="datamemant">	   	
					</div>
					<div class="col-sm-2">
						<label for="lugarant" class="control-label">Lugar:</label>
			   		</div>
			   		<div class="col-sm-3">
			   			<input type="text" class="form-control" id="lugarant" name="lugarant">	   	
					</div>
				</div>
				<br/>
				<div class="lead">
					<div class="col-sm-2">
			   			<label for="pastor" class="control-label">Pastor:</label>
			   		</div>
			   		<div class="col-sm-5">
			   			<input type="text" class="form-control" id="pastor" name="pastor">	   	
					</div>
				</div>
				<br/>
				<div class="lead">
			   		<div class="col-sm-2">
			   			<label for="historico" class="control-label">Histórico:</label>
			   		</div>
			   		<div class="col-sm-7">
			   			<textarea rows="3" class="form-control" id="historico" name="historico">
			   			</textarea>	   	
					</div>
				</div>
			<br/>
 			<br/>				
			<br/>
 			<br/>
 			<br/>
 			
 				<div class="lead">
			   		<div class="col-sm-offset-6 col-sm-4">
			   			<a href="../Membro/pesquisa.php">
			   				<button type="button" class="col-sm-offset-2 btn btn-primary col-sm-3" name="cancel">Cancelar</button>
			   			</a>
			   			<button type="submit" class="btn btn-primary col-sm-offset-1 col-sm-3" id="acao" name="acao" value="salvar">Salvar</button>	   	
					</div>
				</div>
			<br/>
 			<br/>
 			
        	</form>
        <!-- </p> -->
      </div>

    </div><!-- /.container -->
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='../bootstrap/js/bootstrap.min.js'></script><!-- Versão 3.3.6 -->
	<script src='../bootstrap/jquery/1.11.1/jquery.min.js'></script><!-- Versão 1.11.1 -->
	<script type="text/javascript" src="../bootstrap/js/jquery.maskedinput.1-4-1.min.js"></script><!-- Versão 1.4.1 -->
	<script type="text/javascript"> 
	
		$(document).ready(function(){
			$("input.cpf").mask("999.999.999-99");
			$("input.data").mask("99/99/9999");
	       	$("input.cep").mask("99.999-999");
	       	$('#telefone').mask("(99) 9999-9999?9").ready(function(event) {
	       	    var target, phone, element;
	       	    target = (event.currentTarget) ? event.currentTarget : event.srcElement;
	       	    
	       	    element = $(target);
	       	    element.unmask();
	       	    if(phone.length > 10) {
	       	        element.mask("(99) 99999-999?9");
	       	    } else {
	       	        element.mask("(99) 9999-9999?9");  
	       	    }
	       	});
		});
		function alimentarCampo() {
		    var minhaLista = document.getElementById("igreja");
		    
		    document.getElementById("regiao").value = minhaLista.options[minhaLista.selectedIndex].id;
		    document.getElementById("cidade").value = minhaLista.options[minhaLista.selectedIndex].title;
		}
   </script>	
    

    </body>
    
</html>
