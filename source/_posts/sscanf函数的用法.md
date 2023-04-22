title: sscanf函数的用法
categories: [程序设计,C编程]
tags: []
date: 2014-03-16 15:05:21
---
sscanf() - 从一个字符串中读进与指定格式相符的数据.
函数原型:
int sscanf( string str, string fmt, mixed var1, mixed var2 ... );
int scanf( const char *format [,argument]... );
说明：
　　sscanf与scanf类似，都是用于输入的，只是后者以屏幕(stdin)为输入源，前者以固定字符串为输入源。
　　其中的format可以是一个或多个 {%[*] [width] [{h | l | I64 | L}]type | ' ' | '/t' | '/n' | 非%符号}
　　注：
　　1、 * 亦可用于格式中, (即 %*d 和 %*s) 加了星号 (*) 表示跳过此数据不读入. (也就是不把此数据读入参数中)
　　2、{a|b|c}表示a,b,c中选一，[d],表示可以有d也可以没有d。
　　3、width表示读取宽度。
　　4、{h | l | I64 | L}:参数的size,通常h表示单字节size，I表示2字节 size,L表示4字节size(double例外),l64表示8字节size。
　　5、type :这就很多了，就是%s,%d之类。
　　6、特别的：%*[width] [{h | l | I64 | L}]type 表示满足该条件的被过滤掉，不会向目标参数中写入值
　　支持集合操作：
　　%[a-z] 表示匹配a到z中任意字符，贪婪性(尽可能多的匹配)
　　%[aB'] 匹配a、B、'中一员，贪婪性
　　%[^a] 匹配非a的任意字符，贪婪性
例子：
　　1. 常见用法。
　　char buf[512] ={0} ;
　　sscanf("123456 ", "%s", buf);
　　printf("%s/n", buf);
　　结果为：123456
　　2. 取指定长度的字符串。如在下例中，取最大长度为4字节的字符串。
　　sscanf("123456 ", "%4s", buf);
　　printf("%s/n", buf);
　　结果为：1234
　　3. 取到指定字符为止的字符串。如在下例中，取遇到空格为止字符串。
　　sscanf("123456 abcdedf", "%[^  ]", buf);
　　printf("%s/n", buf);
　　结果为：123456
　　4. 取仅包含指定字符集的字符串。如在下例中，取仅包含1到9和小写字母的字符串。
　　sscanf("123456abcdedfBCDEF", "%[1-9a-z]", buf);
　　printf("%s/n", buf);
　　结果为：123456abcdedf
　　5. 取到指定字符集为止的字符串。如在下例中，取遇到大写字母为止的字符串。
　　sscanf("123456abcdedfBCDEF", "%[^A-Z]", buf);
　　printf("%s/n", buf);
　　结果为：123456abcdedf
　　6、给定一个字符串iios/12DDWDFF@122，获取 / 和 @ 之间的字符串，先将 "iios/"过滤掉，再将非'@'的一串内容送到buf中
　　sscanf("iios/12DDWDFF@122", "%*[^/]/%[^@]", buf);
　　printf("%s/n", buf);
　　结果为：12DDWDFF
    7、分解key1088@163.com
    sscanf("key1088@163.com","%[^@]%*c%s", user, host);
    结果为：user=key1088,host=163.com