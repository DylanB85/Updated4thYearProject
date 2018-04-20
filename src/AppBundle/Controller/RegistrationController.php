<?php
/**
 * Created by PhpStorm.
 * User: dylan
 * Date: 20/11/2017
 * Time: 19:21
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Member;
use AppBundle\Form\MemberType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="registration")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     */
    public function registerAction(Request $request)
    {
        $member = new Member();

        $form = $this->createMemberRegistrationForm($member);


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

        return $this->render('registration/register.html.twig',[
            'registration_form' => $form->createView(),

        ]);
    }

    /**
     * @param Request $request
     * @Route("/registration-form-submission", name="handle_registration_form_submission")
     * @Method("POST")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function handleFormSubmissionAction(Request $request)
    {
        $member = new Member();

        $form = $this->createMemberRegistrationForm($member);

        $form->handleRequest($request);

        if (! $form->isSubmitted() || ! $form->isValid()) {
            return $this->render('registration/register.html.twig',[
                'registration_form' => $form->createView(),

            ]);
        }

        $password = $this->get('security.password_encoder')
            ->encodePassword($member, $member->getPlainPassword());

        $member->setPassword($password);

        $em = $this->getDoctrine()->getManager();


        $em->persist($member);
        $em->flush();

        $token = new UsernamePasswordToken(
            $member,
            $password,
            'main',
            $member->getRoles()
        );

        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));

        $this->addFlash('success', 'You are now registered');

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
    }

    private function createMemberRegistrationForm($member)
    {
        return $this->createForm(MemberType::class, $member,[
            'action'=> $this->generateUrl('handle_registration_form_submission')
        ]);
    }

    /**
     *
     * @Route("/deleteuser", name="deleteuser")
     */
    public function deleteUser(Request $request)
    {

        $user = $this->getUser();
        $member = new Member();

        $password = $this->get('security.password_encoder')
            ->encodePassword($member, $member->getPlainPassword());

        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ARTHRITIS'))
        {

            $token = new UsernamePasswordToken(
                $member,
                $password,
                'main',
                $member->getRoles()
            );

            $this->get('security.token_storage')->setToken(null);

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        elseif($this->container->get('security.authorization_checker')->isGranted('ROLE_CANCER'))
        {

            $token = new UsernamePasswordToken(
                $member,
                $password,
                'main',
                $member->getRoles()
            );

            $this->get('security.token_storage')->setToken(null);

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        elseif($this->container->get('security.authorization_checker')->isGranted('ROLE_ALZHEIMER'))
        {

            $token = new UsernamePasswordToken(
                $member,
                $password,
                'main',
                $member->getRoles()
            );

            $this->get('security.token_storage')->setToken(null);

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        elseif($this->container->get('security.authorization_checker')->isGranted('ROLE_DEPRESSION'))
        {

            $token = new UsernamePasswordToken(
                $member,
                $password,
                'main',
                $member->getRoles()
            );

            $this->get('security.token_storage')->setToken(null);

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        elseif($this->container->get('security.authorization_checker')->isGranted('ROLE_DIABETES'))
        {

            $token = new UsernamePasswordToken(
                $member,
                $password,
                'main',
                $member->getRoles()
            );

            $this->get('security.token_storage')->setToken(null);

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }
    }
}