title: 源码搭建CA服务器,证书可申请、吊销
categories: [网络安全,Linux]
tags: []
date: 2016-09-04 16:41:57
---
现在越来越多的项目在设计的过程中会很注重网络安全，银行金融业和监管机构之间一般采用金融城域网专线连接，在链路上面也使用CA数字证书，一般金融业的CA证书都是CFCA颁发，或者使用制定型号的 加密机。本章主要介绍一下CA服务器的搭建、证书的申请和吊销（也可以自己做加密机），后续有时间会写一下关于程序中怎么使用CA证书进行安全校验的。
<strong>openssl安装：
</strong>
先来介绍一下openssl的安装，一般LINUX发行版都会自带openssl工具，裁剪系统中一般自己来编译安装。
我们的编译和测试环境如下：
<pre>
key1088@key1088-host:~$ uname -a
Linux key1088-host 4.4.0-36-generic #55-Ubuntu SMP Thu Aug 11 18:01:55 UTC 2016 x86_64 x86_64 x86_64 GNU/Linux
key1088@key1088-host:~$ gcc --version
gcc (Ubuntu 5.4.0-6ubuntu1~16.04.2) 5.4.0 20160609
Copyright (C) 2015 Free Software Foundation, Inc.
This is free software; see the source for copying conditions.  There is NO
warranty; not even for MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
</pre>
1.下载openssl源代码
https://www.openssl.org/
<pre>
wget https://www.openssl.org/source/openssl-1.1.0.tar.gz
</pre>
2.编译安装
<pre>
tar xvf openssl-1.1.0.tar.gz
cd openssl-1.1.0
./config
make
</pre>
咱们这次就不make install了，就在这个目录下面操作了，需要临时设置一下环境变量
这个版本默认编译出来静态bin文件在apps下面
<pre>
-rw-rw-r-- 1 key1088 key1088    911 9月   4 13:49 x509.d
-rwxrwxr-x 1 key1088 key1088 680616 9月   4 13:49 openssl
-rwxrwxr-x 1 key1088 key1088   6755 9月   4 13:50 CA.pl
-rwxrwxr-x 1 key1088 key1088   6613 9月   4 13:50 tsget
</pre>
3.环境变量设置
<pre>
key1088@key1088-host:~/openssl-1.1.0/apps$ ./openssl version
./openssl: error while loading shared libraries: libssl.so.1.1: cannot open shared object file: No such file or directory
key1088@key1088-host:~/openssl-1.1.0/apps$ LD_LIBRARY_PATH=$LD_LIBRARY_PATH:$HOME/openssl-1.1.0
key1088@key1088-host:~/openssl-1.1.0/apps$ export LD_LIBRARY_PATH
key1088@key1088-host:~/openssl-1.1.0/apps$ ./openssl versionOpenSSL 1.1.0  25 Aug 2016
</pre>
出现版本号就证明环境变量设置正确，openssl可以用了。
<strong>
CA服务器证书生成：
</strong>
CA（Certificate Authority）证书颁发机构主要负责证书的颁发、管理以及归档和吊销。证书内包含了拥有证书者的姓名、地址、电子邮件帐号、公钥、证书有效期、发放证书的CA、CA的数字签名等信息。证书主要有三大功能：加密、签名、身份验证。
所有的操作默认在openssl-1.1.0目录下进行
2.生成CA密钥
<pre>
mkdir -p CA/private
key1088@key1088-host:~/openssl-1.1.0$ (umask 077;./apps/openssl genrsa -out CA/private/cakey.pem 2048)
Generating RSA private key, 2048 bit long modulus
.................................+++
..........+++
unable to write 'random state'
e is 65537 (0x010001)
</pre>
如果出现这个“unable to write 'random state'”设置一下环境变量即可
<pre>
key1088@key1088-host:~/openssl-1.1.0$ export RANDFILE=$HOME/.rnd
key1088@key1088-host:~/openssl-1.1.0$ (umask 077;./apps/openssl genrsa -out CA/private/cakey.pem 2048)
Generating RSA private key, 2048 bit long modulus
.................................+++
.....................................................................................+++
e is 65537 (0x010001)
</pre>
2.生成自签名证书
创建配置文件目录
<pre>
mkdir etc
cp apps/openssl.cnf etc
</pre>
为了简化证书制作过程中的输入 修改了etc/openssl.cnf，修改对比内容如下
<pre>
key1088@key1088-host:~/openssl-1.1.0$ diff etc/openssl.cnf apps/openssl.cnf
42c42
< dir		= ./CA		# Where everything is kept
---
> dir		= ./demoCA		# Where everything is kept
129c129
< countryName_default		= CN
---
> countryName_default		= AU
134c134
< stateOrProvinceName_default	= BJ
---
> stateOrProvinceName_default	= Some-State
139c139
< 0.organizationName_default	= key1088.info
---
> 0.organizationName_default	= Internet Widgits Pty Ltd
151c151
< emailAddress			= key1088@163.com
---
> emailAddress			= Email Address
</pre>
根据密钥生存证书
<pre>
key1088@key1088-host:~/openssl-1.1.0$ ./apps/openssl req -new -x509 -key CA/private/cakey.pem -out CA/cacert.pem -days 1000 -config etc/openssl.cnf
You are about to be asked to enter information that will be incorporated
into your certificate request.
What you are about to enter is what is called a Distinguished Name or a DN.
There are quite a few fields but you can leave some blank
For some fields there will be a default value,
If you enter '.', the field will be left blank.
-----
Country Name (2 letter code) [CN]:
State or Province Name (full name) [BJ]:
Locality Name (eg, city) []:
Organization Name (eg, company) [key1088.info]:
Organizational Unit Name (eg, section) []:
Common Name (e.g. server FQDN or YOUR name) []:key1088
key1088@163.com []:
</pre>
创建CA服务器所需文件
<pre>
key1088@key1088-host:~/openssl-1.1.0$ touch CA/{index.txt,serial}
key1088@key1088-host:~/openssl-1.1.0$ ls -l CA/
总用量 8
-rw-rw-r-- 1 key1088 key1088 1176 9月   4 14:07 cacert.pem
-rw-rw-r-- 1 key1088 key1088    0 9月   4 14:09 index.txt
drwxrwxr-x 2 key1088 key1088 4096 9月   4 13:57 private
-rw-rw-r-- 1 key1088 key1088    0 9月   4 14:09 serial
</pre>
证书序号开始值设置
<pre>
key1088@key1088-host:~/openssl-1.1.0$ echo "01" > CA/serial
</pre>
3.生成客户端证书，也称为节点证书。
<pre>
key1088@key1088-host:~/openssl-1.1.0$ (umask 077;./apps/openssl genrsa -out CA/client/c01.key 2048)
Generating RSA private key, 2048 bit long modulus
............+++
................................................................................................+++
e is 65537 (0x10001)
key1088@key1088-host:~/openssl-1.1.0$ ./apps/openssl req -new -key CA/client/c01.key -out CA/client/c01.csr -config etc/openssl.cnf
You are about to be asked to enter information that will be incorporated
into your certificate request.
What you are about to enter is what is called a Distinguished Name or a DN.
There are quite a few fields but you can leave some blank
For some fields there will be a default value,
If you enter '.', the field will be left blank.
-----
Country Name (2 letter code) [CN]:
State or Province Name (full name) [BJ]:
Locality Name (eg, city) []:
Organization Name (eg, company) [key1088.info]:
Organizational Unit Name (eg, section) []:
Common Name (e.g. server FQDN or YOUR name) []:c01		#此处不能和CA中的名称相同
key1088@163.com []:
Please enter the following 'extra' attributes
to be sent with your certificate request
A challenge password []:1234
An optional company name []:1234
</pre>
4.部署到CA中
<pre>
mkdir -p CA/newcerts
key1088@key1088-host:~/openssl-1.1.0$ ./apps/openssl ca -in CA/client/c01.csr -out CA/client/c01.crt -days 1000 -config etc/openssl.cnf
Using configuration from etc/openssl.cnf
Can't open ./CA/index.txt.attr for reading, No such file or directory
140399448418048:error:02001002:system library:fopen:No such file or directory:crypto/bio/bss_file.c:74:fopen('./CA/index.txt.attr','r')
140399448418048:error:2006D080:BIO routines:BIO_new_file:no such file:crypto/bio/bss_file.c:77:
Check that the request matches the signature
Signature ok
Certificate Details:
        Serial Number: 1 (0x1)
        Validity
            Not Before: Sep  4 06:58:17 2016 GMT
            Not After : Jun  1 06:58:17 2019 GMT
        Subject:
            countryName               = CN
            stateOrProvinceName       = BJ
            organizationName          = key1088.info
            commonName                = c01
        X509v3 extensions:
            X509v3 Basic Constraints:
                CA:FALSE
            Netscape Comment:
                OpenSSL Generated Certificate
            X509v3 Subject Key Identifier:
                AB:F4:CB:4F:13:28:F8:5D:A7:DB:A0:E3:F3:52:86:C1:25:D1:EB:A0
            X509v3 Authority Key Identifier:
                keyid:68:82:F2:71:02:9C:92:00:F4:05:72:30:24:97:6B:80:2E:69:AF:EA
