title: trim很简单的代码，但是很常用
categories: [C编程]
tags: []
date: 2013-11-04 23:02:29
---
void ltrim(char <em>s)
{
 char *p;
 p = s;
 while(</em>p == ' ' || <em>p == 't'){</em>p++;}
 strcpy(s,p);
}
void rtrim(char *s)
{
 int i;
 if (s == NULL)
   return;
 i = strlen(s)-1;
 while((s[i] == ' ' || s[i] == 't') &amp;&amp; i >= 0){i--;};
 s[i+1] = ' ';
}
void trim(char *s){
    ltrim(s);
    rtrim(s);
}