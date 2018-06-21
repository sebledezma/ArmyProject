<?php
/**
 * Created by PhpStorm.
 * User: anon
 * Date: 6/21/18
 * Time: 4:38 AM
 */

namespace App\Controller;


use App\Entity\Team;
use App\Repository\ITeamRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends Controller
{
    /** @var ITeamRepository */
    private $teamRepository;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->teamRepository=$container->get('app.teamRepository');
    }

    public function listAction(Request $request, $id=0) {
        if ($id){
            $teams = $this->teamRepository->getTeamByID($id);
        } else {
            $teams = $this->teamRepository->getAllTeams();
        }
        $twigParams = array("teams"=>$teams);
        return $this->render('team/teamlist.html.twig', $twigParams);
    }

    public function showAction(Request $request, $id) {
        $oneTeam = $this->teamRepository->getTeamByID($id);
        return $this->render('team/oneteam.html.twig',
            ["team"=>$oneTeam]);
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delAction(Request $request, $id) {
        $this->teamRepository->delTeam($id);
        $this->addFlash('notice', 'TEAM DELETED');
        return $this->redirectToRoute('teamdel');
    }

    public function editAction(Request $request, $id=0) {
        if ($id){
            $oneTeam = $this->teamRepository->getTeamByID($id);
        } else {
            $oneTeam = new Team();
        }
        $form = $this->teamRepository->getTeamForm($oneTeam);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->teamRepository->saveTeam($oneTeam);
            $this->addFlash('notice', 'TEAM EDITED');
            return $this->redirectToRoute('teamlist');
        }
        return $this->render('team/teamedit.html.twig',
            ["form"=>$form->createView()]);
    }
}