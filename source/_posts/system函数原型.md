title: system函数原型
categories: [C编程]
tags: []
date: 2012-08-30 17:33:00
---
<pre>
116 #ifdef FORK
117  pid = FORK ();
118 #else
119  pid = __fork ();
120 #endif
121  if(pid == (pid_t) 0)
122    {
123      /** Child side.  */
124      constchar*new_argv[4];
125      new_argv[0] = SHELL_NAME;
126      new_argv[1] = "-c";
127      new_argv[2] = line;
128      new_argv[3] = NULL;
129
130      /** Restore the signals.  */
131      (void) __sigaction (SIGINT, &intr, (structsigaction *) NULL);
132      (void) __sigaction (SIGQUIT, &quit, (structsigaction *) NULL);
133      (void) __sigprocmask (SIG_SETMASK, &omask, (sigset_t *) NULL);
134      INIT_LOCK ();
135
136      /** Exec the shell.  */
137      (void) __execve (SHELL_PATH, (char*const*) new_argv, __environ);  //exec被代替改程序，如果失败的话，就是执行下一条
138      _exit (127);  //直接进入内核中断，返回127.
139    }
140  elseif(pid < (pid_t) 0)
141    /** The fork failed.  */
142    status = -1;
143  else
144    /** Parent side.  */
145    {
146      /** Note the system() is a cancellation point.  But since we call
147     waitpid() which itself is a cancellation point we do not
148     have to do anything here.  */
149      if(TEMP_FAILURE_RETRY (__waitpid (pid, &status, 0)) != pid)
150    status = -1;
151    }
</pre>