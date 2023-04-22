title: mysql cpu占用高的问题
categories: [Mysql]
tags: []
date: 2011-10-14 14:43:00
---
今天发现一台近期MYSQL机器CPU占用很高。
进入mysql模式
show processlist;
工作量也不大啊，就几条语句。
copy tmp table。。。。。
观察了一个
写临时的表的和GROUP BY语句很多
解决方案：添加临时表大小或者优化sql语句
增加临时表MYSQL最后增加 tmp_table_size值
默认tmp_table_size 32M
tmp_table_size = 128M
重启，负载好多了
<br />