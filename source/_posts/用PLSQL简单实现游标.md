title: 用PLSQL简单实现游标
categories: [Oracle,数据库]
tags: []
date: 2013-11-19 22:44:42
---
PLSQL编程简单实现游标
<pre>
declare
v_userid   t_eb_user.userid%TYPE;
v_username t_eb_user.username%TYPE;
cursor emp_cursor is
 select a.userid,a.username from t_eb_user a, t_eb_tables b where a.userid=b.userid;
begin
  open emp_cursor;
LOOP
  FETCH emp_cursor INTO v_userid, v_username;
  EXIT WHEN emp_cursor%NOTFOUND;
  dbms_output.put_line(v_userid||' '||v_username);
END LOOP;
end;
</pre>