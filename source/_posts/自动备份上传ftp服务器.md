title: 自动备份上传ftp服务器
categories: [程序设计,Shell编程]
tags: []
date: 2011-10-18 15:12:00
---
#!/bin/bash
filename=`date +%Y%m%d`.tar                                                         #文件名称为日期
find /data/ -mtime +30 | xargs tar -cf $filename                                 #在/data目录中，查找30天内没有修改的文件，并打包
gzip -9 $filename                                                                              #使用gzip压缩
ftp -n &lt;&lt; EOF                                                                                   #交互登录
open 192.168.0.1
user key1088 123456                                                                       #key1088 为username，123456为password
put /data/$filename.gz bakfile/$filename.gz                                      #上传到bakfile文件下面
bye
EOF
rm -rf $filename.gz