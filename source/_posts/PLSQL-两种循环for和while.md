title: PLSQL 两种循环for和while
categories: [Oracle,数据库]
tags: []
date: 2013-11-19 23:01:18
---
第一种 while
<pre>
declare
i number;
begin
i:=0;
while i<=100 loop
Dbms_Output.put_line('i=' || i);
i:=i+1;
end loop;
end;
</pre>
第二种 for
<pre>
begin
for i in 1..100 loop
Dbms_Output.put_line('i=' || i);
end loop;
commit;
end;
</pre>
第三种 也可以直接使用loop( 死循环，游标中使用)
<pre>
declare
i number;
begin
i:=0;
loop
Dbms_Output.put_line('i=' || i);
i:=i+1;
end loop;
commit;
end;
</pre>