<?php

namespace models\entidades;

/**
 * @class Endereco
 * @Entity
 * @Table(name="enderecos")
 */
class Endereco extends Entidade{
    
    /**
     * @var string $rua
     * @Column(type="string")
     */
    protected $rua;

    /**
     * @var string $cidade
     * @Column(type="string")
     */
    protected $cidade;

    /**
     * @var string $bairro
     * @Column(type="string")
     */
    protected $bairro;

    /**
     * @ManyToOne(targetEntity="Estado", inversedBy="enderecos")
     */
    protected $estado;

    /**
     * @var int $numero
     * @Column(type="integer")
     */
    protected $numero;


    // construct
    
    public function __construct(){
        parent::__construct();
    }


    // getters

    public function getRua(){
        return $this->rua;
    }

    public function getCidade(){
        return $this->cidade;
    }

    public function getBairro(){
        return $this->bairro;
    }

    public function getNumero(){
        return $this->numero;
    }

    public function getEstado(){
        return $this->estado;
    }


    // setters

    public function setRua($rua){
        $this->rua = $rua;
    }

    public function setCidade($cidade){
        $this->cidade = $cidade;
    }

    public function setBairro($bairro){
        $this->bairro = $bairro;
    }

    public function setNumero($numero){
        $this->numero = $numero;
    }

    public function setEstado(Estado $estado){
        $this->estado = $estado;
    }

}