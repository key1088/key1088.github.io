title: 卸载TCP/IP协议总结
categories: [Windows]
tags: []
date: 2010-03-22 18:08:00
---
<p>正常情况下、网卡属性里面TCP/IP协议卸载按钮是灰色的，无法卸载。</p><p> </p><p>&#160;1.找到%winroot%/inf/nettcpip.inf，用记事本打开。</p><p>[MS_TCPIP.PrimaryInstall]<br />Characteristics = 0xa0  &lt;------把此处的0Xa0改为0x80</p><p>2.网卡属性——安装——网络类型组件——协议——从磁盘安装——浏览到刚才修改的文件——Internet协议（TCP/IP)</p><p>3.现在Internet TCP/IP卸载按钮就是可选的了。</p><p>4.卸载 Internet TCP/IP，重启就卸载完成、</p><p>&#160;</p><p>安装就大同小异了，不写了。</p>