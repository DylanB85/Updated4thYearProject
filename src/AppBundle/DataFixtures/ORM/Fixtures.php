<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Member;
use AppBundle\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $member = new Member();
        $member
            ->setUsername('BlogTester')
            ->setEmail('BlogTester@gmail.com')
            ->setPassword('Madrid08')
            ->setCategorys('DEPRESSION');

        $manager->persist($member);

        $blogPost = new BlogPost();
        $blogPost
            ->setTitle('First Blog Test')
            ->setSlug('Test Post')
            ->setDescription('This is a test post :)')
            ->setBody('Body of test Post :D')
            ->setMember($member);
        $manager->persist($blogPost);
        $manager->flush();
    }
}