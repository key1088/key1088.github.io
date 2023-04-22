title: mmap offset偏移量的简单使用
categories: [程序设计,C编程]
tags: []
date: 2013-04-18 22:50:09
---
mmap原型为：
</pre>
SYNOPSIS
       #include <sys/mman.h>
       void *mmap(void *addr, size_t length, int prot, int flags,int fd, off_t offset);
       int munmap(void *addr, size_t length);
</pre>
offset 必须为PAGE_SIZE的整数倍
LINUX下面获取PAGE_SIZE的命令
<pre>
root@bt:~/c# getconf PAGE_SIZE
4096
</pre>
<pre>
root@bt:~/c# cat mmap.c
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <fcntl.h>
#include <unistd.h>
#include <sys/mman.h>
#include <errno.h>
int main(int argc, char **argv)
{
	char buff[1024];
	char *mmaped;
	int fd;
	int offset, realOffset, length, realLen;
	if(argc != 4) {
		printf("Usage:%s <filename> <offset> <length>n", argv[0]);
		exit(1);
	}
	if((fd=open(argv[1], O_RDWR)) < 0) {
		perror("open");
		exit(1);
	}
	offset = atoi(argv[2]);
	length = atoi(argv[3]);
	printf("System Page_Size:[%ld]n", sysconf(_SC_PAGE_SIZE));
	realOffset = offset & ~(sysconf(_SC_PAGE_SIZE) - 1);  //必须为PAGE_SIZE倍数
	printf("realOffset:[%d]n", realOffset);
	realLen = length + offset - realOffset;
	printf("realLen:[%d]n", realLen);
	if((mmaped = mmap(NULL, realLen, PROT_READ|PROT_WRITE, MAP_SHARED, fd, realOffset)) == (void *)-1) {
		perror("mmap");
		exit(1);
	}
	close(fd);
	memset(buff,0x00,sizeof(buff));
	memcpy(buff, mmaped, realLen);
	printf("buff:[%s]n", buff);
	munmap(mmaped, realLen);
	return 0;
}
root@bt:~/c# gcc mmap.c
root@bt:~/c# ./a.out data.txt 4096  7
System Page_Size:[4096]
realOffset:[4096]
realLen:[7]
buff:[567890
]
root@bt:~/c# ./a.out data.txt 1  7
System Page_Size:[4096]
realOffset:[0]
realLen:[8]
buff:[12345678]
root@bt:~/c#
</pre>