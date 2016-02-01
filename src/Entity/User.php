<?php
/**
 * Created by PhpStorm.
 * User: dada
 * Date: 15/01/2016
 * Time: 18:50
 */

namespace WebService\Entity;


class User
{

    protected $id;

    protected $nom;

    protected $prenom;

    protected $tel;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        // TODO controler le type de $id must be int

        $this->id = $id;
        return $this;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @param mixed $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
        return $this;
    }

    /**
     * Créer un objet User et renseigne c'est différente propriété
     *
     * @param $data
     * @return User
     */
    public static function hydrate($data)
    {
        $user = new self;

        $user
            ->setId($data[0])
            ->setNom($data[1])
            ->setPrenom($data[2])
            ->setTel($data[3])
        ;

        return $user;

    }

    /**
     * Transforme l'objet en tableau
     *
     * @return array
     */
    public function toArray()
    {
        $data = array(
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'telephone' => $this->getTel(),
        );

        return $data;
    }

}