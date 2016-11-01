<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 2016/11/1
 * Time: 9:04
 */
namespace Baykier\Lightnd;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Helper\QuestionHelper;

class TestCommand extends BaseCommand
{
    /**
     * @默认的显示数量
     */
    const DEFAULT_WORD_NUMBER = 10;

    protected function Configure()
    {
        $this->setName('test')
            ->setDescription('测试打字速度')
            ->addArgument('number',InputArgument::OPTIONAL,'每次打字显示的数量',10)
            ->addArgument('level',InputArgument::OPTIONAL,'级别设置',1)
            ->addOption('log-time','-lt',InputOption::VALUE_OPTIONAL,'是否记录打字时间',null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //是否记录测试时间
        $logTime = $input->getOption('log-time');
        $logTime = !$logTime ? true : false;

        $testStart = time();

        $words = $this->getWords();


    }
}
