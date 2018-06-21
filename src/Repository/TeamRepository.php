<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TeamRepository extends CrudService implements ITeamRepository
{
    /**
     * TeamRepository constructor.
     * @param $em EntityManager
     * @param $form FormFactory
     * @param $request Request
     */
    public function __construct($em, $form, $request)
    {
        parent::__construct($em, $form, $request);
    }

    /**
     * @inheritDoc
     */
    public function getRepo()
    {
        return $this->em->getRepository(Team::class);
    }

    /**
     * @inheritDoc
     */
    public function getAllTeams(){
        return $this->getRepo()->findAll();
    }

    /**
     * @inheritDoc
     */
    public function getTeamByID($teamId){
        $oneTeam = $this->getRepo()->find($teamId);
        if (!$oneTeam){
            throw new NotFoundHttpException("TEAM NOT FOUND");
        }
        return $oneTeam;
    }

    /**
     * @inheritDoc
     */
    public function getTeamByTeamName($teamName){
        return $this->getRepo()->findBy(["name"=>$teamName]);
    }

    /**
     * @inheritDoc
     */
    public function getTeamByCodename($codename){
        return $this->getRepo()->findBy(["codeName"=>$codename]);
    }

    /**
     * @inheritDoc
     */
    public function getTeamByType($type){
        return $this->getRepo()->findBy(["type"=>$type]);
    }

    /**
     * @inheritDoc
     */
    public function saveTeam($oneTeam){
        $this->em->persist($oneTeam);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function delTeam($teamId){
        $oneTeam = $this->getTeamByID($teamId);
        $this->em->remove($oneTeam);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function getTeamForm($oneTeam){
        $form = $this->formFactory->createBuilder(FormType::class, $oneTeam);
        $form->add("name", IntegerType::class, [
            'required'=>true
        ]);
        $form->add("codeName", IntegerType::class, [
            'required'=>true
        ]);
        $form->add("type", ChoiceType::class, [
            'choices' => array("Assault","Recon","Sniper","Support"),
            'required'=>true
        ]);
        $form->add("SAVE", SubmitType::class);
        return $form->getForm();
    }
}
