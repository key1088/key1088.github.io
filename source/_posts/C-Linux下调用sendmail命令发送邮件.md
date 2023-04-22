title: C Linux下调用sendmail命令发送邮件
categories: [程序设计,操作系统,C编程]
tags: []
date: 2014-03-16 15:51:15
---
用C写了一个扫描类的监控程序，为了监控的实时性，所有要发送邮件。
前提机器中必须有sendmail程序，sendmail的目录自己定义。
我测试环境的信息
<pre>
[root@localhost sendmail]# uname -a
Linux localhost.localdomain 2.6.32-358.el6.i686 #1 SMP Thu Feb 21 21:50:49 UTC 2013 i686 i686 i386 GNU/Linux
[root@localhost sendmail]# cat /etc/issue
CentOS release 6.4 (Final)
Kernel r on an m
</pre>
代码如下，很简单只要是思路。
<pre>
#include <stdio.h>
#include <stdlib.h>
#include <errno.h>
//借助sendmail命令发送邮件
//邮件格式如下：
/*
*From: John Doe <test@machine.example>
*Sender: Michael Jones <mjones@machine.example>
*To: Mary Smith <key1088@163.com>
*Subject: Saying Hello
*Date: Fri, 21 Nov 1997 09:55:06 -0600
*Message-ID: <1234@local.machine.example>
*
*This is a message just to say hello.
*So, "Hello".
*/
int main(void)
{
        FILE    *fp;
        char    buffer[512];
        if( (fp=popen("/usr/sbin/sendmail -t","w")) == NULL)
        {
                perror("open /usr/sbin/sendmail errorn");
                printf("%sn", strerror(errno));
        }
        fputs("From: John Doe <test@machine.example>n", fp);
        fputs("Sender: Michael Jones <mjones@machine.example>n", fp);
        fputs("To: key1088 <key1088@163.com>n", fp);
        fputs("Subject: Hello,wordn", fp);
        fputs("Date: Fri, 21 Nov 1997 09:55:06 -0600n", fp);
        fputs("Message-ID: <1234@local.machine.example>n", fp);
        fputs("n", fp);
        fputs("This is a message just to say hello.n", fp);
        fputs("So, Hellon", fp);
        if( pclose(fp) != 0) {
                printf("send mail error.n");
                exit(1);
        }
        printf("send mail done.n");
}
[root@localhost sendmail]# cc sendmail.c
[root@localhost sendmail]# a.out
send mail done.
[root@localhost sendmail]# tail /var/log/maillog
Mar 16 15:43:45 localhost postfix/sendmail[2124]: fatal: Recipient addresses must be specified on the command line or via the -t option
Mar 16 15:47:33 localhost postfix/qmgr[1059]: 2B7F53F87B: from=<root@localhost.localdomain>, size=431, nrcpt=1 (queue active)
Mar 16 15:47:33 localhost postfix/qmgr[1059]: 667E83F89F: from=<root@localhost.localdomain>, size=431, nrcpt=1 (queue active)
Mar 16 15:47:33 localhost postfix/smtp[2130]: 2B7F53F87B: to=<key1088@163.com>, relay=none, delay=1075, delays=1075/0.08/0/0, dsn=4.4.3, status=deferred (Host or domain name not found. Name service error for name=163.com type=MX: Host not found, try again)
</pre>
因为测试环境没有联网，所以是发送不成功。