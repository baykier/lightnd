<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com> 
 * Date: 16-7-8
 * Time: 上午11:12
 */
namespace Baykier\Lightnd;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;
use Baykier\Lightnd\BaseCommand;

class QueryCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('query')
            ->setDescription('查询单词的含义及说明')
            ->addArgument(
                'word',
                InputArgument::OPTIONAL,
                '要查询的单词'
            );
    }

    protected function interact(InputInterface $input,OutputInterface $output)
    {
        $word = $input->getArgument('word');
        $helper = new QuestionHelper();
        //获取单词
        if (empty($word))
        {
            $wordAnswer = '';
            while (!$wordAnswer)
            {
                $wordAnswer = $helper->ask($input,$output,new Question("请输入要查询的单词:\n ",''));
            }
            $input->setArgument('word',$wordAnswer);
        }
    }

    protected function execute(InputInterface $input,OutputInterface $output)
    {
        $word = $input->getArgument('word');
        $result = $this->findWord($word);
        if (!$result)
        {
            $output->writeln(sprintf("单词：%s没有查到，请先添加 [lightnd add %s]",$word));
        }else
        {
            $output->writeln(sprintf("单词：%s含义如下:\n",$word));
            $output->writeln($result['desc']);
            $this->addWordQueryCount($result['word'],$result['query_count']);
        }
    }
}