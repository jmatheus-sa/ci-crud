<?php

namespace models\entidades;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 */
class Funcionario extends Pessoa{

    /**
     * @var string $departamento
     * @Column(type="string")
     */
    protected $departamento;

    /**
     * @ManyToMany(targetEntity="Dependente", inversedBy="funcionarios", cascade={"remove"})
     */
    protected $dependentes;


    // construct

    public function __construct(){
        parent::__construct();
        $this->dependentes = new ArrayCollection();
    }


    // getters

    public function getDepartamento(){
        return $this->departamento;
    }

    public function getDependentes(){
        return $this->dependentes;
    }


    // setters

    public function setDepartamento($departamento){
        $this->departamento = $departamento;
    }

    public function addDependente(Dependente $dependente){
        $this->getDependentes()->add($dependente);
    }

}