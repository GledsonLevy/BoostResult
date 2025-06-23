<?php

	/* @Autor: Dalker Pinheiro
	   Atributos e métodos da classe */
	   
	class Arquivo{
		//Atributos
		private $id_arq;

 		private $id_solicitacao;

 		private $nome;

 		private $arq;

 		private $tipo;

 				
		//Métodos Getters e Setters
		public function getId_arq(){
			return $this->id_arq;
		}

		public function getId_solicitacao() { return $this->id_solicitacao; }


		public function getNome(){
			return $this->nome;
		}

		public function getArq(){
			return $this->arq;
		}

		public function getTipo(){
			return $this->tipo;
		}

		
		public function setId_arq($id_arq){
			$this->id_arq=$id_arq;
		}

		public function setId_solicitacao($id_solicitacao) { $this->id_solicitacao = $id_solicitacao; }

		public function setNome($nome){
			$this->nome=$nome;
		}

		public function setArq($arq){
			$this->arq=$arq;
		}

		public function setTipo($tipo){
			$this->tipo=$tipo;
		}

		
	}