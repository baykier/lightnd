<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 2016/10/31
 * Time: 9:34
 */

namespace Baykier\Lightnd;

use Slim\PDO\Database;

class Db extends Database {

   public function __construct($dsn, $usr, $pwd, array $options)
   {
       parent::__construct($dsn, $usr, $pwd, $options);
   }
}