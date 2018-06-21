<?php
namespace App\Repository;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CrudFactory
{
    /** @var EntityManager  */
    private $em;
    /** @var  FormFactory */
    private $formFactory;
    /** @var  Request */
    private $request;
    /**
     * CrudFactory constructor.
     * @param $em EntityManager
     * @param $form FormFactory
     * @param $requestStack RequestStack
     */
    public function __construct($em, $form, $requestStack)
    {
        $this->em=$em;
        $this->formFactory=$form;
        $this->request=$requestStack->getCurrentRequest();
        // Request::createFromGlobals()
    }
    /**
     * @return ITeamRepository
     */
    public function getTeamRepository(){
        return new TeamRepository($this->em, $this->formFactory, $this->request);
    }
        /**
     * @return IMissionRepository
     */
    public function getMissionRepository(){
        return new MissionRepository($this->em, $this->formFactory, $this->request);
    }
        /**
     * @return ILocationRepository
     */
    public function getLocationRepository(){
        return new LocationRepository($this->em, $this->formFactory, $this->request);
    }
}