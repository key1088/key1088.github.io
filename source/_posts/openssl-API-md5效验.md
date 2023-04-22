title: openssl API md5效验
categories: [网络安全,Linux,C编程]
tags: [MD5_CTX,openssl]
date: 2013-05-02 23:48:31
---
<pre>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <errno.h>
#include <openssl/md5.h>
int main(int argc, char **argv)
{
    MD5_CTX ctx;
    unsigned char md[32 + 1];
    char    md5[32 + 1];
    char    tmp[2];
    char    buff[256];
    char    *filename;
    FILE    *fp;
    int     i;
    if (argc < 2) {
        printf("Usage:%s <filename>n", argv[0]);
        exit(1);
    }
    filename = argv[1];
    memset(md5, 0x00, sizeof(md5));
    memset(md, 0x00, sizeof(md));
    if(MD5_Init(&ctx) == 0) {
        perror("MD5_Init");
        exit(1);
    }
    if((fp=fopen(filename,"rb")) == NULL) {
        perror("fopen");
        exit(1);
    }
    while (! feof(fp) ) {
        memset(buff, 0x00, sizeof(buff));
        fgets(buff, 256, fp);
        if(MD5_Update(&ctx, buff, strlen(buff)) == 0) {
            perror("MD5_Update");
            exit(1);
        }
    }
    fclose(fp);
    if(MD5_Final(md, &ctx) == 0) {
        perror("MD5_Final:");
        exit(1);
    }
        for(i=0; i< 16; i++) {
        memset(tmp, 0x00, sizeof(tmp));
            sprintf(tmp, "%02X", md[i]);
            strcat(md5, tmp);
    }
    printf("md5(%s):%sn", filename, md5);
    return 0;
}
</pre>
<pre>
root@bt:~/c# cc -o testmd5 testmd5.c -lssl
root@bt:~/c# ./testmd5 1.c
md5(1.c):1558734758F8CB08D6DB8D5B57E71BF7
root@bt:~/c# ./testmd5 2.c
md5(2.c):0C8E614EC0AB5B5CEF90D012F5C11797
root@bt:~/c# openssl md5 1.c
MD5(1.c)= 1558734758f8cb08d6db8d5b57e71bf7
root@bt:~/c# openssl md5 2.c
MD5(2.c)= 0c
</pre>