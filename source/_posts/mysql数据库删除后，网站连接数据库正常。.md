title: mysql数据库删除后，网站连接数据库正常。
categories: [Mysql]
tags: []
date: 2011-09-06 17:34:00
---
今天，（vmware里的）网站程序怎么也连接不上了，提示连接不上数据库，之前好好的，没有做什么操作啊。
密码是正确的，终端能连接上，就是php连接不上，php也没有什么问题啊。郁闷死了。怒之，删mysql数据库，重建。
rm -rf /usr/local/mysql/var/mysql&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #直接删除的数据
mysql_install_db --user=mysql --basedir=/usr/local/mysql --datadir=/usr/local/mysql/var
mysql -u root -p&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #进入mysql模式
show databases；&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #有其他数据库
可笑的是，现在网站能访问了，网站连接数据库的用户密码没有修改。
快速进入mysql表
use mysql
select user，host，password from user；&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #确定是创建的，没有其他的用户。
mysql -u 任意用户 -p&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #任意用户，空密码能进入
mysqladmin -uroot password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #初始化密码，提示连接localhost 失败，0.0.0.0:3306正常监听。
看mysql日志正常，有点小郁闷。没有初始化密码前，不需要验证码。只要有对应的数据库就可以吗。晕。
&nbsp;