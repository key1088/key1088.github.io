title: python 使用base64加解密
categories: [程序设计,Python编程]
tags: []
date: 2011-10-31 16:25:00
---
<p>1.最简单的加解密实例，字符串</p><p>import&nbsp;base64&nbsp; </p><p>str1&nbsp;= ‘hello'</p><p>print str1</p><p>str2&nbsp;=&nbsp;base64.b64encode(str1) <br /></p><p>print str2<br /></p><p>str3&nbsp;=&nbsp;base64.b64decode(str2) <br /></p><p>print str3</p><p><br /></p><p>2.针对文件加解密</p><p>import base64</p><p>f1=open('1.txt','r')</p><p>f2=open('2.txt','w')<br /></p><p>base64.encode(f1,f2)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #加密,把f1的内容加密后写入f2</p><p>#base64.decode(f1,f2)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #解密,把f1的内容解密后写入f2</p><p>f1.close()</p><p>f2.close()</p><p><br /></p>