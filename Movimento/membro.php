<?php
class Igreja {
	private $id = null;
	private $nomeIgreja = null;
	private $nomeDirigente = null;
	private $nomeConjugue = null;
	private $endereco = null;
	private $cep = null;
	private $telefone  = null;
	private $dataInauguracao = null;
	private $banco = null;
	private $agencia = null;
	private $conta = null;
	private $informacoes = null;

	public function getId() {
		return $this->id;
	}

	public function getNomeIgreja() {
		return $this->nomeIgreja;
	}

	public function getNomeDirigente() {
		return $this->nomeDirigente;
	}

	public function getNomeConjugue() {
		return $this->nomeConjugue;
	}
	
	public function getEndereco() {
		return $this->endereco;
	}
	
	public function getCep() {
		return $this->cep;
	}
	
	public function getTelefone() {
		return $this->telefone;
	}

	public function getDataInauguracao() {
		return $this->dataInauguracao;
	}
	
	public function getBanco() {
		return $this->banco;
	}
	
	public function getAgencia() {
		return $this->agencia;
	}
	
	public function getConta() {
		return $this->conta;
	}
	
	public function getInformacoes() {
		return $this->informacoes;
	}
	
	public function setId($id) {
		$this->id = $id;
	}

	public function setNomeIgreja($nomeIgreja) {
		$this->nomeIgreja = $nomeIgreja;
	}

	public function setNomeDirigente($nomeDirigente) {
		$this->nomeDirigente = $nomeDirigente;
	}

	public function setNomeConjugue($nomeConjugue) {
		$this->nomeConjugue = $nomeConjugue;
	}
	
	public function setEndereco($endereco) {
		$this->endereco = $endereco;
	}
	
	public function setCep($cep) {
		$this->cep = $cep;
	}
	
	public function setTelefone($telefone) {
		$this->telefone = $telefone;
	}
	
	public function setDataInauguracao($dataInauguracao) {
		$this->dataInauguracao = $dataInauguracao;
	}
	
	public function setBanco($banco) {
		$this->banco = $banco;
	}
	
	public function setAgencia($agencia) {
		$this->agencia = $agencia;
	}
	
	public function setConta($conta) {
		$this->conta = $conta;
	}
	
	public function setInformacoes($informacoes) {
		$this->informacoes = $informacoes;
	}
}

?>