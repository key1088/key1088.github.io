title: 安装EASYXSS的一些小问题
categories: [网络安全]
tags: []
date: 2013-04-13 12:53:38
---
EASYXSS项目开源了，很给力的项目，下载地址，
<pre>
http://wdot.cc/Attack/49.html
</pre>
在安装过程中，出现了几个小问题，也许别人会遇到。
1.数据库连接问题，
使用ThinkPhp DB_DSN连接方式，用户和密码之间用：号
2.’URL_MODEL’ => ’0′,
如果’URL_MODEL’ => ’0′的话，官方推荐这种方式，但是必须要web服务器支持PATH_INFO,我使用的NGINX默认是不支持的，需要在PHP规则中修改下面代码
<pre>
location ~ .php($|/) {
root /wwwroot;
fastcgi_pass   127.0.0.1:9000;
fastcgi_index  index.php;
fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
#Add pathinfo Start
fastcgi_split_path_info ^(.+.php)(.*)$;
fastcgi_param PATH_INFO $fastcgi_path_info;
#Add Pathinfo End
include        fastcgi_params;
}
</pre>
3.’URL_MODEL’ => ’3′
开始我用的’URL_MODEL’ => ’3′,访问后台是正常了，但是一直得不到数据，一直得到”你妹的”，给个妹子吧 。
看了一下代码AppLibActionEmptyAction.class.php,在GET操作 URL中，没有index，最终调用不了index 函数
把index函数修改为_empty就可以，不是很完美，php不是太懂，就讲究着用吧 。