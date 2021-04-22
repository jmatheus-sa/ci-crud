<?php

namespace models\entidades;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @class Estado
 * @Entity
 * @Table(name="estados")
 */
class Estado extends Entidade{

    /**
     * @var string $uf
     * @Column(type="string", length=2)
     */
    protected $uf;

    /**
     * @var string $nome
     * @Column(type="string", length=20)
     */
    protected $nome;

    /**
     * @OneToMany(targetEntity="Endereco", mappedBy="estado")
     */
    protected $enderecos;

    
    // construct

    public function __construct(){
        parent::__construct();
        $this->enderecos = new ArrayCollection();
    }


    // getters

    public function getUf(){
        return $this->uf;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getEnderecos(){
        return $this->enderecos;
    }

    
    // setters

    public function setUf($uf){
        $this->uf = $uf;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function addEnderecos(Endereco $endereco){
        $this->getEnderecos()->add($endereco);
    }

}