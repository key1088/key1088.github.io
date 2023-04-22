title: 解决树莓派SSH登录和输入卡顿，试了很多方法
categories: [操作系统]
tags: []
date: 2020-11-21 14:53:39
---
关于树莓派SSH登录和输入卡顿的原因，各种说法都有，多数都说是dns的问题和GSSAPI的问题，试过了都不行，找到一个关于IPQoS 的方法，设置后解决了。

/etc/ssh/sshd_config最后追加
<code>
IPQoS cs0 cs0
</code>

IPQoS的解释
对应的服务	IPv4优先级/ EXP / 802.1P	DSCP(二进制)	DSCP(十进制)	TOS(十六进制)	应用
BE	0	0	0	0	Internet
AF1 Green	1	1010	10	28	Leased Line 
AF2 Green	2	10010	18	48	IPTV VOD
AF3 Green	3	11010	26	68	IPTV Broadcast
AF4 Green	4	100010	34	88	NGN/3G Singaling
EF	5	101110	46	B8	NGN/3G voice
CS6	6	110000	48	C0	Protocol
CS7	7	111000	56	E0	Protocol
