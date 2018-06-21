<?php
/**
 * Created by PhpStorm.
 * User: anon
 * Date: 6/21/18
 * Time: 4:39 AM
 */

namespace App\Controller;


use App\Entity\Mission;
use App\Repository\IMissionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class MissionController extends Controller
{
    /** @var IMissionRepository */
    private $missionRepository;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->missionRepository=$container->get('app.missionRepository');
    }

    public function listAction(Request $request, $id=0) {
        if ($id){
            $missions = $this->missionRepository->getMissionByID($id);
        } else {
            $missions = $this->missionRepository->getAllMissions();
        }
        $twigParams = array("missions"=>$missions);
        return $this->render('mission/missionlist.html.twig', $twigParams);
    }

    public function showAction(Request $request, $id) {
        $oneMission = $this->missionRepository->getMissionByID($id);
        return $this->render('mission/onemission.html.twig',
            ["team"=>$oneMission]);
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delAction(Request $request, $id) {
        $this->missionRepository->delMission($id);
        $this->addFlash('notice', 'MISSION DELETED');
        return $this->redirectToRoute('missionlist');
    }

    public function editAction(Request $request, $id=0) {
        if ($id){
            $oneLocation = $this->missionRepository->getMissionByID($id);
        } else {
            $oneLocation = new Mission();
        }
        $form = $this->missionRepository->getMissionForm($oneLocation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->missionRepository->saveMission($oneLocation);
            $this->addFlash('notice', 'TEAM EDITED');
            return $this->redirectToRoute('teamlist');
        }
        return $this->render(':mission:missionedit.html.twig',
            ["form"=>$form->createView()]);
    }
}