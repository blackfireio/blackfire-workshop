<?php

namespace AppBundle\Command;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\Post;
use AppBundle\Entity\Comment;
use Faker;

class GenerateContentCommand extends ContainerAwareCommand
{
    /**
     * @var ObjectManager
     */
    private $em;

    protected function configure()
    {
        $this
            ->setName('app:generate-content')
            ->setDescription('Generate some random content')
            ->addArgument('max-results', InputArgument::OPTIONAL, 'Limits the number of post generated', 50)
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->em = $this->getContainer()->get('doctrine')->getManager();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $maxResults = $input->getArgument('max-results');

        $emails = $this->em->getRepository('AppBundle:User')
            ->createQueryBuilder('u')
            ->select('u.email')
            ->getQuery()
            ->getScalarResult();

        array_walk($emails, function (&$result) {
            $result = $result['email'];
        });

        $generator = Faker\Factory::create('en_GB');

        for ($i = 0; $i < 15; ++$i) {
            $emails[] = $generator->email;
        }

        $populator = new Faker\ORM\Doctrine\Populator($generator, $this->em);
        $populator->addEntity(Post::class, $maxResults, [
            'authorEmail' => function () use ($generator, $emails) { return $generator->randomElement($emails); },
            'slug' => function () use ($generator) { return $generator->slug(4); },
        ]);
        $populator->addEntity(Comment::class, $maxResults * 10);
        $populator->execute();
    }
}
