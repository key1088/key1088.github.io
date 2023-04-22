title: 用tcgetattr、tcsetattr实现密码输入框
categories: [Linux,C编程]
tags: []
date: 2014-09-17 22:31:19
---
在读ptrunnel的代码时，发现一个很好的用法记录一下，可用于密码的输入框，不回显输入内容，可用于很多场景。
代码如下：
<pre>
static int terminal_echo_off(int fd)
{
struct termios term;
if (isatty(fd) == 0)
{
#ifdef DEBUG
printf("the file %i is not a terminaln", fd);
#endif /* DEBUG */
return -1;
}
if (tcgetattr(fd, &term) < 0)
{
#ifdef DEBUG
perror("tcgetattr: ");
#endif /* DEBUG */
return -1;
}
term.c_lflag &= ~ECHO;
if (tcsetattr(fd, TCSANOW, &term) < 0)
{
#ifdef DEBUG
perror("tcsetattr: ");
#endif /* DEBUG */
return -1;
}
return 0;
}
static int terminal_echo_on(int fd)
{
struct termios term;
if (isatty(fd) == 0)
{
#ifdef DEBUG
printf("the file %i is not a terminaln", fd);
#endif /* DEBUG */
return -1;
}
if (tcgetattr(fd, &term) < 0)
{
#ifdef DEBUG
perror("tcgetattr: ");
#endif /* DEBUG */
return -1;
}
term.c_lflag |= ECHO;
if (tcsetattr(fd, TCSANOW, &term) < 0)
{
#ifdef DEBUG
perror("tcsetattr: ");
#endif /* DEBUG */
return -1;
}
return 0;
}
</pre>