<?php
/**
 * Created by PhpStorm.
 * UserImport: anon
 * Date: 6/19/18
 * Time: 7:38 PM
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $content = $this->renderView('index.html.twig');
        return new Response($content);
    }
}