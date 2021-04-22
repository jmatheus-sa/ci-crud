<?php

namespace models\entidades;

/**
 * @Entity
 * @Table(name="pessoa")
 * @InheritanceType("SINGLE_TABLE")
 */
class Pessoa extends Entidade{

    /**
     * @var string $nome
     * @Column(type="string", length=60)
     */
    protected $nome;

    /**
     * @var int $cpf
     * @Column(type="bigint", options={"unsigned":true})
     */
    protected $cpf;

    /**
     * @OneToOne(targetEntity="Endereco", cascade={"remove"})
     * @JoinColumn(name="endereco_id", referencedColumnName="id")
     */
    protected $endereco;

    // construct

    public function __construct(){
        parent::__construct();

    }


    // getters

    public function getNome(){
        return $this->nome;
    }

    public function getCpf(){
        return $this->cpf;
    }

    public function getEndereco(){
        return $this->endereco;
    }


    // setters

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function setCpf($cpf){
        $this->cpf = $cpf;
    }

    public function setEndereco(Endereco $endereco){
        $this->endereco = $endereco;
    }

}