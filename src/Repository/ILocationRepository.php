<?php
/**
 * Created by PhpStorm.
 * User: anon
 * Date: 6/21/18
 * Time: 2:10 AM
 */

namespace App\Repository;

use App\Entity\Location;
use Symfony\Component\Form\FormInterface;
interface ILocationRepository
{
    /**
     * @return Location[]
     */
    public function getAllLocations();
    /**
     * @param $locationId integer
     * @return Location
     */
    public function getLocationByID($locationId);
    /**
     * @param $country string
     * @return Location[]
     */
    public function getLocationsByCountry($country);
    /**
     * @param $city string
     * @return Location[]
     */
    public function getLocationsByCity($city);
    /**
     * @param $street string
     * @return Location[]
     */
    public function getLocationByStreet($street);
    /**
     * @param $coordinates string
     * @return Location
     */
    public function getLocationByCoordinates($coordinates);
    /**
     * @param $oneLocation Location
     */
    public function saveLocation($oneLocation);
    /**
     * @param $locationId integer
     */
    public function delLocation($locationId);
    /**
     * @param $oneLocation Location
     * @return FormInterface
     */
    public function getLocationForm($oneLocation);
}