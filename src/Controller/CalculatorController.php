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

        if ($request->get('equation') !== null) {
            $form->get('equation')->setData((string)$request->get('equation'));
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            return $this->redirectToRoute('result', ['equation' => $form->get('equation')->getData()]);
        }

        $equation = (string)$request->get('equation');
        $engine = new Engine('YTV5WQ-TP29ARPJ2W');

        $result = $engine->process('Floor(sqrt(' . $equation . '),1E-6)', [], ['plaintext']); //&includepodid=DecimalApproximation

        if($result->hasWarnings())
        {
            foreach($result->getWarnings() as $name => $message)
            {
                echo $name . ': ' . $message;
            }
        }

//        echo 'Result success? ' . (string)$result->success . "\n";

        if($result->hasError())
        {
            echo 'Error ' . $result->getError()['code'] . ': ' . $result->getError()['message'];
        }

//        echo 'Floor(sqrt(' . $equation . '), 1E-5)'. "\n";

//        var_dump($result->pods['DecimalApproximation']->subpods[0]->plaintext);

//        var_dump($result->pods['Result']->subpods[0]->plaintext);
//        var_dump($result->pods['Result']->subpods);
//        foreach ($result->pods['DecimalApproximation']->subpods as $subpods) {
//            var_dump($subpods);
//        }

//        var_dump((string)$result->pods['DecimalApproximation']);

//        $answer = explode(' ', $result->pods['DecimalApproximation']->subpods[0]->plaintext);
//        var_dump($result->pods['DecimalApproximation']->subpods[0]->plaintext);

        $text = $result->pods['DecimalApproximation']->subpods[0]->plaintext;

        if ($result->pods['DecimalApproximation']->subpods[0]->plaintext === null
            && $result->pods['Result']->subpods[0]->plaintext !== null) {
            $text = $result->pods['Result']->subpods[0]->plaintext;
        }
//        var_dump($text);
//        $answer = explode(' ', $text);
//
//        $res = [];
//        $res[0] = implode('*', $answer);
//        $res[1] = '-' . implode('*', $answer);
        $text = str_replace(" i", " * i", $text);

        $res[0] = $text;
        $res[1] = '-' . $text;

        if ($text === '0' || $text === '') {
            $res[1] = '';
        }

        if ($result->hasProblems()) {
            $res[0] = 'Некорректные данные';
            $res[1] = '';
        }

        if (substr($res[0], 1, 4) === 'loor') {
            $res[0] = 'sqrt(' . $equation . ')';
            $res[1] = '';
        }

//        echo 'Result success? ' . (string)$result->success . "\n";

//        var_dump($res);

        return $this->render('calculator.twig', [
            'form' => $form->createView(),
            'equation' => $equation,
            'result_1' => $res[0],
            'result_2' => $res[1]
        ]);
    }
}