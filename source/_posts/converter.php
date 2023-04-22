<?php
// 运行 php converter.php
$db = new mysqli();
// 根据实际情况更改
$db->connect('localhost','wordpress','wordpress','wordpress');
$prefix = 'typecho_';
$sql = <<<TEXT
select cid,title,text,created,category from typecho_contents t1,
(select cid id,group_concat(m.name)  category from typecho_metas m,typecho_relationships r where m.mid=r.mid and m.type='category' group by cid) t2
where t1.cid=t2.id 
TEXT;
$res = $db->query($sql);
$tags="";
if ($res) {
    if ($res->num_rows > 0) {
        while ($r = $res->fetch_object()) {
            $_c = @date('Y-m-d H:i:s', $r->created);
            $_t = str_replace('<!--markdown-->', '', $r->text);
            $tagsql= "select  group_concat(m.name) tag from typecho_metas m,typecho_relationships r where m.mid=r.mid and m.type='tag' and cid={$r->cid} group by cid";
            #echo "tagsql={$tagsql}";
            echo "cid={$r->cid}";
            $tagres = $db->query($tagsql);
            if($tagres){
                $r_tags=$tagres->fetch_object();
		if($r_tags)
			$tags=$r_tags->tag;
		else
		 	$tags="";
            }else{
                $tags="";
            }
            echo "tags={$tags}";
            $_tmp = <<<TMP
title: {$r->title}
categories: [{$r->category}]
tags: [{$tags}]
date: {$_c}
---
{$_t}
TMP;
            // windows下把文件名从UTF-8编码转换为GBK编码，避免出现生成的文件名为乱码的情况
            if (strpos(PHP_OS, "WIN") !== false) {
                $name = iconv("UTF-8", "GBK//IGNORE", $r->title);
                echo $name.'<br>';
            } else {
                $name = $r->title;
				echo $name.'<br>';
            }
            // 替换不合法文件名字符
            file_put_contents(str_replace(array(" ", "?", "\\", "/", ":", "|", "*"), '-', $name) . ".md", $_tmp);
        }
    }
    $res->free();
}
$db->close();
