<?php

namespace AppBundle\Controller;


use AppBundle\AppBundle;
use AppBundle\Entity\BlogPost;
use AppBundle\Form\EntryFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
USE Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $memberRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $blogPostRepository;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->blogPostRepository = $entityManager->getRepository('AppBundle:BlogPost');
        $this->memberRepository = $entityManager->getRepository('AppBundle:Member');
    }

    /**
     * @Route("/entries", name="entries")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function entriesAction(Request $request)
    {

        $page = 1;

        if($request->get('page')){
            $page = $request->get('page');
        }

        $member =  $this->memberRepository->findOneByUsername($this->getUser()->getUserName());

        $blogPosts=[];

        if($member){
            $blogPosts = $this->blogPostRepository->findByMember($member);
        }

        return $this->render('blog/BlogPosts.html.twig',[
            'blogPosts' => $this->blogPostRepository->findAll()
        ]);
    }

    /**
     * @Route("/create-entry", name="create_entry")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createEntryAction(Request $request)
    {
        $blogPost = new BlogPost();

        $member = $this->memberRepository->findOneByUsername($this->getUser()->getUserName());
        $blogPost->setMember($member);

        $form = $this->createForm(EntryFormType::class, $blogPost);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($blogPost);
            $this->entityManager->flush($blogPost);

            $this->addFlash('success', 'Congratulations! Your post is created');

            return $this->redirectToRoute('entries');
        }

        return $this->render('blog/entryForm.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete-entry/{entryId}", name="delete_entry")
     *
     * @param $entryId
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteEntryAction($entryId)
    {
        $blogPost = $this->blogPostRepository->findOneById($entryId);
        $member = $this->memberRepository->findOneByUsername($this->getUser()->getUserName());

        if (!$blogPost || $member !== $blogPost->getMember()){
            $this->addFlash('error', 'Unable to Remove Blog Post');

            return $this->redirectToRoute('create_entry');
        }

        $this->entityManager->remove($blogPost);
        $this->entityManager->flush();

        $this->addFlash('success', 'Entry was Deleted');

        return $this->redirectToRoute('create_entry');
    }

    /**
     * @Route("/member/{username}", name="member")
     */
    public function memberAction($name)
    {
        $member = $this->memberRepository->findOneByUsername($name);

        if(!$member){
            $this->addFlash('error', 'Unable to find Member');
            return $this->redirectToRoute('entries');
        }

        return $this->render('blog/BlogPosts.html.twig',[
            'member'=> $member
        ]);
    }

    /**
     * @Route("/userentry/{slug}", name="userentry")
     */
    public function entryAction($slug)
    {
        $blogPost = $this->blogPostRepository->findOneBySlug($slug);

        if(!$blogPost){
            $this->addFlash('error', 'Unable to find entry');

            return $this->redirectToRoute('entries');
        }
        return $this->render('blog/entry.html.twig', array(
            'blogPost' => $blogPost
        ));
    }
}