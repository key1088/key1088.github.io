title: mysql远程安全设置
categories: [网络安全]
tags: []
date: 2013-04-13 12:43:02
---
最近又出了mysql远程漏洞,简单说一下mysql远程安全的设置小技巧。
1.关闭远程连接
mysql默认是开启3306端口,默认也不允许远程连接的。
<pre>
mysql> select host,user from user;
+-----------+--------------+
| host      | user         |
+-----------+--------------+
| 127.0.0.1 | root         |
| localhost | root         |
+-----------+--------------+
2 rows in set (0.00 sec)
</pre>
2.如果不使用端口通信通信的话,建议关闭监听端口,使用socket通信
在mysql配置文件中my.cnf中[mysqld]中
添加skip-networking
如果本地使用端口通信的话,或者使用局域网通信的话,建议只监听内网端口
在mysql配置文件中my.cnf中[mysqld]中
添加bind-address=127.0.0.1
或者添加bind-address=内网地址
3.不建议使用远程端口,如果真的使用远程或者远程主从,修改你的端口和授权地址。
修改端口
在mysql配置文件中my.cnf中[mysqld]中
添加port=12345
添加授权的话，先为数据库创建一个用户test,修改授权ip即可,具体权限可以根据应用设置。
<pre>
mysql>update user set host = '1.1.1.1' where user = 'test';
mysql> select host,user from user where user='test';
+-----------+--------------+
| host      | user         |
+-----------+--------------+
| 1.1.1.1   | test         |
+-----------+--------------+
1 row in set (0.00 sec)
</pre>