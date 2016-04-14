<?php
header('Content-Type: text/html; charset=ISO-8859-1', true);
session_start();
require_once 'igreja.php';
require_once 'crudIgreja.php';
//require_once 'sessao.php';

switch($_REQUEST['acao']) {

	case 'salvar': {

		# Uso do singleton para instanciar
		# apenas um objeto de autentica��o
		# e esconder a classe real de autentica��o
		$aut = CrudIgreja::instanciar();

		# efetua o processo de autentica��o
		if ($aut->salvar($_REQUEST['igreja'],$_REQUEST['dirigente'],
						$_REQUEST['conjugue'], $_REQUEST['endereco'], $_REQUEST['cep'], 
						$_REQUEST['regiao'], $_REQUEST['cidade'], $_REQUEST['telefone'],
						$_REQUEST['inauguracao'], $_REQUEST['banco'],$_REQUEST['agencia'],
						$_REQUEST['conta'], $_REQUEST['inform'])) {
			
			
							
							
			# redireciona o usu�rio para dentro do sistema
			header('location: /GestaoCrista//Igreja/pesquisa.php?resultado=1');
		}
		else {
			# envia o usu�rio de volta para
			# o form de login
			header('location: /GestaoCrista/Igreja/cadastro.php?res=erro');
		}

	} break;

	case 'sair': {

		# envia o usu�rio para fora do sistema
		# o form de login
		header('location: /GestaoCrista/index.php');

	} break;
	
	case 'excluir': {

		# Uso do singleton para instanciar
		# apenas um objeto de autentica��o
		# e esconder a classe real de autentica��o
		$aut = CrudIgreja::instanciar();

		# efetua o processo de autentica��o
		//if()
		//var_dump("entrou aqui");
			if ($aut->excluir($_REQUEST['id_igreja'])) {
				# redireciona o usu�rio para dentro do sistema
				header('location: /GestaoCrista/Igreja/pesquisa.php?resultado=2');
				//var_export($_REQUEST['id_igreja']);
			}
			else {
				# envia o usu�rio de volta para
				# o form de login
				$id_igreja=base64_encode($_REQUEST['id_igreja']);
				header('location: /GestaoCrista/Igreja/visualizar.php?res=erro');
			}	
	
	} break;

	
	case 'alterar': {
	
		# Uso do singleton para instanciar
		# apenas um objeto de autentica��o
		# e esconder a classe real de autentica��o
		$aut = CrudIgreja::instanciar();
		
		# efetua o processo de autentica��o
		if(isset($_REQUEST['idigreja'])){
			//var_dump("entrou aqui");
			//$idigj=base64_decode($_REQUEST['idigreja']);
		
		//$idigreja=base64_decode();
		if ($aut->alterar($_REQUEST['idigreja'],$_REQUEST['igreja'],$_REQUEST['dirigente'],
						$_REQUEST['conjugue'], $_REQUEST['endereco'],$_REQUEST['cep'], $_REQUEST['regiao'],
						$_REQUEST['cidade'], $_REQUEST['telefone'],$_REQUEST['inauguracao'],$_REQUEST['banco'],
						$_REQUEST['agencia'],$_REQUEST['conta'],$_REQUEST['inform'])) {
			# redireciona o usu�rio para dentro do sistema
			header('location: /GestaoCrista/Igreja/pesquisa.php?resultado=3');
			//var_export($idigreja);
		}
		else {
			$teste=base64_encode($_REQUEST['idigreja']);
			# envia o usu�rio de volta para
			# o form de login
			//base64_encode($idigreja);
			var_export($teste);
			header("location: /GestaoCrista/Igreja/visualizar.php?res=erro&idigreja=".$teste);
		}
		}
		
	}break;	
		
}
	
?>
