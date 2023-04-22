title: C qsort函数使用
categories: [程序设计,C编程]
tags: [qsort]
date: 2013-04-13 12:59:17
---
<pre>
#include <stdio.h>
int cmp(const void *a,const void *b);
int main(void)
{
    int num[]={10,2,4,1,4,6,7};
    for(int i=0;i < sizeof(num)/4;i++) {
        printf("%d,",num[i]);
    }
    printf("n---------------n");
    qsort(num,sizeof(num)/4,sizeof(num[0]),cmp);
    for(int i=0;i < sizeof(num)/4; i++) {
        printf("%d,",num[i]);
    }
    printf("n");
    return 0;
}
int cmp(const void *a, const void *b)
{
    return *(int *)a - *(int *)b;
}
</pre>