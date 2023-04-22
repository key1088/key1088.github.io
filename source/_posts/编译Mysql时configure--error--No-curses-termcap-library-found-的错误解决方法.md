title: 编译Mysql时configure- error No curses/termcap library found 的错误解决方法
categories: [Mysql]
tags: []
date: 2011-07-14 22:48:00
---
编译Mysql时configure: error: No curses/termcap library found 的错误解决方法
在编译Mysql时<br />./configure –prefix=DIR
，如果出现了以下错误：<br />……<br />checking for tgetent in -ltermcap… no<br />checking for termcap functions library… configure: error: No curses/termcap library found
debian：
说明 curses/termcap 库没有安装<br />apt-cache search curses | grep lib
安装 libncurses5-dev ，然后重新运行配置<br />apt-get install libncurses5-dev
centos：&nbsp;
光盘里面有libtermcap包，安装就OK。