title: LINUX 设置库优先级变量LD_PRELOAD
categories: [网络安全,Linux,C编程]
tags: []
date: 2014-04-13 16:20:45
---
在Unix操作系统的动态链接库的世界中，LD_PRELOAD就是这样一个环境变量，它可以影响程序的运行时的链接（Runtime linker），它允许你定义在程序运行前优先加载的动态链接库。
  大家想到着就邪恶了吧，今天看proxychanis代码发现的，和win平台sockscap32类似。
 看代码test.c
<pre>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
int main(void)
{
    char *passwd="abcd";
    char in_buff[10];
    printf("-->input your passwd:");
    scanf("%s", in_buff);
    if( strcmp(passwd,in_buff) != 0) {
        printf("passwd errn");
        exit(-1);
    }
    printf("ok!. open doorn");
}
</pre>
库代码hack.c
<pre>
#include <stdio.h>
int strcmp(const char *s1, const char *s2)
{
    printf("hack function invoked. s1=[%s],s2=[%s]n", s1, s2);
    return 0;
}
</pre>
<pre>
[root@localhost preload]# gcc -o test test.c
[root@localhost preload]# ./test
-->input your passwd:123
passwd err
[root@localhost preload]# gcc -shared -o hack.o hack.c
[root@localhost preload]# ls -l hack.so
-rwxr-xr-x 1 root root 4116 Apr 13 15:52 hack.so
[root@localhost preload]# LD_PRELOAD="./hack.so"
[root@localhost preload]# ./test
-->input your passwd:123
passwd err
[root@localhost preload]# export LD_PRELOAD="./hack.so"
[root@localhost preload]# ./test
-->input your passwd:123
hack function invoked. s1=[abcd],s2=[123]
ok!. open door
[root@localhost preload]#
</pre>
这是一种思路，还有一种最直接的办法用ltrace
ltrace是跟踪调用库函数的工具
<pre>
[root@localhost preload]# export LD_PRELOAD=
[root@localhost preload]# ltrace ./test
(0x69951c, 0x699ab0, 0, 0, 0x699e58)                                              = 0x6998e4
__libc_start_main(0x80484a4, 1, 0xbf948364, 0x8048530, 0x8048520 <unfinished ...>
printf("-->input your passwd:")                                                   = 21
__isoc99_scanf(0x80485ff, 0xbf9482a2, 0x9acce0, 0x9abff4, 0x8048530-->input your passwd:123
)              = 1
strcmp("abcd", "123")                                                             = 1
puts("passwd err"passwd err
)                                                                = 11
exit(1 <unfinished ...>
+++ exited (status 1) +++
[root@localhost preload]#
</pre>