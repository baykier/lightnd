<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 2016/9/9
 * Time: 14:12
 */
namespace Baykier\Lightnd;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class AddCommand extends BaseCommand
{
    /**
     * @是否是新单词
     * @var bool
     */
    protected $isNew = true;

    protected $isRewrite = false;

    protected function configure()
    {
        $this->setName('add')
            ->setDescription('添加新的英文单词到词库 !')
            ->addArgument('word',InputArgument::OPTIONAL,'你想要存储的单词!')
            ->addArgument('desc',InputArgument::OPTIONAL,'单词释义，描述')
            ->addOption('reset','-r',InputOption::VALUE_OPTIONAL,'是否强制新增（若存在则强制更新）');
    }

    protected function interact(InputInterface $input,OutputInterface $output)
    {
        $input->setInteractive(true);
        $word = $input->getArgument('word');
        $reset = $input->getOption('reset');
        $helper = new QuestionHelper();
        //获取单词
        if (empty($word))
        {
            $wordAnswer = '';
            while (!$wordAnswer)
            {
                $wordAnswer = $helper->ask($input,$output,new Question("请输入要新增的单词:\n ",''));
            }
            $input->setArgument('word',$wordAnswer);
        }
        $find = $this->findWord($input->getArgument('word'));
        $overWrite = !$reset ? true : false;//是否 存在--reset -r 强制新增
        if ($find && !$overWrite)
        {
            $overWrite = $helper->ask($input,$output,new ConfirmationQuestion(
                sprintf("单词:%s 已经存在，是否重新修改释义?[y/n]",$word),$overWrite));
        }
        //如果不需要重新修改 提示输入新单词
        if($find && !$overWrite)
        {
            //清空单词
            $input->setArgument('word','');
            $this->interact($input,$output);
        }
        //获取说明
        $desc = $input->getArgument('desc');
        if (empty($desc))
        {
            $descAnswer = '';
            while (!$descAnswer)
            {
                $descAnswer = $helper->ask($input,$output,
                    new Question(sprintf("请输入单词:%s的释义或说明:\n",$word),''));
                $input->setArgument('desc',$descAnswer);
            }
        }
        if ($find)
        {
            $this->isNew = false;
        }
        if ($overWrite)
        {
            $this->isRewrite = true;
        }

    }

    protected function execute(InputInterface $input,OutputInterface $output)
    {
        $word = $input->getArgument('word');
        $desc = $input->getArgument('desc');
        $output->writeln(sprintf("你输入的单词:%s,\n 描述为:%s\n",$word,$desc));
        try
        {
            if ($this->isNew)
            {
                $result = $this->addWord($word,$desc);
            }
            elseif (!$this->isNew && $this->isRewrite)
            {
                $result = $this->resetWord($word,$desc);
            }
        }catch (\Exception $e)
        {
            $output->writeln($e->getMessage());
        }
    }
}