<?php

namespace App\Controller;

use App\Form\CalculationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CalculatorController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(CalculationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            die('form submitted.');
            // Save the calculation to the db
        }

        return $this->render('calculator/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

}