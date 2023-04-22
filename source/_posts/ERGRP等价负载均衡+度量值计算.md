title: ERGRP等价负载均衡+度量值计算
categories: [网络工程]
tags: []
date: 2010-03-29 19:58:00
---
试验拓扑：
<img src="/images/pic/c42f172187e85a924723e872.jpg" alt="" />
如图用eigrp配置全网络，通。
该网络本身就是非等价负载网络。
查看个路由器状态
R1#sh ip route
C    192.168.1.0/24 is directly connected, FastEthernet0/1
C    192.168.2.0/24 is directly connected, FastEthernet0/0
D    192.168.3.0/24 [90/284160] via 192.168.1.2, 00:16:03, FastEthernet0/1
R1#R1#sh ip ei topology
IP-EIGRP Topology Table for AS(1)/ID(1.1.1.1)
Codes: P - Passive, A - Active, U - Update, Q - Query, R - Reply,
r - Reply status
P 192.168.1.0/24, 1 successors, FD is 28160
via Connected, FastEthernet0/1
P 192.168.2.0/24, 1 successors, FD is 281600
via Connected, FastEthernet0/0
P 192.168.3.0/24, 1 successors, FD is 284160
via 192.168.1.2 (284160/281600), FastEthernet0/1
via 192.168.2.2 (537600/281600), FastEthernet0/0
R2#sh ip route
C    192.168.1.0/24 is directly connected, Ethernet1/0
D    192.168.2.0/24 [90/307200] via 192.168.3.1, 00:17:19, Ethernet1/2
C    192.168.3.0/24 is directly connected, Ethernet1/2
R2#
R2#sh ip ei to
IP-EIGRP Topology Table for AS(1)/ID(2.2.2.2)
Codes: P - Passive, A - Active, U - Update, Q - Query, R - Reply,
r - Reply status
P 192.168.1.0/24, 1 successors, FD is 281600
via Connected, Ethernet1/0
P 192.168.2.0/24, 1 successors, FD is 284160
via 192.168.3.1 (307200/281600), Ethernet1/2
via 192.168.1.1 (537600/281600), Ethernet1/0, serno 31
P 192.168.3.0/24, 1 successors, FD is 281600
via Connected, Ethernet1/2
R3#sh ip route
D    192.168.1.0/24 [90/284160] via 192.168.2.1, 00:18:01, Ethernet1/0
C    192.168.2.0/24 is directly connected, Ethernet1/0
C    192.168.3.0/24 is directly connected, Ethernet1/1
R3#sh ip eigrp topology
IP-EIGRP Topology Table for AS(1)/ID(192.168.3.1)
Codes: P - Passive, A - Active, U - Update, Q - Query, R - Reply,
r - Reply status
P 192.168.1.0/24, 1 successors, FD is 284160
via 192.168.2.1 (284160/28160), Ethernet1/0
via 192.168.3.2 (307200/281600), Ethernet1/1
P 192.168.2.0/24, 1 successors, FD is 281600
via Connected, Ethernet1/0
P 192.168.3.0/24, 1 successors, FD is 281600
via Connected, Ethernet1/1
就拿R3的topology来说
P 192.168.1.0/24, 1 successors, FD is 284160
via 192.168.2.1 (284160/28160), Ethernet1/0
via 192.168.3.2 (307200/281600), Ethernet1/1
根据度量值公式来算，本博客有，上一遍就是。
求入口带宽最小的，就是R3学到192.168.1.0的更新入端口。第一条线：R1的F0/1和R3的E1/0。第二条线：R1的E1/0和R3的E1/1。
我们来计算一下
首先查去以上端口的BW和延迟，只取重要的啦。
第一条线路
R1#sh inter f0/1
FastEthernet0/1 is up, line protocol is up
Hardware is AmdFE, address is c800.0d2c.0001 (bia c800.0d2c.0001)
Internet address is 192.168.1.1/24
MTU 1500 bytes, BW 100000 Kbit, DLY 100 usec,
reliability 255/255, txload 1/255, rxload 1/255
Encapsulation ARPA, loopback not set
Keepalive set (10 sec)
Half-duplex, 100Mb/s, 100BaseTX/FX
R3#sh inter e1/0
Ethernet1/0 is up, line protocol is up
Hardware is AmdP2, address is c804.0d2c.0010 (bia c804.0d2c.0010)
Internet address is 192.168.2.2/24
MTU 1500 bytes, BW 10000 Kbit, DLY 1000 usec,
reliability 255/255, txload 1/255, rxload 1/255
Encapsulation ARPA, loopback not set
Keepalive set (10 sec)
ARP type: ARPA, ARP Timeout 04:00:00
[10^7/10000+(1000+100)/10]*256=284160
第二条线路
R2#sh inter e1/0
Ethernet1/0 is up, line protocol is up
Hardware is AmdP2, address is c801.0d2c.0010 (bia c801.0d2c.0010)
Internet address is 192.168.1.2/24
MTU 1500 bytes, BW 10000 Kbit, DLY 1000 usec,
reliability 255/255, txload 1/255, rxload 1/255
Encapsulation ARPA, loopback not set
Keepalive set (10 sec)
ARP type: ARPA, ARP Timeout 04:00:00
R3#sh inter e1/1
Ethernet1/1 is up, line protocol is up
Hardware is AmdP2, address is c804.0d2c.0011 (bia c804.0d2c.0011)
Internet address is 192.168.3.1/24
MTU 1500 bytes, BW 10000 Kbit, DLY 1000 usec,
reliability 255/255, txload 1/255, rxload 1/255
Encapsulation ARPA, loopback not set
Keepalive set (10 sec)
ARP type: ARPA, ARP Timeout 04:00:00
[10^7/10000+(1000+1000)/10]*256=307200
只要要两个度量值相同，就可以形成等价负载均衡。
进入R1 接口F0/1中把延迟改为1000就可以了。
R1(config-if)#delay 100
（注意DLY的单位是usec，在配置时，改成delay 100就可以，查看就变成1000usec了，单位问题）
在不同的环境中，也可以改带宽，设置的带宽并不是物理的，bandwidth 命令只会修改 EIGRP 和 OSPF 等路由协议所用的带宽度量。今天才知道，很郁闷。
来看下路由表吧。
R3#sh ip route
D    192.168.1.0/24 [90/307200] via 192.168.3.2, 00:07:51, Ethernet1/1
[90/307200] via 192.168.2.1, 00:07:51, Ethernet1/0
C    192.168.2.0/24 is directly connected, Ethernet1/0
C    192.168.3.0/24 is directly connected, Ethernet1/1
&nbsp;