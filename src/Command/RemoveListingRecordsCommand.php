<?php

namespace App\Command;


use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Listing;

class RemoveListingRecordsCommand extends Command
{
    protected static $defaultName = 'app:remove-listing-records';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Remove records from the listing table created more than 3 months ago');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = $this->entityManager->getRepository(Listing::class);

        // Calculate the date 3 months ago
        $threeMonthsAgo = new DateTime();
        $threeMonthsAgo->modify('-3 months');

        // Find listings older than 3 months
        $listings = $repository->createQueryBuilder('l')
            ->where('l.created_at < :date')
            ->setParameter('date', $threeMonthsAgo)
            ->getQuery()
            ->getResult();

        foreach ($listings as $listing) {
            $this->entityManager->remove($listing);
        }

        $this->entityManager->flush();

        $output->writeln('Records created more than 3 months ago have been removed from the listing table.');

        return Command::SUCCESS;
    }
}