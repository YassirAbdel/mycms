<?php

namespace App\Classe;

use phpDocumentor\Reflection\Types\Integer;

class Search
{
    /**
     * @var string
     */
    public $string = '';

    /**
     * @var integer
     */
    public $id_rubrique = '';

    /**
     * @var integer
     */
    public $id_texte = '';

    /**
     * @var integer
     */
    public $id_collection = '';

    /**
     * @var integer
     */
    public $id_article = '';

    /**
     * @var integer
     */
    public $id_sous_collection = '';

    public function __toString()
    {
        return $this->getString();
    }

    public function getString(): ?string
    {
        return $this->string;
    }

    public function getIdrubrique(): ?string
    {
        return $this->id_rubrique;
    }

    public function getIdcollection(): ?string
    {
        return $this->id_collection;
    }

    public function getIdsouscollection(): ?string
    {
        return $this->id_sous_collection;
    }

    public function getIdarticle(): ?string
    {
        return $this->id_article;
    }

    public function getIdtexte(): ?string
    {
        return $this->id_texte;
    }
    
}