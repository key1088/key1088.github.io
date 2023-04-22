title: 修改IIS6.0Banner信息
categories: [网络安全]
tags: []
date: 2012-04-12 08:30:00
---
<p>在做安全检测的时候，我们一般都会利用Nmap等扫描器对目标站进行扫描，以获取信息，方便入侵。作为站长的我们可以利用一点小技巧来屏蔽服务器的返回信息，达到隐藏敏感信息的目的。这里介绍一下如何修改IIS6.0的banner信息。网上收集的方法，已经测试过可行。</p><p>1、win2003有系统文件保护，在c:windowssystem32dllcache里删除w3core.dll或者同时替换这里的w3core.dll</p><p>2、用Uedit32打开c:windowssystem32inetsrvw3core.dll。</p><p>3、直接搜索关键字6.0要勾选ascii</p><p>4、搜索到了直接改，随你怎么改。我就改成8.0</p><p>5、停止IIS Admin Service服务，再保存对w3core.dll的修改。如果还是保存不了，就用attrib -R修改它的属性。还不行你就另存为其他名字，然后想办法删了原w3core.dll，之后再将新文件换成该名字即可。</p><p>6、启动IIS Admin Service服务，然后对该服务再重启次，不行就重启系统。</p><p><a href="http://www.waitalone.cn/upload/201204111710128104.png"><img style="width: 520px;" src="/images/pic/e030b33e70cf3bc72bf5f44dd100baa1cc112a52.jpg" /></a></p><p>IIS8.0？win8？蛋疼了吧。</p><p>原文地址：http://www.2cto.com/Article/201111/110201.html</p>