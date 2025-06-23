<?php

class Cliente {
    private $id_cliente;
    private $nome_completo;
    private $genero;
    private $cpf;
    private $rg;
    private $telefone;
    private $email;

    // Getters
    public function getId_cliente() { return $this->id_cliente; }
    public function getNome_completo() { return $this->nome_completo; }
    public function getGenero() { return $this->genero; }
    public function getCpf() { return $this->cpf; }
    public function getRg() { return $this->rg; }
    public function getTelefone() { return $this->telefone; }
    public function getEmail() { return $this->email; }

    // Setters
    public function setId_cliente($id) { $this->id_cliente = $id; }
    public function setNome_completo($nome) { $this->nome_completo = $nome; }
    public function setGenero($genero) { $this->genero = $genero; }
    public function setCpf($cpf) { $this->cpf = $cpf; }
    public function setRg($rg) { $this->rg = $rg; }
    public function setTelefone($telefone) { $this->telefone = $telefone; }
    public function setEmail($email) { $this->email = $email; }
}
