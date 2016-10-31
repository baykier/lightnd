<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 2016/10/30
 * Time: 15:59
 */
namespace Baykier\Lightnd;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command
{
    /* var $db \Baykier\Lightnd\Db */
    protected $db = null;

    protected function initialize(InputInterface $input,OutputInterface $output)
    {
        require_once ROOT_PATH . '/config.php';
        if (!isset($config['db']['default']))
        {
            throw new \Exception(sprintf("You have not set the db config command:%s",$this->getName()));
        }
        $db = $config['db']['default'];

        try
        {
            $this->db = new Db(sprintf("%s:host=%s;dbname=%s",$db['driver'],$db['host'],$db['dbname']),$db['user'],$db['password'],
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        }
        catch (\Exception $e)
        {
            throw new \Exception($this->db->errorInfo(),$this->db->errorCode());
        }

    }

    /**
     * @添加一条记录
     * @param string $word
     * @param string $desc
     */
    protected function addWord($word = '',$desc = '')
    {
        if (empty($word) || empty($desc))
        {
            throw new \Exception(sprintf("word:%s 或者desc:%s 不能为空",$word,$desc));
        }
        $insert = $this->db->insert(array('word','desc','created'))
                            ->into('ln_words')
                            ->values(array($word,$desc,time()));
        return $insert->execute() !== false;
    }

    /**
     * @获取查询结果
     * @param $word
     * @return mixed
     * @throws \Exception
     */
    protected function findWord($word)
    {
        if (empty($word))
        {
            throw new \Exception(sprintf("要查询的单词不能为空"));
        }
        $select = $this->db->select()
                            ->from('ln_words')
                            ->where('word','=',$word);
        $stmp = $select->execute();
        return $stmp->fetch();
    }
}