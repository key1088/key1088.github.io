title: 测试PEM密钥文件是否匹配代码
categories: [程序设计,C编程]
tags: []
date: 2013-04-13 12:58:47
---
工作中一直用过很多密钥，有时候为了验证密钥对很麻烦所以用openssl API写了一个小工具
实际上openssl命令也可以验证的，太麻烦了。
密钥生成（PEM格式）
<pr>
openssl genrsa -out test.key 1024
openssl rsa -in test.key -pubout -out test_pub.key
</pre>
<pre>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <openssl/rsa.h>
#include <openssl/pem.h>
#include <openssl/err.h>
char* my_encrypt(char *, char *);
char* my_decrypt(char *, char *);
//  FunName:测试密钥文件是否匹配
//  Date:20130314
//  shell>gcc -o test test.c -lcrypto
int main(int argc, char **argv)
{
char *str="I Love You";
char *ptr_en, *ptr_de;
char *rsafile, *rsapubfile;
if ( argc < 2) {
printf("Uages: %s id_rsa  id_rsa_pubn", argv[0]);
return -1;
}
rsafile=argv[2];
rsapubfile=argv[1];
ptr_en=my_encrypt(str,rsafile);
ptr_de=my_decrypt(ptr_en,rsapubfile);
if(ptr_en==NULL | ptr_de==NULL) {
printf("encrypt or decrtpt file NOT RSA FILEn");
return -1;
}
if(memcmp(str,ptr_de,strlen(str))==0) {
printf("rsa_file ok!!!!n");
}else{
printf("rsa_file err!!!n");
}
return 0;
}
char *my_encrypt(char *str, char *path_key)
{
char *p_en;
RSA *p_rsa;
FILE *file;
int flen, rsa_len;
if((file=fopen(path_key,"r"))==NULL){
perror("open key file error");
return NULL;
}
//if((p_rsa=PEM_read_RSAPublicKey(file,NULL,NULL,NULL))==NULL) {
          if((p_rsa=PEM_read_RSA_PUBKEY(file,NULL,NULL,NULL))==NULL){
ERR_print_errors_fp(stdout);
    return NULL;
}
flen=strlen(str);
rsa_len=RSA_size(p_rsa);
p_en=(unsigned char*)malloc(rsa_len + 1);
memset(p_en,0,rsa_len+1);
if(RSA_public_encrypt(rsa_len,(unsigned char*)str,(unsigned char*)p_en,p_rsa,RSA_NO_PADDING) < 0) {
return NULL;
}
RSA_free(p_rsa);
fclose(file);
return p_en;
}
char *my_decrypt(char *str,char *path_key)
{
char *p_de;
RSA *p_rsa;
FILE *file;
int flen,rsa_len;
if((file=fopen(path_key,"r"))==NULL) {
perror("open key file error");
return NULL;
}
if((p_rsa=PEM_read_RSAPrivateKey(file,NULL,NULL,NULL))==NULL) {
ERR_print_errors_fp(stdout);
return NULL;
}
rsa_len=RSA_size(p_rsa);
p_de=(unsigned char *)malloc(rsa_len + 1);
memset(p_de,0, rsa_len + 1);
if(RSA_private_decrypt(rsa_len,(unsigned char*)str,(unsigned char*)p_de,p_rsa,RSA_NO_PADDING) < 0) {
return NULL;
}
RSA_free(p_rsa);
fclose(file);
return p_de;
}
</pre>