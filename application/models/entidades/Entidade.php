<?php

namespace models\entidades;
use Doctrine\ORM\PersistentCollection;


/** @MappedSuperclass */
abstract class Entidade{

    /**
     * @var int $id
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct(){
        \Doctrine::$ems->persist($this);
    }

    public function getId(){
        return $this->id;
    }

}