Certificate is to be certified until Jun  1 06:58:17 2019 GMT (1000 days)
Sign the certificate? [y/n]:y
1 out of 1 certificate requests certified, commit? [y/n]y
Write out database with 1 new entries
Data Base Updated
key1088@key1088-host:~/openssl-1.1.0$ du -a CA/
8	CA/newcerts/01.pem		        #自动生成的PEM文件，按照序号命名
12	CA/newcerts
4	CA/private/cakey.pem
8	CA/private
4	CA/serial
4	CA/serial.old
0	CA/index.txt.old
4	CA/cacert.pem
4	CA/index.txt
8	CA/client/c01.crt			#生成的证书
4	CA/client/c01.key
4	CA/client/c01.csr
20	CA/client
4	CA/index.txt.attr
64	CA/
</pre>
openssl自带的样例：
openssl-1.1.0/apps/demoCA/下面的内容
5.转换给pfx格式（可选）
<pre>
key1088@key1088-host:~/openssl-1.1.0$ ./apps/openssl pkcs12 -export -clcerts -in CA/client/c01.crt -inkey CA/client/c01.key -out CA/client/c01.pfx
Enter Export Password:					#12345678
Verifying - Enter Export Password:		#同上
</pre>
pfx文件包含数字签名证书和私钥，可以进行密钥转移，也可以导入到浏览器中查看。
6.验证证书是否正确
<pre>
key1088@key1088-host:~/openssl-1.1.0$ ./apps/openssl verify -CAfile CA/cacert.pem  CA/client/c01.crt
CA/client/c01.crt: OK
</pre>
<strong>吊销证书
</strong>
1.查看客户端证书序号
<pre>
key1088@key1088-host:~/openssl-1.1.0$ ./apps/openssl x509 -in CA/client/c01.crt -noout -serial -subject
serial=01
subject=C = CN, ST = BJ, O = key1088.info, CN = c01
</pre>
2.吊销证书
<pre>
key1088@key1088-host:~/openssl-1.1.0$ ./apps/openssl ca -revoke CA/newcerts/01.pem -config etc/openssl.cnf
Using configuration from etc/openssl.cnf
Revoking Certificate 01.
Data Base Updated
</pre>
3.生成吊销列表
<pre>
key1088@key1088-host:~/openssl-1.1.0$ echo "01" > CA/crlnumber
key1088@key1088-host:~/openssl-1.1.0$ ./apps/openssl ca -gencrl -out CA/all.crl -config etc/openssl.cnf
Using configuration from etc/openssl.cnf
</pre>
4.查看吊销
<pre>
key1088@key1088-host:~/openssl-1.1.0$ ./apps/openssl crl -in CA/all.crl -noout -text
Certificate Revocation List (CRL):
        Version 2 (0x1)
    Signature Algorithm: sha256WithRSAEncryption
        Issuer: /C=CN/ST=BJ/O=key1088.info/CN=key1088
        Last Update: Sep  4 07:37:17 2016 GMT
        Next Update: Oct  4 07:37:17 2016 GMT
        CRL extensions:
            X509v3 CRL Number:
                1
