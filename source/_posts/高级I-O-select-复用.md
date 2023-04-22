title: 高级I/O select 复用
categories: [程序设计,C编程]
tags: []
date: 2013-04-24 22:31:25
---
<pre>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <netdb.h>
#include <errno.h>
#define	MAX_BACK 5
#define BUFF_SIZE 1024
#define TIMEOUT 30
int sockfds[MAX_BACK];
int main(int argc, char **argv)
{
	struct sockaddr_in sevaddr, cliaddr;
	socklen_t socklen = sizeof(struct sockaddr_in);
	int sockfd, newfd, maxfd,  port, iBytes;
	char	buff[BUFF_SIZE];
	int n = 1;
	if(argc != 2){
		printf("Usage: %s <port> n", argv[0]);
		exit(1);
	}
	port = atoi(argv[1]);
	if((sockfd=socket(AF_INET, SOCK_STREAM, 0)) == -1) {
		perror("socket:");
		exit(1);
	}
	sevaddr.sin_family = AF_INET;
	sevaddr.sin_addr.s_addr = htonl(INADDR_ANY);
	sevaddr.sin_port = htons(port);
	setsockopt(sockfd, SOL_SOCKET, SO_REUSEADDR, &n, sizeof(int));
	if(bind(sockfd, (struct sockaddr *)&sevaddr, socklen) == -1) {
		perror("bind:");
		exit(1);
	}
	listen(sockfd, MAX_BACK);
	printf("Listen port:%dn", port);
	int	ret;
	fd_set readfds;
	struct timeval	val;
	maxfd = sockfd;
	int i;
	int comm_amount = 0 ;
	while(1) {
		FD_ZERO(&readfds);
		FD_SET(sockfd, &readfds);
		memset(&cliaddr, 0x00, socklen);
		val.tv_sec = 2;
		val.tv_usec = 0;
		for (i=0; i < MAX_BACK; i++) {
			if(sockfds[i] != 0) {
				FD_SET(sockfds[i], &readfds);
			}
		}
		ret = select(sockfd + 1, &readfds, 0, 0, &val);
		if(ret < 0) {
			perror("select:");
			break;
		}else if (ret == 0 ) {
			printf("timeoutn");
			continue;
		}
		for (i=0; i<comm_amount; i++) {
			if(FD_ISSET(sockfds[i], &readfds)) {
				ret = recv(sockfds[i], buff, sizeof(buff), 0);
				if(ret < 0) {
					perror("recv:");
					close(sockfds[i]);
					continue;
				} else {
					printf("recv buff:[%s]n", buff);
				}
			}
		}
		if(FD_ISSET(sockfd, &readfds)) {
			newfd = accept(sockfd, (struct sockaddr *)&cliaddr, &socklen);
			if(newfd <= 0) {
				perror("accept");
				close(newfd);
				break;
			}
			if(comm_amount < MAX_BACK) {
				sockfds[comm_amount++] = newfd;
				printf("new connection client [%d] ip:[%s]:[%d]n", comm_amount, inet_ntoa(cliaddr.sin_addr), ntohs(cliaddr.sin_port));
				if ( newfd > maxfd) maxfd = newfd;
			}else {
				printf("max connection arrive, exitn");
				send(newfd,"bye", 4, 0);
				close(newfd);
				continue;
			}
		}
	}
}
</pre>