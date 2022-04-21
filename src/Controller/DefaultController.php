<?php
/**
 * Created by PhpStorm.
 * User: oleksandrarhat
 * Date: 4/13/22
 * Time: 9:15 AM
 */

namespace App\Controller;


use App\Repository\HistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private $repo;

    function __construct(HistoryRepository $repo)
    {
        $this->repo = $repo;
    }

    function getFormBuilder(){
        return $this->createFormBuilder(null, [
            'method' => 'get'
        ])
            ->add(
                'place',
                ChoiceType::class, [
                'choices' => $this->repo->findPlaces(),
                'label' => false,
                'placeholder' => 'Local',
                'attr' => ['class' => 'form-control'],
                'choice_label' => function ($place) {
                    return $place;
                },
                'choice_attr' => function ($place) {
                    return empty($place) ? ['disabled' => true] : [];
                },
                'required' => false
            ])
            ->add(
                'from',
                DateType::class, [
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'placeholder' => 'Od',
                'label' => false,
                'attr' => ['class' => 'form-control datepicker', 'placeholder' => 'Ot'],
                'required' => false
            ])
            ->add(
                'to',
                DateType::class, [
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'label' => false,
                'attr' => ['class' => 'form-control datepicker', 'placeholder' => 'Do'],
                'required' => false
            ])
            ->add('submit', SubmitType::class, ['label' => 'Zatwierdź']);
    }

    /**
     * @Route("/default", name="default")
     */
    public function index(Request $request)
    {

        $form = $this->getFormBuilder()->getForm();
        $form->handleRequest($request);

        $data = $this->repo->findData($form->getData());

        return $this->render('index.html.twig', ['data' => $data, 'form' => $form->createView()]);
    }

}