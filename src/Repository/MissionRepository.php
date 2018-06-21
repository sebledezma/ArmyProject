<?php

namespace App\Repository;

use App\Entity\Location;
use App\Entity\Mission;
use App\Entity\Team;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MissionRepository extends CrudService implements IMissionRepository
{
    /**
     * MissionRepository constructor.
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
        return $this->em->getRepository(Mission::class);
    }

    /**
     * @inheritDoc
     */
    public function getAllMissions(){
        return $this->getRepo()->findAll();
    }

    /**
     * @inheritDoc
     */
    public function getMissionByID($missionId){
        $oneMission = $this->getRepo()->find($missionId);
        if (!$oneMission){
            throw new NotFoundHttpException("MISSION NOT FOUND");
        }
        return $oneMission;
    }

    /**
     * @inheritDoc
     */
    public function getMissionsByTeamID($teamId){
        return $this->getRepo()->findBy(["teamID"=>$teamId]);
    }

    /**
     * @inheritDoc
     */
    public function getMissionsByLocationID($locationId){
        return $this->getRepo()->findBy(["locationID"=>$locationId]);
    }

    /**
     * @inheritDoc
     */
    public function getMissionsByStartdatetime($start){
        return $this->getRepo()->findBy(["start"=>$start]);
    }

    /**
     * @inheritDoc
     */
    public function getMissionsByEnddatetime($end){
        return $this->getRepo()->findBy(["end"=>$end]);
    }

    /**
     * @inheritDoc
     */
    public function saveMission($oneMission){
        $this->em->persist($oneMission);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function delMission($missionId){
        $oneMission = $this->getMissionByID($missionId);
        $this->em->remove($oneMission);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function getMissionForm($oneMission){
        $form = $this->formFactory->createBuilder(FormType::class, $oneMission);
        $form->add("teamID", EntityType::class, [
            'class' => Team::class,
            'choice_label'=>'name',
            'choice_value'=>'id',
            'required'=>true
        ]);
        $form->add("locationID", EntityType::class, [
            'class' => Location::class,
            'choice_label'=>'coordinates',
            'choice_value'=>'id',
            'required'=>true
        ]);
        $form->add("start", DateTimeType::class, [
            'required'=>true
        ]);
        $form->add("end", DateTimeType::class, [
            'required'=>true
        ]);
        $form->add("SAVE", SubmitType::class);
        return $form->getForm();
    }
}
