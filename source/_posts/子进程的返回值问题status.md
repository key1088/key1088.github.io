title: 子进程的返回值问题status
categories: [C编程]
tags: []
date: 2013-06-19 16:53:59
---
最近有一个程序，转移到另一台服务器上了，在接受返回值的时候一直出问题。
<pre>
waitpid(pid, &status, WNOHANG);
</pre>
WEXITSTATUS(status)老实返回16，郁闷。
最后发现是信号的问题。在fork子进程前，添加对子进程的信号接受就可以了。
<pre>
signal(SIGCHLD,SIG_DFL);
</pre>