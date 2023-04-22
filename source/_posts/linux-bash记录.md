title: linux bash记录
categories: [Shell编程]
tags: []
date: 2010-09-02 15:18:00
---
kill -9 $(ps aux | grep mysql | grep -v grep | awk '{print $2}')<br /><br />杀掉所有包含mysql的进程。<br />kill 删进程<br />ps aux 列出进程<br />grep 筛选 -v 排除<br />awk 提取，第二空格隔开的文字<br /><br />