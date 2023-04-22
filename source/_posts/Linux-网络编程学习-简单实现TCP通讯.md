title: Linux 网络编程学习-简单实现TCP通讯
categories: [程序设计,C编程]
tags: []
date: 2013-04-17 22:18:50
---
以后，争取每天写一个工作除外的程序，练习练习代码能力。主要是方便自己看，不是学习系列,误伤莫怪。
上代码了
<pre>
root@bt:~/c/network# cat server.c
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <errno.h>
#include <sys/types.h>
#include <arpa/inet.h>
#include <sys/socket.h>
#include <netinet/in.h>
int main(int argc, char *argv[])
{
	struct sockaddr_in server_addr;
	struct sockaddr_in client_addr;
	int port;
	int sin_size;
	int sockfd, new_sockfd;
	char hello[]="hello,world for inetd";
	if(argc != 2) {
		fprintf(stderr, "[Usage:] %s postan", argv[0]);
		exit(1);
	}
	port = atoi(argv[1]);
	printf("port=%dn", port);
	if((sockfd = socket(AF_INET, SOCK_STREAM, 0)) == -1) {
		fprintf(stderr, "socket error %san", strerror(errno));
		exit(1);
	}
	int n = 1;
	setsockopt(sockfd, SOL_SOCKET, SO_REUSEADDR, &n ,sizeof(n));
	bzero(&server_addr, sizeof(struct sockaddr_in));
	server_addr.sin_family = AF_INET;
	server_addr.sin_addr.s_addr = htonl(INADDR_ANY);
	server_addr.sin_port = htons(port);
	if(bind(sockfd, (struct sockaddr *)(&server_addr), sizeof(struct sockaddr)) == -1){
		fprintf(stderr,"bind error %san", strerror(errno));
		exit(1);
	}
	if(listen(sockfd, 5) == -1) {
		fprintf(stderr, "listen error %san", strerror(errno));
		exit(1);
	}
	while ( 1 ) {
		sin_size = sizeof(struct sockaddr);
		if((new_sockfd=accept(sockfd, (struct sockaddr *)(&client_addr), &sin_size)) == -1) {
			fprintf(stderr, "accept error %san", strerror(errno));
			exit(1);
		}
		fprintf(stderr, "server get connection from %sn", inet_ntoa(client_addr.sin_addr));
		if(write(new_sockfd, hello, strlen(hello)) == -1) {
			fprintf(stderr, "write to client error %san", strerror(errno));
			close(new_sockfd);
			continue;
		}
		close(new_sockfd);
	}
	close(sockfd);
	return 0;
}
</pre>
<pre>
root@bt:~/c/network# cat client.c
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <errno.h>
int main(int argc, char **argv)
{
	struct sockaddr_in server_addr;
	int	sockfd, port, nbytes;
	char	buffer[1024];
	struct hostent *host;
	if(argc != 3) {
		fprintf(stderr, "Usage:%s hostname port", argv[0]);
		exit(1);
	}
	if((host=gethostbyname(argv[1])) == NULL) {
		fprintf(stderr, "gethostbyname error %sna", strerror(errno));
		exit(1);
	}
	if((port=atoi(argv[2])) < 0) {
		fprintf(stderr, "port input errorna");
		exit(1);
	}
	if((sockfd=socket(AF_INET, SOCK_STREAM, 0)) == -1 ){
		fprintf(stderr, "socket error %sna", strerror(errno));
		exit(1);
	}
	bzero(&server_addr, sizeof(struct sockaddr_in));
	server_addr.sin_family = AF_INET;
	server_addr.sin_addr.s_addr=inet_addr(argv[1]);
	server_addr.sin_port = htons(port);
	if(connect(sockfd, (struct sockaddr *)(&server_addr), sizeof(struct sockaddr )) == -1) {
		fprintf(stderr, "connect error %sna", strerror(errno));
		exit(1);
	}
	if((nbytes=read(sockfd, buffer, 1024)) == -1) {
		fprintf(stderr, "read sockfd error %sna", strerror(errno));
		exit(1);
	}
	buffer[nbytes]='0';
	printf("buffer=[%s]n", buffer);
	close(sockfd);
	return 0;
}
</pre>
<pre>
root@bt:~/c/network# cat Makefile
all:server client
server:server.c
	gcc $^ -o $@
client:client.c
	gcc $^ -o $@
</pre>