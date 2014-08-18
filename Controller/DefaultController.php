<?php

namespace Stems\PollBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StemsPollBundle:Default:index.html.twig', array('name' => $name));
    }
}
