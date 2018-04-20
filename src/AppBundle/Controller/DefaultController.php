<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ARTHRITIS'))
        {
            return $this->redirectToRoute('arthritis');
        }

        else if ($this->container->get('security.authorization_checker')->isGranted('ROLE_CANCER'))
        {
            return $this->redirectToRoute('cancer');
        }

        else if ($this->container->get('security.authorization_checker')->isGranted('ROLE_DIABETES'))
        {
            return $this->redirectToRoute('diabetes');
        }

        else if ($this->container->get('security.authorization_checker')->isGranted('ROLE_DEPRESSION'))
        {
            return $this->redirectToRoute('depression');
        }

        else if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ALZHEIMER'))
        {
            return $this->redirectToRoute('alzheimers');
        }

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
