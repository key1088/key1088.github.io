title: LABEL 问题
categories: [Linux]
tags: []
date: 2010-12-02 17:10:00
---
<p>e2label device [newlabel]&nbsp;&nbsp;  创建设备的标签命令 <br />比如我们想把文件系统为ext3 的分区/dev/hda5的标签设备为 /5 ，我们应该执行如下的命令： <br />[root@localhost]# e2label /dev/hda5 /5 <br /><br />如果是reiserfs文件系统，我们应该用 <br />[root@localhost]# reiserfstune -l 标签 设备 <br />举例：比如我为reiserfs 文件系统 /dev/hda10设置标签为 /10 ； <br />[root@localhost]# reiserfstune -l /10 /dev/hda10 <br /><br />警告： 请不要在您的Linux的安装分区（也就是Linux系统/ 所在的分区）实践，会导致您的Linux系统崩溃；如果想实践，请在其它分区测试。</p><p> </p><p>破坏的话，用光盘进入查看LABEL，或修复，进入grub修改也可以。</p>