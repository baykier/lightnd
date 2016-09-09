<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com> 
 * Date: 16-7-8
 * Time: 上午11:12
 */
namespace Baykier\Lightnd;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class QueryCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('query')
            ->setDescription('query your english words from the store')
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