title: php_admin_value 函数
categories: [Php编程]
tags: []
date: 2011-09-13 15:27:00
---
&nbsp;
为了安全，将上传文件的临时目录加入到php_admin_value open_basedir后面：<br />&lt;VirtualHost *:80&gt;
&nbsp;&nbsp;&nbsp;  php_admin_value open_basedir &quot;/usr/local/apache/htdocs/www:/tmp&quot;
&nbsp;&nbsp;&nbsp; php_admin_value safe_mode On
&nbsp;&lt;/VirtualHost&gt;<br />注意：两个目录之间是冒号隔开。
即使拿到该站点的webshell也看不到其他站点的东西。<br />
move_uploaded_file不受open_basedir的限制，所以不必修改php.ini里upload_tmp_dir的值。