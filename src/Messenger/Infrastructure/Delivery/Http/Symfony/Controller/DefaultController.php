<?php

namespace Messenger\Infrastructure\Delivery\Http\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MessengerBundle:Default:index.html.twig');
    }
}
