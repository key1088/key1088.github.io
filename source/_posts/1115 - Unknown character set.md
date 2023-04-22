title: 1115 - Unknown character set
categories: [Linux]
tags: []
date: 2011-03-29 08:43:00
---
<p>我安装的mysql版本为5.1.47.安装后导入数据，有一条语句是这样写的、</p><p>select branchId,DepName from T_SC_Department order by convert(DepName using gbk)&nbsp;&nbsp;&nbsp;&nbsp;</p><p>提示：</p><p>1115 - Unknown character set: 'gbk</p><p>不支持，gbk的格式。只能重新编译了，语句是固定的。</p><p>我第一次编译的时候选项是这样，有GBK的选项：</p><p>./configure --prefix=/usr/local/mysql&nbsp; --datadir=/videodata/mysqldata/data --with-xcharset=all&nbsp; --with-charset=gbk --with-charset=utf8</p><p>编译后，就是不支持GBK，郁闷死了，看./configure --help 没有--with-xcharset选项，但编译没有错误提示。</p><p>修改选项，如下：</p><p>./configure --prefix=/usr/local/mysql&nbsp; --datadir=/videodata/mysqldata/data --with-extra-charsets=all&nbsp; --with-charset=gbk --with-charset=utf8</p><p>编译后，支持GBK，查询语言胜利通过。</p><p>&nbsp;</p>