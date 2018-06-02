<?php

namespace TelmiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use TelmiBundle\Entity\Professionnel;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TelmiBundle:Telmi:index.html.twig');
    }

    public function dictionAction()
    {
        return $this->render('TelmiBundle:Azure:diction.html.twig');
    }

    public function addProAction(Request $request)
    {
        $professionnel = new Professionnel();

        $form = $this->get('form.factory')->createBuilder(FormType::class,$professionnel)
            ->add('firstName',      TextType::class)
            ->add('lastName',       TextType::class)
            ->add('matriculeId',    IntegerType::class)
            ->add('workAddress',    TextType::class)
            ->add('Confirmer',      SubmitType::class)
            ->getForm();


        if ($request->isMethod('POST')){
            $form->formHandler($request);

            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($professionnel);
                $em->flush();

                $request->getSession()->getFlashBag()->add('Notice','Profil créé');
                return $this->redirectToRoute('telmi_homepage');
            }
        }

        return $this->render('TelmiBundle:Telmi:pro-1st-login.html.twig',array(
            'form'=> $form->createView(),
        ));

    }
}
