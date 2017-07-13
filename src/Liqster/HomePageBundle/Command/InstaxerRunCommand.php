<?php

namespace Liqster\HomePageBundle\Command;

use Instaxer\Bot\RunLikeRepository;
use Instaxer\Domain\Model\ItemRepository;
use Instaxer\Instaxer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class InstaxerRunCommand
 *
 * @package Liqster\HomePageBundle\Command
 */
class InstaxerRunCommand extends ContainerAwareCommand
{
    /**
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('instaxer:run')
            ->addArgument('account', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \LogicException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        /**
         * @TODO
         * Trzeba w pełni przebudować Commandy.
         * Mają wysyłać request do MQ. I tyle.
         * A okno w API będzie sobie spokojnie czekać na odpowiedzi w postaci raportów dla konkretnych userów.
         * Dużo pracy ale nikłe obciążenie serwera w zamian.
         * Nie wiem na teraz tylko co się stanie, jak serwer MQ nie wykona poprawnie swojego zadania?
         * Chyba będzie musiał dumpować wynik sztuka w sztukę, a to oznacza duży ruch w API.
         *
         * Poza tym, założenie było takie, aby w Liqsterze nie było klasy Instaxer.
         */
        $cacheDir = $this->getContainer()->get('kernel')->getCacheDir();

        $repository = $this->getContainer()->get('doctrine')->getRepository('LiqsterHomePageBundle:Account');
        $account = $repository->find($input->getArgument('account'));

        $fs = new Filesystem();
        $fs->mkdir($cacheDir . '/instaxer/profiles/' . $account->getUser());

        $path = $cacheDir . '/instaxer/profiles/' . $account->getUser() . DIRECTORY_SEPARATOR . $account->getId() . '.dat';

        $instaxer = new Instaxer($path);
        $instaxer->login($account->getName(), $account->getPassword());

        $counter = 8;
        $long = 5;

        $tags = explode(', ', $account->getTagsText());

        $likeRepository = new RunLikeRepository(new ItemRepository($tags), $instaxer, $counter, $long);
        $likeRepository->run();

        $output->writeln('Command result.');
    }
}
