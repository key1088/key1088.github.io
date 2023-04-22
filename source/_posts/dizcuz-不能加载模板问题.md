title: dizcuz 不能加载模板问题
categories: [Php编程]
tags: []
date: 2015-10-18 20:10:56
---
今天帮朋友迁移一个教育网站，在目标主机上面搭建好LNMP后，把网站打包上传，数据库备份上传，把数据库导入，网站文件和目录设置好，还有一些乱七八糟的设置设置。配置弄好后，启动程序，测试一下网站是否和原来的功能是否一致，页面是否都正常，需要和没迁移前保持一样。经过测试，其他的几个模块都没有问题，有一个BBS的模块，使用的dizcuz的程序，版本有些老了，打开首页直接显示模板内容了。看了对应的php是可以解析的，php解析没有问题，再看权限，设置的也合理。最后看了看解析的代码页没有问题，网站的文件都是打包过来的，文件一致性肯定能保证，肯定是环境哪里设置的问题。最好找了半天发现一个php的参数没有修改,原来是short_open_tag = Off，修改为On，重启一下php-fpm，（如果你是apache+php模块，就重启apache），再次访问就正常了。关于这个参数区别如下：
<pre>
php.ini
; This directive determines whether or not PHP will recognize code between
; <? and ?> tags as PHP source which should be processed as such. It's been
; recommended for several years that you not use the short tag "short cut" and
; instead to use the full <?php and ?> tag combination. With the wide spread use
; of XML and use of these tags by other languages, the server can become easily
; confused and end up parsing the wrong code in the wrong context. But because
; this short cut has been a feature for such a long time, it's currently still
; supported for backwards compatibility, but we recommend you don't use them.
; Default Value: On
; Development Value: Off
; Production Value: Off
; http://php.net/short-open-tag
short_open_tag = On
</pre>
这种情况也只有迁移的时候会遇到，如果重新安装，discuz检查php参数的时候肯定是报错不通过的。