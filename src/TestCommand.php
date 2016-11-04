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
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Question\Question;

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
            ->addOption('no-show-time','-t',InputOption::VALUE_NONE,'是否记录打字时间',null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //是否记录测试时间
        $logTime = $input->getOption('no-show-time');
        $logTime = !$logTime ? true : false;
        $words = $this->getWords();
        if ($words)
        {
            //显示前10个 查询次数最多的单词
            $table = new Table($output);
            $table->setHeaders(array('单词','释义','查询次数'));
            foreach ($words as $word)
            {
                $table->addRow(array($word['word'],$word['desc'],$word['query_count']));
            }
            $table->render();
            //开始记录打字
            $testStart = time();
            $successCount = 0 ;
            $space = 10;
            $quest = new QuestionHelper();
            $processBar = new ProgressBar($output,self::DEFAULT_WORD_NUMBER * $space);
            $output->writeln("开始测试..\n");
            $processBar->setOverwrite(true);
            $processBar->display();
            $output->writeln("\n");
            foreach ($words as $word)
            {
                $typeWord = '';
                while ($typeWord != $word['word'])
                {
                    $typeWord = $quest->ask($input,$output,new Question(sprintf("%s:\n",$word['word']),''));
                }
                $successCount++;
                $processBar->advance($space);
                $output->writeln("\n");
            }
            $processBar->finish();
            $output->writeln("\n测试完成");
            if ($logTime)
            {
                $output->writeln(sprintf("测试共用时:%s 秒",time() - $testStart));
            }

        }
        else
        {
            $output->writeln("您的词库还未存储任何单词，请先添加 [lightnd add]");
        }

    }
}
