title: oracle TNS：无法解析指定的连接标识符！！
categories: [Linux]
tags: []
date: 2012-03-02 16:32:00
---
<p>用sqlplus 连接数据库，提示这个错误。</p><p>原因两个问题</p><p>&nbsp;</p><p>1. sid问题，sid最多为8位。</p><p>2.tns 是否监听</p><p>&nbsp;</p><p>可以看一下这个文件</p><p>network/admin/tnsnames.ora</p><p>例如；</p><p>ORCL =<br />&nbsp; (DESCRIPTION =<br />&nbsp;&nbsp;&nbsp; (ADDRESS = (PROTOCOL = TCP)(HOST = 19f9014c5ca444d)(PORT = 1521))<br />&nbsp;&nbsp;&nbsp; (CONNECT_DATA =<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (SERVER = DEDICATED)<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (SERVICE_NAME = orcl)<br />&nbsp;&nbsp;&nbsp; )<br />&nbsp; )</p><p><br />这里面写的清清楚楚。再netstat -an 一下看看端口。相信你懂的。</p>