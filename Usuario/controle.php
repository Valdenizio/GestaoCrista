<?php

session_start();
require_once 'usuario.php';
require_once 'crudUsuario.php';
//require_once 'sessao.php';

switch($_REQUEST['acao']) {

	case 'salvar': {

		# Uso do singleton para instanciar
		# apenas um objeto de autenticação
		# e esconder a classe real de autenticação
		$aut = CrudIgreja::instanciar();

		# efetua o processo de autenticação
		if ($aut->salvar($_REQUEST['igreja'],$_REQUEST['dirigente'],
						$_REQUEST['conjugue'], $_REQUEST['endereco'],
						$_REQUEST['cep'], $_REQUEST['telefone'],$_REQUEST['inauguracao'],
						$_REQUEST['banco'],$_REQUEST['agencia'],$_REQUEST['conta'],
						$_REQUEST['inform'])) {
			
			
							
							
			# redireciona o usuário para dentro do sistema
			header('location: /GestaoCrista//Igreja/pesquisa.php?resultado=1');
		}
		else {
			# envia o usuário de volta para
			# o form de login
			header('location: /GestaoCrista/Igreja/cadastro.php?res=erro');
		}

	} break;

	case 'sair': {

		# envia o usuário para fora do sistema
		# o form de login
		header('location: /GestaoCrista/index.php');

	} break;
	
	case 'excluir': {

		# Uso do singleton para instanciar
		# apenas um objeto de autenticação
		# e esconder a classe real de autenticação
		$aut = CrudIgreja::instanciar();

		# efetua o processo de autenticação
		//if()
		//var_dump("entrou aqui");
			if ($aut->excluir($_REQUEST['id_igreja'])) {
				# redireciona o usuário para dentro do sistema
				header('location: /GestaoCrista/Igreja/pesquisa.php?resultado=2');
				//var_export($_REQUEST['id_igreja']);
			}
			else {
				# envia o usuário de volta para
				# o form de login
				header('location: /GestaoCrista/login/visualizar.php?res=erro');
			}	
	
	} break;

	
	case 'alterar': {
	
		# Uso do singleton para instanciar
		# apenas um objeto de autenticação
		# e esconder a classe real de autenticação
		$aut = CrudIgreja::instanciar();
	
		# efetua o processo de autenticação
		//if()
		//var_dump("entrou aqui");
		$idigreja=base64_decode($_REQUEST['id_igreja']);
		if ($aut->alterar($idigreja,$_REQUEST['igreja'],$_REQUEST['dirigente'],
						$_REQUEST['conjugue'], $_REQUEST['endereco'],$_REQUEST['cep'],
						 $_REQUEST['telefone'],$_REQUEST['inauguracao'],$_REQUEST['banco'],
						$_REQUEST['agencia'],$_REQUEST['conta'],$_REQUEST['inform'])) {
			# redireciona o usuário para dentro do sistema
			header('location: /GestaoCrista/Igreja/pesquisa.php?resultado=3');
			//var_export($idigreja);
		}
		else {
			# envia o usuário de volta para
			# o form de login
			header('location: /GestaoCrista/login/visualizar.php?res=erro');
		}
	
	}break;	
		
}
	
?>
