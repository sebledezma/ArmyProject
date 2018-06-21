<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LocationRepository extends CrudService implements ILocationRepository
{
    /**
     * LocationRepository constructor.
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
        return $this->em->getRepository(Location::class);
    }

    /**
     * @inheritDoc
     */
    public function getAllLocations(){
        return $this->getRepo()->findAll();
    }

    /**
     * @inheritDoc
     */
    public function getLocationByID($locationId){
        $oneLocation = $this->getRepo()->find($locationId);
        if (!$oneLocation){
            throw new NotFoundHttpException("LOCATION NOT FOUND");
        }
        return $oneLocation;
    }

    /**
     * @inheritDoc
     */
    public function getLocationsByCountry($country){
        return $this->getRepo()->findBy(["country"=>$country]);
    }

    /**
     * @inheritDoc
     */
    public function getLocationsByCity($city){
        return $this->getRepo()->findBy(["city"=>$city]);
    }

    /**
     * @inheritDoc
     */
    public function getLocationByStreet($street){
        return $this->getRepo()->findBy(["street"=>$street]);
    }

    /**
     * @inheritDoc
     */
    public function getLocationByCoordinates($coordinates){
        return $this->getRepo()->findBy(["coordinates"=>$coordinates]);
    }

    /**
     * @inheritDoc
     */
    public function saveLocation($oneLocation){
        $this->em->persist($oneLocation);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function delLocation($locationId){
        $oneLocation = $this->getLocationByID($locationId);
        $this->em->remove($oneLocation);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function getLocationForm($oneLocation){
        $form = $this->formFactory->createBuilder(FormType::class, $oneLocation);
        $form->add("country", TextType::class, [
            'required'=>true
        ]);
        $form->add("city", TextType::class, [
            'required'=>true
        ]);
        $form->add("street", TextType::class, [
            'required'=>true
        ]);
        $form->add("coordinates", TextType::class, [
            'required'=>true
        ]);
        $form->add("SAVE", SubmitType::class);
        return $form->getForm();
    }
}
