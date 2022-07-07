<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\ProduitsRepository;

class ProduitGaranteeEndCommand extends Command
{
    private $ProduitsRepository;
    protected static $defaultName = 'app:produit:garantee:end';
    protected static $defaultDescription = 'Add a short description for your command';

    
    public function __construct(ProduitsRepository $ProduitsRepository)
    {
        $this->ProduitsRepository = $ProduitsRepository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        $produits = $this->ProduitsRepository->end_garantee();

        foreach ($produits as $produit) {
            $io->note(sprintf('produit name: %s', $produit->getName()));
            $io->note(sprintf('produit garantie: %s', $produit->getGuaranteeAt()->format('Y-m-d H:i:s')));
            $io->note(sprintf('nom: %s', $produit->getUsers()->getName()));
            $io->note(sprintf('prénom: %s', $produit->getUsers()->getFirstname()));
            $io->note(sprintf('email: %s', $produit->getUsers()->getEmail()));
        }

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
