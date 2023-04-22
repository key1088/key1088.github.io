title: linux 文件、目录写保护
categories: [Linux]
tags: []
date: 2011-06-15 10:55:00
---
<p>文件：</p><p>[root@book ~]# touch a.txt</p>[root@book ~]# chattr +i a.txt<br />[root@root&nbsp;~]# rm -f a.txt<br />rm: cannot remove `a.txt': Operation not permitted<br />[root@book ~]# ls<br />anaconda-ks.cfg a.txt Desktop &nbsp;install.log install.log.syslog<br />[root@book ~]# chattr -i a.txt<br />[root@book ~]# rm -f a.txt<br />[root@book ~]# ls<br />anaconda-ks.cfg Desktop &nbsp;install.log install.log.syslog<br /><p>&nbsp;</p><p>目录：</p>[root@root&nbsp;root]# mkdir test<br />[root@root&nbsp;root]# chattr +i test<br /><p>[root@root&nbsp;root]# rm -fr test</p><p>rm: cannot remove directory `test': Operation not permitted</p><p>&nbsp;</p><p></p>