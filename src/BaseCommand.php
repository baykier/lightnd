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
    /**
     * @配置参数
     * @var array
     */
    protected static $config = array();

    const DB_REQUIRED = 1;

    const DB_NONE = 0;

    protected static $dbLevel = self::DB_NONE;

    public function __construct($name = null,$config = null)
    {
        parent::__construct($name);



        if (null == $config && file_exists(ROOT_PATH . '/config.php'))
        {

            $configFile = ROOT_PATH . '/config.php';
            require $configFile;
            self::$config = isset($config) ? $config : array();
        }

    }



    /* var $db \Baykier\Lightnd\Db */
    protected $db = null;

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $config = self::$config;

        if (!isset($config['db']['default']) && self::$dbLevel == self::DB_REQUIRED) {
            throw new \Exception(sprintf("You have not set the db config command:%s", $this->getName()));
        }else{
            $output->writeln('你的程序配置<config.php>不存在');
            $output->writeln('不能使用下面的命令:');
            $output->writeln('lightnd query');
            $output->writeln('lightnd add');
            $output->writeln('lightnd test');
            exit(1);
        }
        $db = $config['db']['default'];

        try {
            $this->db = new Db(sprintf("%s:host=%s;dbname=%s", $db['driver'], $db['host'], $db['dbname']), $db['user'], $db['password'],
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }

    }

    /**
     * @添加一条记录
     * @param string $word
     * @param string $desc
     */
    protected function addWord($word = '', $desc = '')
    {
        if (empty($word) || empty($desc)) {
            throw new \Exception(sprintf("word:%s 或者desc:%s 不能为空", $word, $desc));
        }
        $insert = $this->db->insert(array('`word`', '`desc`', '`created`'))
            ->into('ln_words')
            ->values(array($word, $desc, time()));
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
        if (empty($word)) {
            throw new \Exception(sprintf("要查询的单词不能为空"));
        }
        $select = $this->db->select()
            ->from('ln_words')
            ->where('word', '=', $word);
        $stmp = $select->execute();
        return $stmp->fetch();
    }

    /**
     * @更新单词含义
     * @param $word
     * @param $desc
     * @return mixed
     * @throws \Exception
     */
    public function resetWord($word, $desc)
    {
        if (empty($word) || empty($desc)) {
            throw new \Exception(sprintf("word:%s 或者desc:%s 不能为空", $word, $desc));
        }
        $updateStm =  $this->db->update(array('`desc`' => $desc))
            ->table('ln_words')
            ->where('word', '=', $word);
        return $updateStm->execute();
    }

    /**
     * @添加查词计数
     * @param $word
     * @param int $count
     * @return bool
     * @throws \Exception
     */
    protected function addWordQueryCount($word, $count = 0)
    {
        $count = $count >= 0 ? (int)$count + 1 : 1;
        $update = $this->db->update(array('query_count' => $count))
            ->table('ln_words')
            ->where('word', '=', $word);
        return $update->execute() !== false;
    }

    /**
     * @获取
     * @param int $number
     * @return mixed
     * @throws \Exception
     */
    protected function getWords($number = TestCommand::DEFAULT_WORD_NUMBER,$offset = 0)
    {
        try
        {
            $query = $this->db->select()
                ->from('ln_words')
                ->orderBy('query_count','DESC')
                ->limit($number,$offset);
            $smtp =  $query->execute();
            return $smtp->fetchAll();
        }catch (\PDOException $e)
        {
            throw new \Exception($e->getMessage(),$e->getCode());
        }
    }
}