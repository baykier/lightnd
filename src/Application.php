<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 2016/11/1
 * Time: 9:00
 */
namespace Baykier\Lightnd;

use Symfony\Component\Console\Application as AbstractApplication;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Application extends AbstractApplication
{
    public function __construct($name = 'lightnd',$version = '1.0')
    {
        parent::__construct($name,$version);
    }

    protected function getDefaultInputDefinition()
    {
        return new InputDefinition(array(
            new InputArgument('command', InputArgument::REQUIRED, '要运行的命令'),

            new InputOption('--help', '-h', InputOption::VALUE_NONE, '显示帮助信息'),
            new InputOption('--quiet', '-q', InputOption::VALUE_NONE, '不输出任何信息'),
            //new InputOption('--verbose', '-v|vv|vvv', InputOption::VALUE_NONE, 'Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug'),
            new InputOption('--version', '-V', InputOption::VALUE_NONE, '显示版本'),
            //new InputOption('--ansi', '', InputOption::VALUE_NONE, 'Force ANSI output'),
            //new InputOption('--no-ansi', '', InputOption::VALUE_NONE, 'Disable ANSI output'),
            new InputOption('--no-interaction', '-n', InputOption::VALUE_NONE, '非交互模式'),
        ));
    }
}
