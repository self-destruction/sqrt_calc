<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CalculatorController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('calculator/form.html.twig');
    }

}