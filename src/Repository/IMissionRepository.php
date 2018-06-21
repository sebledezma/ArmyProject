<?php
/**
 * Created by PhpStorm.
 * User: anon
 * Date: 6/21/18
 * Time: 2:09 AM
 */

namespace App\Repository;


use App\Entity\Mission;
use DateTime;
use Symfony\Component\Form\FormInterface;

interface IMissionRepository
{
    /**
     * @return Mission[]
     */
    public function getAllMissions();
    /**
     * @param $missionId integer
     * @return Mission
     */
    public function getMissionByID($missionId);
    /**
     * @param $teamId integer
     * @return Mission[]
     */
    public function getMissionsByTeamID($teamId);
    /**
     * @param $locationId integer
     * @return Mission[]
     */
    public function getMissionsByLocationID($locationId);
    /**
     * @param $start datetime
     * @return Mission
     */
    public function getMissionsByStartdatetime($start);
    /**
     * @param $end datetime
     * @return Mission
     */
    public function getMissionsByEnddatetime($start);
    /**
     * @param $oneMission Mission
     */
    public function saveMission($oneMission);
    /**
     * @param $missionId integer
     */
    public function delMission($missionId);
    /**
     * @param $oneMission Mission
     * @return FormInterface
     */
    public function getMissionForm($oneMission);
}