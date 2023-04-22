title: 添加 swap文件问题
categories: [Linux]
tags: []
date: 2011-03-30 16:17:00
---
<p>1、必须为超级用户<br />2、/dd if=/dev/zero of=swapfile bs=1024 count=2048<br />3、mkswap swapfile&nbsp;&nbsp;    #初始化swapfile<br />4、swapon swapfile&nbsp; #挂载<br />5、swapon -s&nbsp; #查看状态<br />6、swapoff swapfile&nbsp; #卸载</p>