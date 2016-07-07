<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com> 
 * Date: 16-7-8
 * Time: 上午11:12
 */
namespace Baykier\Linghtnd;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Test extends Command
{
    protected function configure()
    {
        $this
            ->setName('test')
            ->setDescription('test your english words and keyboard')
            ->addArgument(
                'word',
                InputArgument::OPTIONAL,
                'the words you should input'
            );
    }

    protected function execute(InputInterface $input,OutputInterface $output)
    {
        $word = $input->getArgument('word');

        if($word)
        {
            $text = ' Your input words is :<info>' . $word . '!</info>';
        }
        else
        {
            $text = ' <error>You input nothing!</error>';
        }

        $output->writeln($text);
    }
}