Revoked Certificates:
    Serial Number: 01
        Revocation Date: Sep  4 07:34:48 2016 GMT
    Signature Algorithm: sha256WithRSAEncryption
         a7:98:6c:8f:77:d2:52:6a:57:eb:27:75:6f:17:eb:3c:30:19:
         78:bb:4f:77:aa:94:74:28:e5:7a:05:38:8d:03:6c:7c:8f:63:
         de:a9:fd:d3:ed:77:70:7d:24:9a:b9:da:42:05:9b:d1:73:92:
         6c:0c:13:88:16:16:d7:e1:4f:6f:62:90:8a:11:b1:c5:b7:80:
         c8:6c:76:e5:d2:eb:a9:f4:ee:da:85:56:9e:f2:97:02:43:ef:
         3d:ea:77:af:5b:f1:ed:4b:39:c7:7e:9c:22:62:91:ee:17:30:
         10:d2:49:82:9a:0d:9c:0c:ad:63:1e:cb:30:33:f0:5f:55:dc:
         b6:6c:70:61:82:ba:e0:d3:98:96:f3:3d:8b:0c:02:0d:fd:ac:
         61:e5:24:46:a0:52:94:05:f4:a9:a8:8b:25:40:db:a4:e5:58:
         4f:bd:37:1d:44:87:f1:3f:f9:06:d5:47:aa:0c:8f:1e:ba:d6:
         99:ef:f7:77:e0:af:05:a3:08:78:06:0f:e2:6a:a4:cd:ac:1a:
         45:d3:18:9a:18:25:ee:c3:7b:66:51:77:52:64:5e:4a:81:9e:
         84:be:16:bc:da:7d:83:7b:49:d1:5a:0f:4f:02:e4:fa:fb:80:
         53:7f:7f:72:02:17:31:25:c6:6e:cc:1e:4f:7e:9c:f4:ae:d1:
         85:a2:6a:d6
