<?php

namespace TelmiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TelmiBundle:Default:index.html.twig');
    }

    public function dictionAction()
    {
        return $this->render('TelmiBundle:Azure:diction.html.twig');
    }
}
