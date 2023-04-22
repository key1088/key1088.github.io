title: Oracle 10g 错误“ORA-00988 口令缺失或无效”终极解决办法！
categories: [Oracle]
tags: []
date: 2012-03-02 10:48:00
---
如果在安装Oracle的时候出现如下问题：创建数据库完成让你输入密码的时候弹出&quot;ora-00988 缺少或无效口令&quot;的对话框如下图
<img src="/images/pic/309723085d41f3fc0b7b822c.jpg" small="0" /><br />
这是因为Oracle对密码的要求如下：
系统用户（SYS、SYSTEM）口令长度不能小于7个字符第一个字符不能为数字且全部字符中应该为字母和数字混合
解决方法：
运行 cmd 按如下输入命令 sqlplus / as sysdba --------- 注意以上的语句中&quot;/&quot;两边都要有空格哦！--------- 以sys登陆 alter user 用户名 account unlock; --------- 解除锁定 alter user 用户名 identified by&nbsp;密码;-------------修改密码然后用你改好的密码登陆就行 举例：sqlplus / as sysdbaalter user sys account unlock;alter user sys identified by manager;希望你看过本文章后能顺利解决问题！&nbsp;