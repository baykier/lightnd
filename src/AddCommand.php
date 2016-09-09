<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 2016/9/9
 * Time: 14:12
 */
namespace Baykier\Lightnd;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Spot\Locator;
use Baykier\Lightnd\Orm\Config;

class AddCommand extends Command
{
    protected function configure()
    {
        $this->setName('add')
            ->setDescription('add new words to the store !')
            ->addArgument('word',InputArgument::REQUIRED,'The word you wants to save!')
            ->addArgument('desc',InputArgument::REQUIRED,'The word description');
    }

    protected function execute(InputInterface $input,OutputInterface $output)
    {
        $word = $input->getArgument('word');
        $desc = $input->getArgument('desc');
        if($word)
        {
            $text = ' Your input words is :<info>' . $word . '!</info>';
        }
        else
        {
            $text = ' <error>You input nothing!</error>';
        }
        $output->writeln($text);
        $output->writeln('The Desc is:' . $desc);
        try
        {
            $config = Config::getConfig();
            $spot = new Locator($config);
            $mapper = $spot->mapper('\Baykier\Lightnd\Orm\Entity\Word');
            if (!$mapper->addWord($word,$desc))
            {
                echo 'Failed save';
            }

        }catch (\Exception $e)
        {
            echo $e->getMessage();
            echo PHP_EOL;
        }
    }
}