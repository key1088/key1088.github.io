title: MySQL中my.cnf文件选项
categories: [Mysql]
tags: []
date: 2011-04-27 09:23:00
---
MySQL中my.cnf文件选项<br />
mysqld服务器维护两种变量。全局变量影响服务器的全局操作。会话变量影响具体客户端连接相关操作。<br />可以在选项文件或命令行中设置全局变量。<br />用Set命令设置会话变量，当然它也可以设置全局变量。
就像oracle里面的初始化参数文件一样。下面是一些常用的选项说明，MySQL的管方文档上也有。</p><br />
如<br />mysql&gt; SET GLOBAL sort_buffer_size = 10 * 1024 * 1024;<br />mysql&gt; SET SESSION sort_buffer_size = 10 * 1024 * 1024;
如果你想用SET语句限制系统变量可设的最大值，可以在服务器启动时通过--maximum-var_name形式的选项来指定。<br />例如，要想防止query_cache_size的值运行时超过32MB，使用选项--maximum-query_cache_size=32M。
mysqld_safe选项<br />--basedir=path<br />MySQL安装目录的路径。
--core-file-size<br />mysqld能够创建的内核文件的大小。选项值传递给ulimit -c。
--datadir=path<br />数据目录的路径。
--defaults-file=path<br />读取的代替通用选项文件的选项文件名。如果给出，必须首选该选项。
--log-error=path<br />将错误日志写入给定的文件。
-nice=priority<br />使用nice程序根据给定值来设置服务器的调度优先级。
--open-files-limit=count<br />mysqld能够打开的文件的数量。选项值传递给 ulimit -n。请注意你需要用root启动mysqld_safe来保证正确工作！
--pid-file=path<br />进程ID文件的路径。
--port=port_num<br />用来帧听TCP/IP连接的端口号。端口号必须为1024或更大值，除非MySQL以root系统用户运行。<br />每个mysqld的Unix套接字文件和TCP/IP端口号必须不同。
--ledir=path<br />包含mysqld程序的目录的路径。使用该选项来显式表示服务器位置。
--no-defaults<br />不要读任何选项文件。如果给出，必须首选该选项。
--skip-character-set-client-handshake<br />忽略客户端发送的字符集信息，使用服务器的默认字符集。
--socket=path<br />用于本地连接的Unix套接字文件。<br />每个mysqld的Unix套接字文件和TCP/IP端口号必须不同。
--timezone=zone<br />为给定的选项值设置TZ时区环境变量。
--user={user_name | user_id}<br />以用户名user_name或数字用户ID user_id运行mysqld服务器。<br />该&quot;用户&quot;指系统登录账户，而不是 授权表中的MySQL用户。
<br />mysqld命令行选项<br />mysqld从[mysqld]和[server]组读取选项
--ansi<br />使用标准(ANSI)SQL语法代替MySQL语法。
--basedir=path, -b path<br />MySQL安装目录的路径。通常所有路径根据该路径来解析。
--bootstrap<br />mysql_install_db脚本使用该选项来创建MySQL授权表，不需要启动MySQL服务器
--console<br />将错误日志消息写入stderr和stdout，即使指定了--log-error。
--character_sets_dir=path<br />字符集安装的目录。
--chroot=path<br />通过chroot()系统调用在启动过程中将mysqld服务器放入一个封闭环境中。这是推荐的一个安全措施。请注意使用该选项可以 限制LOAD DATA INFILE和SELECT ... INTO OUTFILE。
--character_set_server=charset<br />使用charset作为 默认服务器字符集。
--core_file<br />如果mysqld终止，写内核文件。
--datadir=path, -h path <br />数据目录的路径。
--default_table_type=type<br />设置表的默认类型。
--debug[=debug_options], -# [debug_options]<br />如果MySQL配置了--with-debug，你可以使用该选项来获得一个跟踪文件，跟踪mysqld正进行的操作。debug_options字符串通常为'd:t:o，file_name'。
--default_time_zone=type<br />设置默认服务器时区。该选项设置全局time_zone系统变量。默认时区与系统时区相同(用system_time_zone系统变量值给定)
--delay_key_write[= OFF | ON | ALL]<br />如何使用DELAYED KEYS选项。键写入延迟会造成再次写MyISAM表时键缓冲区不能被清空。该选项只适用MyISAM表。<br />OFF DELAY_KEY_WRITE被忽略。<br />ON MySQL在CREATE TABLE中用DELAY_KEY_WRITE选项。这是 默认值。<br />ALL 用启用DELAY_KEY_WRITE选项创建表的相同方法对所有新打开表的进行处理。<br />如果启用了DELAY_KEY_WRITE，说明使用该项的表的键缓冲区在每次更新索引时不被清空，只有关闭表时才清空。<br />但如果你使用该特性，你应用--myisam_recover选项启动服务器，为所有MyISAM表添加自动检查。
--external_locking<br />用系统锁定。请注意如果你在lockd不能完全工作的系统上使用该选项(例如在Linux中)，mysqld容易死锁。<br />如果你在许多MySQL进程中使用该选项来更新MyISAM表，你必须确保满足下述条件：<br />使用正被另一个进程更新的表的查询的缓存不可使用。<br />不应在共享表中使用--delay-key-write=ALL或DELAY_KEY_WRITE=1。<br />最简单的方法是结合使用--external-locking和--delay-key-write=OFF --query-cache-size=0。<br />(默认不能实现，因为在许多设置中，结合使用上述选项很有用）。
<br />--flush<br />执行SQL语句后向硬盘上清空更改。一般情况执行SQL语句后 MySQL向硬盘写入所有更改，让操作系统处理与硬盘的同步。
<br />--init_file=file<br />启动时从该文件读SQL语句。每个语句必须在同一行中并且不应包括注释。
<br />--language=lang_name, -L lang_name<br />用给定语言给出客户端错误消息。默认情况下，mysqld用英语给出错误消息。
--large_pages<br />一些硬件/操作系统架构支持大于 默认值(通常4 KB)的内存页。实际支持取决于使用的硬件和OS。<br />大量访问内存的应用程序通过 使用较大的页，降低了Translation Lookaside Buffer (TLB)损失，可以改善性能。 <br />默认情况下该选项被禁用。
---log[=file], -l [file]
如果你想要知道mysqld内部发生了什么，你应该用--log[=file_name]或-l [file_name]选项启动它。如果没有给定file_name的值， 默认名是host_name.log。所有连接和语句被记录到日志文件。当你怀疑在客户端发生了错误并想确切地知道该客户端发送给mysqld的语句时，该日志可能非常有用。<br />mysqld按照它接收的顺序记录语句到查询日志。这可能与执行的顺序不同。
--log_bin=[file]<br />二进制日志文件。将更改数据的所有查询记入该文件。用于备份和复制。<br />建议指定一个文件名,否则MySQL使用host_name-bin作为日志文件基本名。<br />运行服务器时若启用二进制日志则性能大约慢1%。
--binlog_do_db=db_name<br />告诉主服务器，如果当前的数据库(即USE选定的数据库)是db_name，应将更新记录到二进制日志中。
--binlog_ignore_db=db_name<br />告诉主服务器，如果当前的数据库(即USE选定的数据库)是db_name，不应将更新保存到二进制日志中。
--log_error[=file]<br />该文件的日志错误和启动消息.<br />如果你不指定文件名，MySQL使用host_name.err作为文件名。如果文件名没有扩展名，则加上.err扩展名。
<br />--log_isam[=file] <br />将所有MyISAM更改记入该文件
--log_slow_queries[=file] <br />将所有执行时间超过long_query_time 秒的查询记入该文件。
--log_warnings, -W<br />将警告例如Aborted connection...打印到错误日志。建议启用该选项，默认也是启用的。
--memlock<br />将mysqld 进程锁定在内存中。请注意使用该选项时需要以root运行服务器，但从安全考虑并不是一个好注意。
--myisam_recover [=option[,option...]]]<br />存储引擎MyISAM设置为恢复模式。该选项值是DEFAULT、BACKUP、FORCE或QUICK值的任何组合。<br />如果你指定多个值，用逗号