<?php
/**
 * Created by PhpStorm.
 * User: dylan
 * Date: 19/11/2017
 * Time: 16:42
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class IllnessController extends Controller
{

    /**
     * @Route("/alzheimers", name="alzheimers")
     */
    public function alzheimersAction()
    {
        return $this->render('illness/alzheimers.html.twig',[
        ]);
    }

    /**
     * @Route("/alzheimers/alzheimersinformation", name="alzheimersinformation")
     */
    public function alzheimersInformationAction()
    {
        return $this->render('alzheimersInformationPages/alzheimerCareExercises.html.twig',[
        ]);
    }

    /**
     * @Route("/alzheimers/alzheimerssociety", name="alzheimerssociety")
     */
    public function alzheimersSocietyAction()
    {
        return $this->render('alzheimersInformationPages/alzheimerSocietyOfIreland.html.twig',[
        ]);
    }

    /**
     * @Route("/alzheimers/alzheimersusefulinformation", name="alzheimersuseful")
     */
    public function alzheimersUsefulAction()
    {
        return $this->render('alzheimersInformationPages/alzheimerUseful.html.twig',[
        ]);
    }

    /**
     * @Route("/arthritis", name="arthritis")
     */
    public function arthritisAction()
    {
        return $this->render('illness/arthritis.html.twig',[
        ]);
    }

    /**
     * @Route("/arthritis/arthritisinformation", name="arthritisinformation")
     */
    public function arthritisInformationAction()
    {
        return $this->render('arthritisInformationPages/arthritisCareExercises.html.twig',[
        ]);
    }

    /**
     * @Route("/arthritis/arthritisireland", name="arthritisireland")
     */
    public function arthritisIrelandAction()
    {
        return $this->render('arthritisInformationPages/arthritisIreland.html.twig',[
        ]);
    }

    /**
     * @Route("/arthritis/arthritisusefulinformation", name="arthritisuseful")
     */
    public function arthritisUsefulAction()
    {
        return $this->render('arthritisInformationPages/arthritisUseful.html.twig',[
        ]);
    }

    /**
     * @Route("/cancer", name="cancer")
     */
    public function cancerAction()
    {
        return $this->render('illness/cancer.html.twig',[
        ]);
    }

    /**
     * @Route("/cancer/cancerinformation", name="cancerinformation")
     */
    public function cancerInformationAction()
    {
        return $this->render('cancerInformationPages/cancerCareExercises.html.twig',[
        ]);
    }

    /**
     * @Route("/cancer/cancersocietyinfo", name="cancersociety")
     */
    public function cancerSocietyAction()
    {
        return $this->render('cancerInformationPages/irishCancerSociety.html.twig',[
        ]);
    }

    /**
     * @Route("/cancer/cancerusefulinformation", name="canceruseful")
     */
    public function cancerUsefulAction()
    {
        return $this->render('cancerInformationPages/cancerUseful.html.twig',[
        ]);
    }

    /**
     * @Route("/depression", name="depression")
     */
    public function depressionAction()
    {
        return $this->render('illness/depression.html.twig',[
        ]);
    }

    /**
     * @Route("/depression/depressioninformation", name="depressioninformation")
     */
    public function depressionInformationAction(){

        return $this->render('depressionInformationPages/depressionCareExercises.html.twig',[
        ]);
    }

    /**
     * @Route("/depression/mentalhealthireland", name="mentalhealthireland")
     */
    public function mentalHealthIrelandAction()
    {
        return $this->render('depressionInformationPages/mentalHealthIreland.html.twig',[
        ]);
    }

    /**
     * @Route("/depression/depressionusefulinformation", name="depressionuseful")
     */
    public function depressionUsefulAction()
    {
        return $this->render('depressionInformationPages/depressionUseful.html.twig',[
        ]);
    }

    /**
     * @Route("/diabetes", name="diabetes")
     */
    public function diabetesAction()
    {
        return $this->render('illness/diabetes.html.twig',[
        ]);
    }

    /**
     * @Route("/diabetes/diabetesinformation", name="diabetesinformation")
     */
    public function diabetesInformationAction()
    {
        return $this->render('diabetesInformationPages/diabetesCareExercises.html.twig',[
        ]);
    }

    /**
     * @Route("/diabetes/diabetesireland", name="diabetesireland")
     */
    public function diabetesIrelandAction()
    {
        return $this->render('diabetesInformationPages/diabetesIreland.html.twig',[
        ]);
    }

    /**
     * @Route("/diabetes/diabetesusefulinformation", name="diabetesuseful")
     */
    public function diabetesUsefulAction()
    {
        return $this->render('diabetesInformationPages/diabetesIseful.html.twig',[
        ]);
    }
}