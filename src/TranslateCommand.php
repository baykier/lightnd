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
use GuzzleHttp\Client;

class TranslateCommand extends BaseCommand
{
    /**
     * @是否是新单词
     * @var bool
     */
    protected $isNew = true;

    /**
     * @是否新单词
     * @var bool
     */
    protected $isRewrite = false;

    protected $word = '';
    protected $desc = '';

    protected $source = '';
    protected $target = '';

    protected $translate = null;

    protected function configure()
    {
        $this->setName('translate')
            ->setAliases(array('tla'))
            ->setDescription('翻译单词 !')
            ->addArgument('word',InputArgument::OPTIONAL,'要翻译的单词');

    }

    protected function interact(InputInterface $input,OutputInterface $output)
    {
        $input->setInteractive(true);
        $word = $input->getArgument('word');
        $helper = new QuestionHelper();
        //获取单词
        if (empty($word))
        {
            $wordAnswer = '';
            while (!$wordAnswer)
            {
                $wordAnswer = $helper->ask($input,$output,new Question("请输入要翻译的单词:\n ",''));
            }
            $input->setArgument('word',$wordAnswer);
        }
        $word = $input->getArgument('word');
        // config translate

        $config = self::$config;


        if (!isset($config['youdao']) && empty($config['youdao']))
        {
            throw new \Exception("翻译配置不存在，请先配置");
        }
        $translate = new Translate($config['youdao']['key'],$config['youdao']['keyfrom']);

        $this ->desc = $translate->translate($word);

    }

    protected function execute(InputInterface $input,OutputInterface $output)
    {
        $word = trim($input->getArgument('word'));
        $output->writeln(sprintf("单词:%s的翻译如下:\n",$word));
        $output->writeln($this->desc);

    }
}