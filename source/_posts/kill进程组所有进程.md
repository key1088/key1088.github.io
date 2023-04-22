title: kill进程组所有进程
categories: [Linux,C编程]
tags: []
date: 2013-06-05 22:33:15
---
<pre>
#include <stdio.h>
#include <sys/signal.h>
#include <stdlib.h>
int main(void)
{
    pid_t   pid;
    printf("father-pgrpid=[%d]n", getpgrp());
    pid = fork();
    if (pid < 0) {
        printf("fork errn");
    } else if (pid == 0) {
        setpgrp();
        printf("child-pid[%d]n", getpid());
        printf("child-pgrpid=[%d]n", getpgrp());
        if(pid=fork() <0) {
            printf("fork errn");
        }else if (pid == 0) {
            while(1)
                sleep(10);
            exit(0);
        }
        sleep(100);
        exit(1);
    }else{
        sleep(1);
        printf("fathern");
        if(kill(-pid, SIGTERM) != 0) {
            perror("kill");
        }else{
            printf("killed okn");
        }
    }
}
</pre>