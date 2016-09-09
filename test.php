<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 2016/9/9
 * Time: 19:17
 */
$db = null;
$word = 'sdada';
$desc = '测试啊啊';
try
{
    $db = new PDO('mysql:host=localhost;dbname=lightnd','root','');
}catch (\Exception $e)
{
    echo $e->getMessage();
}
$db->query('set names utf8;');
$do = $db->prepare('INSERT INTO ld_word (source,target) VALUES (:source,:target)');

$do->bindParam(':source',$word);
$do->bindParam(':target',$desc);
$do->execute();


