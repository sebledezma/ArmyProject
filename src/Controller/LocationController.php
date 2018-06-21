<?php
/**
 * Created by PhpStorm.
 * User: anon
 * Date: 6/21/18
 * Time: 4:39 AM
 */

namespace App\Controller;


use App\Entity\Location;
use App\Repository\ILocationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class LocationController extends Controller
{
    /** @var ILocationRepository */
    private $locationRepository;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->locationRepository=$container->get('app.locationRepository');
    }

    public function listAction($id=0) {
        if ($id){
            $locations = $this->locationRepository->getLocationByID($id);
        } else {
            $locations = $this->locationRepository->getAllLocations();
        }
        $twigParams = array("locations"=>$locations);
        return $this->render('location/locationlist.html.twig', $twigParams);
    }

    public function showAction(Request $request, $id) {
        $oneLocation = $this->locationRepository->getLocationByID($id);
        return $this->render('location/onelocation.html.twig',
            ["team"=>$oneLocation]);
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delAction($id) {
        $this->locationRepository->delLocation($id);
        $this->addFlash('notice', 'TEAM DELETED');
        return $this->redirectToRoute('locationlist');
    }

    public function editAction(Request $request, $id=0) {
        if ($id){
            $oneLocation = $this->locationRepository->getLocationByID($id);
        } else {
            $oneLocation = new Location();
        }
        $form = $this->locationRepository->getLocationForm($oneLocation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->locationRepository->saveLocation($oneLocation);
            $this->addFlash('notice', 'TEAM EDITED');
            return $this->redirectToRoute('teamlist');
        }
        return $this->render(':location:locationedit.html.twig',
            ["form"=>$form->createView()]);
    }
}