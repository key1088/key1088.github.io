title: C专家编程—分析signal函数的原型声明
categories: [程序设计,C编程]
tags: []
date: 2014-03-11 21:42:40
---
在ANSI标准中，signal()的声明如下：
void (*signal(int sig,void (*func)(int)))(int)
signal是一个函数，它返回一个函数指针，后者所指向的函数(signal的返回值)接受一个int参数并返回void。signal函数有两个参数，一个是sig(为int类型)，另一个是func(为void(*)(int)类型)。
void (*func)(int)是一个函数指针，所指向的函数接受一个int参数，返回值是void。
下面用typedef进行简化：
typedef void（*ptr_to_func）(int);
ptr_to_func signal（int，ptr_to_func）;
网上的一个例子：
<pre>
#include <stdio.h>
enum { RED, GREEN, BLUE };
void OutputSignal(int sig)
{
    printf("The signal you /'ve input is: ");
    switch(sig)
    {
    case RED:
        puts("RED!");
        break;
    case GREEN:
        puts("GREEN!");
        break;
    case BLUE:
        puts("BLUE!");
        break;
    }
}
void ( *signal( int sig, void (*func)(int) ) ) (int)
{
    puts("Hello, world!");
    func(sig);
    return func;
}
int main(void)
{
    (*signal(GREEN, &amp;OutputSignal))(RED);
    return 0;
}
Output:
Hello, world!
The signal you 've input is: GREEN!
The signal you 've input is: RED!</pre>