<?php
header('Content-Type: text/html; charset=ISO-8859-1', true);
session_start();
//require_once 'movimento.php';
require_once 'crudMovimento.php';
//require_once 'sessao.php';

switch($_REQUEST['ac']) {

	case 'sv': {

		# Uso do singleton para instanciar
		# apenas um objeto de autentica��o
		# e esconder a classe real de autentica��o
		$aut = CrudMovimento::instanciar();

		# efetua o processo de autentica��o
		if ($aut->salvar($_REQUEST['dtatual'],$_REQUEST['dtmovimento'], 
						$_REQUEST['tpmovimento'],$_REQUEST['valor'],
						$_REQUEST['igreja'])) {
			
			# redireciona o usu�rio para dentro do sistema
			header('location: /GestaoCrista/Movimento/pesquisa.php?resultado=1');
		}
		else {
			# envia o usu�rio de volta para
			header('location: /GestaoCrista/Movimento/cadastro.php?resultado=erro');
		}

	} break;

	case 'alt': {

		# Uso do singleton para instanciar
		# apenas um objeto de autentica��o
		# e esconder a classe real de autentica��o
		$aut = CrudMembro::instanciar();

		# efetua o processo de autentica��o
		//if()
		//var_dump("entrou aqui");
			if ($aut->alterar($_REQUEST['dta'],$_REQUEST['dti'],
								$_REQUEST['tpm'],$_REQUEST['vlr'],$_REQUEST['igj'])) {
						# redireciona o usu�rio para dentro do sistema
				header('location: /GestaoCrista/Movimento/pesquisa.php?resultado=1');
			}
			else {
				# envia o usu�rio de volta para
				header('location: /GestaoCrista/Movimento/cadastro.php?resultado=erro');
			}	
	
	} break;
	
}
	
?>
