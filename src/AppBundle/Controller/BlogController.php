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
     * @Route("/blogs", name="blogs")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogAction(Request $request)
    {

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
     * @Route("/blogs/create-entry", name="create_entry")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createBlogEntryAction(Request $request)
    {
        $blogPost = new BlogPost();

        $member = $this->memberRepository->findOneByUsername($this->getUser()->getUserName());
        $blogPost->setMember($member);

        $form = $this->createForm(EntryFormType::class, $blogPost);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($blogPost);
            $this->entityManager->flush($blogPost);

            $this->addFlash('success', 'Congratulations! You have created a new post!');

            return $this->redirectToRoute('blogs');
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
    public function deleteBlogEntryAction($entryId)
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
     * @Route("/blogs/userentry/{slug}", name="userentry")
     */
    public function slugAction($slug)
    {
        $blogPost = $this->blogPostRepository->findOneBySlug($slug);

        if(!$blogPost){
            $this->addFlash('error', 'Unable to find entry');

            return $this->redirectToRoute('blogs');
        }
        return $this->render('blog/entry.html.twig', array(
            'blogPost' => $blogPost
        ));
    }
}