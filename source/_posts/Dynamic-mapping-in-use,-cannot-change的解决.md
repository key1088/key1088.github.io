title: Dynamic mapping in use, cannot change的解决
categories: [网络工程]
tags: []
date: 2010-04-02 19:41:00
---
RO(config)#no ip nat inside source list 1 pool dy<br />%Dynamic mapping in use, cannot change<br />RO(config)#^Z<br />RO#<br />RO#clear ip nat translation * <br />RO#conf t<br />Enter configuration commands, one per lineEnd with CNTL/Z.<br />RO(config)#no ip nat inside source list 1 pool dy<br />RO(config)#<br />RO(config)#<br />