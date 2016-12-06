**Lightnd**英文单词助手
===================

linghtnd 是一个用php写的CLI小程序，用来帮助你学习英语，同时练习打字速度

每次查询，都会做记录，方便以后统计哪个单词经常忘，想不起来。以后还会增加测试模式，

再练习英文的同时，提高打字速度

## install安装

```

* git clone https://github.com/baykier/ligtnd.git

* composer install

```
##数据库配置

1 用mysql workbench 将模型('./data/lightnd.mwb')导入数据库中

2 导入sql文件('./data/lightnd.sql')


### usage基本用法

* 添加单词

```
 bin/lightnd add 

```

* 查询单词

```

bin/lightnd query 

```
* 翻译

```
bin/lightnd translate name
```



