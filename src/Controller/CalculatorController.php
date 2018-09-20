<?php

namespace App\Controller;

use App\Calculator\Calculator;
use App\Form\Calculator\DisplayType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WolframAlpha\Engine;

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
//        $calculator->setEquation($request->get('equation'));
        $equation = (string)$request->get('equation');
//        var_dump($equation);

//        echo "calculator->getEquation()\n";
//        var_dump($calculator->getEquation());

        $engine = new Engine('YTV5WQ-TP29ARPJ2W');

        $result = $engine->process('Floor(sqrt(' . $equation . '), 1E-5)', [], ['plaintext']); //&includepodid=DecimalApproximation

        if($result->hasWarnings())
        {
            foreach($result->getWarnings() as $name => $message)
            {
                echo $name . ': ' . $message;
            }
        }

        echo 'Result success? ' . (string)$result->success . "\n";

        if($result->hasError())
        {
            echo 'Error ' . $result->getError()['code'] . ': ' . $result->getError()['message'];
        }

//        echo 'Floor(sqrt(' . $equation . '), 1E-5)'. "\n";

//        var_dump($result->pods['DecimalApproximation']->subpods[0]->plaintext);

//        var_dump($result->pods['Result']->subpods[0]->plaintext);
//        foreach ($result->pods['DecimalApproximation']->subpods as $subpods) {
//            var_dump($subpods);
//        }
        $result = [];

        foreach ($result->pods['Result']->subpods as $subpod) {
            $result[] = implode('*', explode(' ', $subpod->plaintext));
        }

        var_dump($result);

        return $this->render('calculator.twig', [
            'form' => $form->createView(),
            'equation' => $calculator->getEquation(),
            'result' => $result->pods['DecimalApproximation']->subpods[0]->plaintext,
        ]);
    }
}