<?php

namespace models\entidades;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 */
class Dependente extends Pessoa{

    /**
     * @var int $idade
     * @Column(type="integer", options={"unsigned":true})
     */
    protected $idade;

    /**
     * @ManyToMany(targetEntity="Funcionario", mappedBy="dependentes")
     */
    protected $funcionarios;

    
    // contructor

    public function __construct(){
        parent::__construct();
        $this->funcionarios = new ArrayCollection();
    }


    // getters

    public function getIdade(){
        return $this->idade;
    }

    public function getFuncionarios(){
        return $this->funcionarios;
    }


    // setters

    public function setIdade($idade){
        $this->idade = $idade;
    }

    public function addFuncionario(Funcionario $funcionario){
        $this->getFuncionarios()->add($funcionario);
    }
}