key1088@key1088-host:~/openssl-1.1.0$ cat CA/serial
03
key1088@key1088-host:~/openssl-1.1.0$ cat CA/crlnumber
02
key1088@key1088-host:~/openssl-1.1.0$ cat CA/index.txt
R	190601065817Z	160904073448Z	01	unknown	/C=CN/ST=BJ/O=key1088.info/CN=c01
V	190601073145Z		02	unknown	/C=CN/ST=BJ/O=key1088.info/CN=c02
key1088@key1088-host:~/openssl-1.1.0$ cat CA/index.txt.old
V	190601065817Z		01	unknown	/C=CN/ST=BJ/O=key1088.info/CN=c01
V	190601073145Z		02	unknown	/C=CN/ST=BJ/O=key1088.info/CN=c02
</pre>
5.验证吊销的证书和正常使用的证书
<pre>
key1088@key1088-host:~/openssl-1.1.0$ ./apps/openssl  verify -crl_check -CRLfile CA/all.crl -CAfile CA/cacert.pem CA/client/c01.crt
C = CN, ST = BJ, O = key1088.info, CN = c01
error 23 at 0 depth lookup: certificate revoked
error CA/client/c01.crt: verification failed
</pre>
再新生成一个02的证书验证一下，验证结果。
key1088@key1088-host:~/openssl-1.1.0$ ./apps/openssl  verify -crl_check -CRLfile CA/all.crl -CAfile CA/cacert.pem CA/client/c02.crt
CA/client/c02.crt: OK
参考文章：
http://www.yunweipai.com/archives/4513.html%20r
http://raymii.org/s/articles/OpenSSL_manually_verify_a_certificate_against_a_CRL.html
