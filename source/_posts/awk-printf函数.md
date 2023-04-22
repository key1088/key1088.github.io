title: awk printf函数
categories: [Shell编程]
tags: []
date: 2012-03-20 10:10:00
---
<p>awkprintf感觉很好用，print好用多了。</p><p>和c的printf用法一样。</p><p>awk -F# '{printf(&quot;insert into info values(&quot;%s&quot;,&quot;%s&quot;,&quot;%s&quot;);n&quot;, $1, $2, $3)}' sqlfile.sql</p><p>&nbsp;</p><p>度娘，你的编辑器啥时候好用啊。</p>