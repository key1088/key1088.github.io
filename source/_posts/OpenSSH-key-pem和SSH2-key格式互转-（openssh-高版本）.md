title: OpenSSH key pem和SSH2 key格式互转 （openssh 高版本）
categories: [网络安全]
tags: 
date: 2013-05-08 23:29:58
---
openssl genkey 和 ssk-keygen  密钥的格式是不一样的
“RFC4716” (RFC 4716/SSH2 public or private key)
“PKCS8” (PEM PKCS8 public key)
ubuntu:
ssh-keygen -e -f ~/.ssh/id_rsa.pub > ~/.ssh/id_rsa_pub.pem
ssh-keygen  -f ~/.ssh/id_rsa_pub.pem -i -m RFC4716 > ~/.ssh/id_rsa.pub
windows:
1)Use the puttyGen
2) Run puttygen and click generate
3) Run your mouse round the blank part for a while.
4) Enter a keyphrase (and repeat)
5) Click save public key and save it <path>publickey
6) Click save private key and save it <path>privatekey (extension gets added automatically, this is no good for spoon, but good for putty)
7) Click Conversions->Export OpenSSH key and save as <path>sshkey.pem
8) In the main window is you key for pasting into OpenSSH authorized_keys file. Copy this in its entirety and past it into your ubuntu machine in /home/<user>/.ssh/authorized_keys file.
9) Ok, you can close putty key generator.
10) Utilize the .pem in the tool.
http://www.yinqisen.cn/blog-177.html