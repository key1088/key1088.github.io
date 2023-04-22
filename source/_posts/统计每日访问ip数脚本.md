title: 统计每日访问ip数脚本
categories: [Shell编程]
tags: []
date: 2011-09-06 09:40:00
---
<p>#!/bin/bash</p><p>by:key1088</p><p>time1=`date -d '-1 days' +%d/%b/%Y`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #昨天的时间，与apache日志时间一样的格式<br />time2=`date +%Y%m%d -d '-1 days'`&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #昨天的时间，年月日&nbsp; 例：2011/02/11<br />echo $time2 &gt;&gt; /stats/ipstream<br />awk -v day=&quot;$time1&quot; '$4~day{print}' /usr/local/apache/logs/access_log|awk '{print $1}'|sort|uniq|wc -l &gt;&gt; /stats/ipstream</p>