<?php

namespace App\Controller;

use App\Entity\Calculation;
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
            $request = $request->request->get('calculation');
            $calculation = new Calculation($request['inputA'], $request['inputB'], $request['operator']);

            dump($calculation->calculateResult());
            die;
        }

        return $this->render('calculator.twig', [
            'form' => $form->createView()
        ]);
    }
}