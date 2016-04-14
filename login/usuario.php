<?php
class Usuario {
	private $id = null;
	private $login = null;
	private $senha = null;
	private $perfil = null;
	private $igreja = null;
	

	public function getId() {
		return $this->id;
	}

	public function getLogin() {
		return $this->login;
	}

	public function getSenha() {
		return $this->senha;
	}

	public function getPerfil() {
		return $this->perfil;
	}
	
	public function getIgreja() {
		return $this->igreja;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setLogin($login) {
		$this->login = $login;
	}

	public function setSenha($senha) {
		$this->senha = $senha;
	}

	public function setPerfil($perfil) {
		$this->perfil = $perfil;
	}
	
	public function setIgreja($igreja) {
		$this->igreja = $igreja;
	}
	
	public function recuperaUusario() {
		$retorno['id']=$this->getId();
		$retorno['login']=$this->getLogin();
		$retorno['perfil']=$this->getPerfil();
		$retorno['igreja']=$this->getIgreja();
		return $retorno;
	}
}

?>