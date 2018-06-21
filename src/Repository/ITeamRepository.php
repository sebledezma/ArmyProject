<?php
/**
 * Created by PhpStorm.
 * User: anon
 * Date: 6/21/18
 * Time: 2:09 AM
 */

namespace App\Repository;


use App\Entity\Team;
use Symfony\Component\Form\FormInterface;

interface ITeamRepository
{
    /**
     * @return Team[]
     */
    public function getAllTeams();
    /**
     * @param $teamId integer
     * @return Team
     */
    public function getTeamByID($teamId);
    /**
     * @param $teamName string
     * @return Team
     */
    public function getTeamByTeamName($teamName);
    /**
     * @param $codename string
     * @return Team
     */
    public function getTeamByCodename($codename);
    /**
     * @param $type string
     * @return Team
     */
    public function getTeamByType($type);
    /**
     * @param $oneTeam Team
     */
    public function saveTeam($oneTeam);
    /**
     * @param $teamId integer
     */
    public function delTeam($teamId);
    /**
     * @param $oneTeam Team
     * @return FormInterface
     */
    public function getTeamForm($oneTeam);
}