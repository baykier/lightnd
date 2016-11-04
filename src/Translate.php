<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 16-11-4
 * Time: 上午10:07
 */

namespace Baykier\Lightnd;


class Translate {

    const ONLY_DICT = 'dict';

    const ONLY_TRANSLATE = 'translate';

    protected $key = null;

    protected $keyfrom = null;

    protected $docType = 'json';

    protected $apiVersion = '1.1';

    protected $type = 'data';

    protected $only = self::ONLY_DICT;

    protected $url = 'http://fanyi.youdao.com/openapi.do';


    protected $errorCode  = array(
        '0' => '正常',
        '20' => '要翻译的文本过长',
        '30' => '无法进行有效的翻译',
        '40' => '不支持的语言类型',
        '50' => '无效的key',
        '60' => ' 无词典结果，仅在获取词典结果生效',
    );

    public function __construct($key = null,$keyfrom = null)
    {
        if (null !== $key)
        {
            $this->key = $key;
        }
        if (null !== $keyfrom)
        {
            $this->keyfrom = $keyfrom;
        }
    }

    public function translate($word = '')
    {
        $urlParams = http_build_query(array(
            'keyfrom' => $this->keyfrom,
            'key' => $this->key,
            'type' => $this->type,
            'doctype' => $this->docType,
            'only' => $this->only,
            'version' => $this->apiVersion,
            'q' => $word,
        ));

        $url = sprintf("%s?%s",$this->url,$urlParams);

        $result = file_get_contents($url);


        if (is_string($result) && false !== ($result = json_decode($result,true)))
        {
            $code = isset($result['errorCode']) ? $result['errorCode'] : -1;
            $msg = isset($this->errorCode[$code]) ? $this->errorCode[$code] : '未知错位';

            if ($code == 0)
            {
                return $result['basic']['explains'];
            }
            throw new \Exception(sprintf("查询单词:%s错误code:%s,msg:%s",$word,$code,$msg),503);

        }
        throw new \Exception(sprintf("查询单词:%s出现错误",$word),503);
    }
}