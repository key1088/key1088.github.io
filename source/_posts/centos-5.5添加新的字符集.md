title: centos 5.5添加新的字符集
categories: [Linux]
tags: []
date: 2011-11-28 17:57:00
---
<p>1.下载相应的字符集。</p><p>2.在服务器上，进入/usr/share/fonts/目录下&nbsp; </p><p>新建一个目录，随便了。myfont</p><p>3。复制字符集到myfont目录。</p><p>进入myfont</p><p>运行下边的命令更新字符集。<br />mkfontscale<br />mkfontdir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br />fc-cache</p><p>cat fonts.dir 看看支持的字符。</p><p>4.如果要修改系统的话，就LANG=‘字符集’</p><p>&nbsp;</p>