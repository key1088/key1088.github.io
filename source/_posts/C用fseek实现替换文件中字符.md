title: C用fseek实现替换文件中字符
categories: [程序设计,C编程]
tags: [fseek,ftell]
date: 2013-04-16 23:25:53
---
使用fseek和ftell来移动到行首，替换字符串。代码如下
<pre>
#include <stdio.h>
#include <string.h>
#include <errno.h>
#define	BUFF_SIZE 256
int showHelp(){
	fputs("Usage:n", stdout);
	fputs("progname [filename] [oldstr] [newstr]n", stdout);
	fputs("n", stdout);
	return -1;
}
int replace(char *line, char *oldstr, char *newstr){
	char buf[BUFF_SIZE];
	char *p;
	int iLen = 0;
	p = strstr(line, oldstr);
	if(p) {
		memset(buf, 0x00, sizeof(buf));
		strcpy(buf, p + strlen(oldstr));
	}else{
		return 0;
	}
	iLen = strlen(buf);
	if ( buf[iLen-1] == 'n')
		buf[iLen]=0;
	*p = ' ';
	strcat(p, newstr);
	strcat(p, buf);
	printf("p=%sn", p);
	return 1;
}
int main(int argc, char **argv)
{
	char buf[BUFF_SIZE];
	FILE *fp;
	int iNum = 0;
	int i = 0;
	long sttell, endtell;
	if(argc != 4) {
		showHelp();
		return -1;
	}
	fp = fopen(argv[1],"r+");
	if(fp == NULL) {
		perror("open file error");
		return -1;
	}
	while( ! feof(fp) ) {
		sttell = ftell(fp);
		fgets(buf, 256, fp);
		if(replace(buf, argv[2], argv[3]) != 0) {
			endtell = ftell(fp);
			fseek(fp, sttell - endtell, 1);
			fputs(buf, fp);
			fseek(fp, sttell - endtell, 1);
			iNum++;
		}
	}
	fclose(fp);
	printf("num=[%d]n", iNum);
	return 0;
}
</pre>