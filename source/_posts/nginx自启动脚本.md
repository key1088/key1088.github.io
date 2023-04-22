title: nginx自启动脚本
categories: [Shell编程]
tags: [nginx;脚本]
date: 2013-04-13 12:54:21
---
昨天晚上VPS重启了，NGINX没有起来。于是写了一下脚本，自启动的。
<pre>
cat /etc/init.d/nginx
#!/bin/sh
#
# nginx       This shell script takes care of starting and stopping
#               the nginx.
#
# chkconfig: - 64 36
# description:  nginx.
# processname: nginx
# config: /usr/local/nginx/conf/nginx
# pidfile: /usr/local/nginx/logs/nginx.pid
if [ -f /etc/init.d/functions ]
then
. /etc/init.d/functions
elif [ -f /etc/rc.d/init.d/functions ]
then
. /etc/rc.d/init.d/functions
else
exit 0
fi
nginx=/usr/local/nginx/sbin/nginx
conf=/usr/local/nginx/conf/nginx
prog=nginx
RETVAL=0
start() {
if [ -n "`/sbin/pidof $prog`" ]
then
echo "$prog: already running"
return 1
fi
echo "Starting $prog:"
base=$prog
$nginx
if [ -z "`/sbin/pidof $prog`" ]
then
RETVAL=1
fi
if [ $RETVAL -ne 0 ]
then
echo "Startup failure"
else
echo "Startup success"
fi
return $RETVAL
}
reload() {
if [ -z "`/sbin/pidof $prog`" ]
then
RETVAL=1
fi
if [ $RETVAL -ne 0 ]
then
echo "nginx no have run"
else
echo "reload nginx config"
$nginx -s reload
RETVAL=$?
if [ $RETVAL -ne 0 ]
then
echo "reload nginx config failure"
else
echo "reload nginx config success"
fi
fi
}
stop() {
if [ -z "`/sbin/pidof $prog`" ]
then
RETVAL=1
fi
if [ $RETVAL -ne 0 ]
then
echo "nginx no have run"
else
echo "Stopping $prog:"
$nginx -s stop
RETVAL=$?
if [ $RETVAL -ne 0 ]
then
echo "Shutdown failure"
else
echo "Shutdown success"
fi
fi
}
case "$1" in
start)
start
;;
stop)
stop
;;
status)
status $nginx
RETVAL=$?
;;
restart)
stop
start
;;
reload)
reload
;;
*)
echo "Usage: $prog {start|stop|restart|status|reload}"
exit 1
esac
exit $RETVAL
添加权限和添加自启动
[root@key1088 init.d]# chmod 755 nginx
[root@key1088 init.d]# chkconfig --add nginx
[root@key1088 init.d]# chkconfig --list nginx
nginx           0:off   1:off   2:off   3:off   4:off   5:off   6:off
[root@key1088 init.d]# chkconfig --level 235 nginx on
[root@key1088 init.d]# chkconfig --list nginx
nginx           0:off   1:off   2:on    3:on    4:off   5:on    6:off
</pre>