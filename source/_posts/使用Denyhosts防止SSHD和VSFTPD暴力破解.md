title: 使用Denyhosts防止SSHD和VSFTPD暴力破解
categories: [网络安全]
tags: []
date: 2015-11-21 22:23:01
---
Denyhosts防止暴力破解主要是根据登录的日志/var/log/secure（centos为例），登录失败次数超过一定的阀值将IP写入/etc/hosts.deny文件中。文件格式如下：
<pre>
#服务名称：ip地址
sshd: 180.97.239.49
ALL: 180.78.180.186
</pre>
Denyhosts是专门用于防止SSHD登录，默认也是防止sshd登录的配置；如果想让vsftpd也添加一个安全的墙，需要在配置中添加以下信息，主要是格式化了匹配的正则表达式。
<pre>
denyhosts.cfg：
SSHD_FORMAT_REGEX=.* (sshd.*:|[sshd]|vsftpd.*:) (?P<message>.*)
USERDEF_FAILED_ENTRY_REGEX=authentication failure.* ruser=(?P<user>S+) rhost=(?P<host>S+)
BLOCK_SERVICE  = ALL
</pre>
修改后，需要重启denghosts服务。
vsftpd如果使用这种机制需要开启tcp_wrappers（默认是开启的）
<pre>
tcp_wrappers=YES
</pre>