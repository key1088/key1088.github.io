title: /bin/rm cannot remove libtoolT No such file or directory
categories: [Linux]
tags: []
date: 2011-03-24 14:55:00
---
<p>在 CentOS 5.4 下编译安装MySQL时出错：</p><p>/bin/rm: cannot remove `<a href="http://www.yanghengfei.com/tag/libtoolt/">libtoolt</a>': No such file or directory</p><p>网上搜寻后，解决问题。具体方法是：</p><p>在执行./configure 之前，先执行：</p><p># autoreconf --force --install<br /># libtoolize --automake --force<br /># automake --force --add-missing<br /># ./configure --prefix=/usr/local/mysql/ --datadir=/var/lib/mysql</p><p>这次，不再出错了，问题解决。</p><p>　# autoreconf --force --install ##更新生成的配置文件（--force<strong>:</strong>consider all files obsolete）<br /><br />　　# libtoolize --automake --force ##libtoolize 提供了一种标准方式来将libtool支持加入到一个软件包。<br /><br />　　# automake --force --add-missing ##Automake是一个从文件`Makefile.am'自动生成`Makefile.in' 的工具。</p>