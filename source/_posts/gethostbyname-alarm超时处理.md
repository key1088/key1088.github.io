title: gethostbyname alarm超时处理
categories: [程序设计,C编程]
tags: [alarm,gethostbyname,jmp_buf,longjmp,setjmp]
date: 2013-04-23 22:15:37
---
在使用gethostbyname DNS查询的时候，处理很慢的情况。使用alarm设置超时时间，并用setjmp进行处理。
<pre>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <netdb.h>
#include <unistd.h>
#include <signal.h>
#include <setjmp.h>
#include <errno.h>
#define EXIT_SUCC	exit(0);
#define	EXIT_FAIL	exit(-1);
#define TIME_OUT	3
jmp_buf	ebuf;
void handler()
{
	longjmp(ebuf,1);
}
int main(int argc, char **argv)
{
	char		*hostname;
	char		buff[]="request msg";
	struct 		sockaddr_in sevaddr;
	int		sockfd, port, iBytes;
	struct		hostent *host;
	if(argc != 3) {
		printf("Usage: %s <ip> <port>n", argv[0]);
		EXIT_SUCC;
	}
	if(setjmp(ebuf)) {
		printf("gethostbyname timeoutn");
		exit(1);
	}
	hostname = argv[1];
	port	 = atoi(argv[2]);
	signal(SIGALRM, handler);
	alarm(TIME_OUT);
	if((host = gethostbyname(hostname)) == NULL) {
		perror("gethostbyname");
		EXIT_FAIL;
	}
	alarm(0);
	if((sockfd = socket(AF_INET, SOCK_STREAM, 0)) == -1) {
		perror("socket:");
		EXIT_FAIL;
	}
	memset(&sevaddr, 0x00, sizeof(struct sockaddr_in));
	sevaddr.sin_family = AF_INET;
	sevaddr.sin_addr = *((struct in_addr *)host->h_addr);
	sevaddr.sin_port = htons(port);
	printf("connect to remote server ....n");
	if(connect(sockfd, (struct sockaddr *)&sevaddr, sizeof(struct sockaddr_in)) == -1) {
		perror("connect");
		EXIT_FAIL;
	}
	iBytes = send(sockfd, buff, strlen(buff), 0);
	if(iBytes < 0) {
		perror("send");
		EXIT_FAIL;
	}
	printf("Send Data :len[%d]buff[%s]n", iBytes, buff);
	close(sockfd);
	EXIT_SUCC;
}
</pre>