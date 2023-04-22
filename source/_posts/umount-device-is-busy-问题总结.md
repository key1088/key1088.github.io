title: umount device is busy 问题总结
categories: [Linux]
tags: []
date: 2011-02-21 16:01:00
---
<p>一个同事最近几次发现mount了一个网络共享磁盘后， 就无法umount, 老是提示：device is busy， 服务又不能停止的。</p><p>看看于是总结了一下几点。</p><p>1.是否在使用本挂载目录，现在路径在挂载目录下，会出现本提示。</p><p>2.也可以使用 shell&gt;fuser&nbsp; -m 挂载目录&nbsp; 查到pid后，直接kill掉。</p><p>&nbsp;&nbsp; 或者 shell&gt;fuser&nbsp; -k 挂载目录&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 直接结束掉。（有的版本没有这个选项）</p><p>3.如果以上方法还是提示设备在使用中 </p><p>&nbsp;shell&gt;umount -fl&nbsp; 挂载目录</p><p>4.最绝的方法就是重启机器，有自启动挂载的话，在/etc/fstab里面去掉，重启解挂。。</p>