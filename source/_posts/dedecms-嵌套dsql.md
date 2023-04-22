title: dedecms 嵌套dsql
categories: [程序设计,Php编程]
tags: []
date: 2016-02-13 13:15:08
---
织梦CMS中嵌套查询语句,SetQuery和GetObject传入不同的参数就可以了。
<pre>
if($keyword != '')
{
	$query2 = "SELECT id,title,typeid FROM `#@__archives` where arcrank>-1 AND ($keyword) ORDER BY id desc limit 0,5";
}
else
{
	$query2 = "SELECT id,title,typeid FROM `#@__archives` where arcrank>-1 ORDER BY id desc limit 0,5";
}
$dsql->SetQuery($query2);
$dsql->Execute(1);
while($row=$dsql->GetObject(1))
{
	$dsql->SetQuery("Select typedir From `#@__arctype` where id='$row->typeid'");
	$dsql->Execute(2);
	$ttrow=$dsql->GetObject(2);
	$tpdir=substr($ttrow->typedir,10);
	$likearticle .= "<li><a href='/m/article/{$tpdir}/{$row->id}.html'>".cut_str(ConvertStr($row->title),16)."</a></li>";
}
</pre>