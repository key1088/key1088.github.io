title: openshift 备份MYSQL数据库
categories: [数据库]
tags: [backup,mysql,openshift,paas]
date: 2013-04-13 15:55:39
---
openshift paas
<pre>
mysqldump --password=$OPENSHIFT_DB_PASSWORD -h $OPENSHIFT_DB_HOST -P $OPENSHIFT_DB_PORT -u $OPENSHIFT_DB_USERNAME $OPENSHIFT_GEAR_NAME --add-drop-table >  $OPENSHIFT_DATA_DIR/$OPENSHIFT_GEAR_NAME.sql
</pre>