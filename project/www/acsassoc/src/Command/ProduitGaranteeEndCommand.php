<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use App\Repository\ProduitsRepository;
use App\Repository\UsersRepository;
use App\ClassMain\TextEmailProduit;
use Symfony\Component\Mailer\MailerInterface;
use App\ClassMain\ConfigSite;

class ProduitGaranteeEndCommand extends Command
{
    private $produitsRepository;
    private $usersRepository;
    private $mailer;
    protected static $defaultName = 'app:produit:garantee:end';
    protected static $defaultDescription = 'Add a short description for your command';

    
    public function __construct(ProduitsRepository $produitsRepository, UsersRepository $usersRepository, MailerInterface $mailer)
    {
        $this->produitsRepository = $produitsRepository;
        $this->usersRepository = $usersRepository;
        $this->mailer = $mailer;

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
        $produits = $this->produitsRepository->end_garantee();
        $users = $this->usersRepository->findAll();

        $test = new TextEmailProduit($produits);

        $config = new ConfigSite();

        $html = '';
        $text = '';

        if(!empty($test->text()) && !empty($test->html())) {
            $html .= $test->html();
            $text .= $test->text();
        }

        if(!empty($test->text()) && !empty($html)) {
            foreach ($users as $user) {
                $email = (new Email())
                        ->from(new Address($config->getEmail(), $config->getName()))
                        ->to($user->getEmail())
                        ->priority(Email::PRIORITY_HIGH)
                        ->subject('C\'est la fin de la garantie !')
                        ->text($text)
                        ->html($html);
                    $this->mailer->send($email);
            }
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
