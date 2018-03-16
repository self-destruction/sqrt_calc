<?php

namespace App\Controller;

use App\Calculator\Calculator;
use App\Form\Calculator\DisplayType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CalculatorController extends Controller
{
    /**
     * @Route("/", name="calculator")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(DisplayType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            return $this->redirectToRoute('result', [
                'equation' => $request->get('display')['equation']
            ]);
        }

        return $this->render('calculator.twig', [
            'form' => $form->createView(),
            'result' => 0
        ]);
    }

    /**
     * @Route("/{equation}",  name="result", requirements={"equation" = ".+"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resultAction(Request $request)
    {
        $form = $this->createForm(DisplayType::class);

        // Check equation exists in the url and set it into the form field.
        if ($request->get('equation')) {
            $form->get('equation')->setData($request->get('equation'));
        }

        $form->handleRequest($request);

        // Handle form submission and parse equation through to the url
        if ($form->isSubmitted()) {
            return $this->redirectToRoute('result', ['equation' => $form->get('equation')->getData()]);
        }

        $calculator = $this->get(Calculator::class);
        $calculator->setEquation($request->get('equation'));

        return $this->render('calculator.twig', [
            'form' => $form->createView(),
            'equation' => $calculator->getEquation(),
            'result' => $calculator->getResult(),
        ]);
    }
}