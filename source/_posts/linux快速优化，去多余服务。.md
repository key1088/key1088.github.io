title: linux快速优化，去多余服务。
categories: [Linux]
tags: []
date: 2010-12-03 22:32:00
---
#!/bin/sh<p> </p><p>#by:key1088</p>services=`chkconfig --list|cut -f1`<br />for ser in $services<br />do<br /> if [ &quot;$ser&quot; == &quot;network&quot; ]||[ &quot;$ser&quot; == &quot;syslog&quot; ]||[ &quot;$ser&quot; == &quot;sshd&quot; ]||[ &quot;$ser&quot; == &quot;crond&quot; ]||[ &quot;$ser&quot; == &quot;atd&quot; ];<br /> then<br />&nbsp;&nbsp;&nbsp;  chkconfig &quot;$ser&quot; on<br /> else<br />&nbsp;&nbsp;&nbsp;  chkconfig &quot;$ser&quot; off<br /> fi<br />done<br />echo &quot;network success!&quot;<br />echo &quot;syslog sucss!!&quot;<br />echo &quot;sshd success!!!!&quot;<br />echo &quot;crond success!!&quot;<br />echo &quot;atd success!!&quot;<br /><br />