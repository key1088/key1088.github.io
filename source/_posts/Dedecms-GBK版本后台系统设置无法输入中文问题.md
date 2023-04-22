title: Dedecms GBK版本后台系统设置无法输入中文问题
categories: [程序设计,Php编程]
tags: []
date: 2015-06-13 22:20:24
---
最近用dedecms搭建了一个简单的站，主要用于测试。发现在后台系统-系统基础参数。很多选项没有办法成功设置中文。
实际上提交已成功，看数据库dede_sysconfig记录已成功插入，应该属于显示问题。看显示代码
<pre>
dede/templets/sys_info.htm:
	echo "<input type='text' name='edit___{$row['varname']}' id='edit___{$row['varname']}' value="".htmlspecialchars($row['value'])."" style='width:80%'>{$addstr}";
</pre>
用于转换html特殊字符，网上查询了一下，是PHP5.4以上版本会有这个问题，必须指定编号类型。需修改为
<pre>
	echo "<input type='text' name='edit___{$row['varname']}' id='edit___{$row['varname']}' value="".htmlspecialchars($row['value'],ENT_COMPAT,'GB2312')."" style='width:80%'>{$addstr}";
</pre>
修改后，再修改系统基础参数就可以显示了。
因为代码中太多类似的代码了，最好还是降低一下php的版本。