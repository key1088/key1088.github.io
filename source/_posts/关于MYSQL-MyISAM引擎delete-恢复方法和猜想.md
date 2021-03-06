title: 关于MYSQL MyISAM引擎delete 恢复方法和猜想
categories: [Mysql,数据库]
tags: []
date: 2017-03-12 22:52:57
---
如果使用MYSQL数据库,不一小心误操作,删除掉不该删除的数据,同时又没有打开BIN-LOG,怎么办呢?除了后悔没有按时备份还能怎么办??本篇带来一遍恢复数据的文档,不能完全恢复只是给一个思路
此方法只用与MyISAM引擎,同时只是实用于部分数据,如果使用delete from xxx不带where条件的删除,是没有办法恢复的,使用此方法也不能完全恢复,只会找回一些数据,总比没有什么都没有要一些吧.
还有网上很多文档说delete只是修改的索引值而不是真正的删除,这个至少我没有办法也许是版本的问题就不去深究了.
**注意:当遇到数据被误删除事,请不要立马恢复之前的备份(如果可以的),而是先把服务停掉不让其继续写数据,再把数据库的数据文件备份出来,在mysql数据目录下面,已数据库名称为目录.
**
开始操作
MyISAM的存储引擎每一个表需要三个文件,如下(XXX代表表名称):
<blockquote>
  <ul>
  <li>XXX.frm  表结构</li>
  <li>XXX.MYD  数据文件   </li>
  <li>XXX.MYI  索引文件</li>
  </ul>
</blockquote>
恢复数据我们只需要重点关注数据文件即可.使用16进制模式打开文件,看一下文件内容隐约能看到一些内容.
在WINDOWS下面可以用UE打开,在linux下面直接使用hexdump命令即可,命令如下:
<pre><code>hexdump -e '8/1 "%02X ""\t"" "' -e '8/1 "%c""\n"'  test.MYD
</code></pre>
在打开数据文件之前,先看一下我使用的数据表结构和测试数据.
<pre><code>mysql&gt; desc test;
+------------+-------------+------+-----+---------+-------+
| Field      | Type        | Null | Key | Default | Extra |
+------------+-------------+------+-----+---------+-------+
| userid     | int(10)     | NO   | PRI | NULL    |       |
| username   | varchar(60) | NO   |     | NULL    |       |
| password   | varchar(60) | NO   |     | NULL    |       |
| lastupdate | date        | NO   |     | NULL    |       |
+------------+-------------+------+-----+---------+-------+
4 rows in set (0.00 sec)
mysql&gt; select * from test limit 10,10;
+--------+----------+----------+------------+
| userid | username | password | lastupdate |
+--------+----------+----------+------------+
|     13 | admin13  | passwd13 | 2017-03-11 |
|     14 | admin14  | passwd14 | 2017-03-11 |
|     15 | admin15  | passwd15 | 2017-03-11 |
|     16 | admin16  | passwd16 | 2017-03-11 |
|     17 | admin17  | passwd17 | 2017-03-11 |
|     18 | admin18  | passwd18 | 2017-03-11 |
|     19 | admin19  | passwd19 | 2017-03-11 |
|     20 | admin20  | passwd20 | 2017-03-11 |
|     21 | admin21  | passwd21 | 2017-03-11 |
|     22 | admin22  | passwd22 | 2017-03-11 |
+--------+----------+----------+------------+
10 rows in set (0.00 sec)
</code></pre>
然后打开数据文件,截取一段16进制数据.
<pre><code>69 6E 31 32 08 70 61 73  in12^Hpas
73 77 64 31 32 6B C2 0F  swd12kÂ^O
01 00 19 00 0D 00 00 00  ^A^@^Y^@^M^@^@^@
07 61 64 6D 69 6E 31 33  ^Gadmin13
08 70 61 73 73 77 64 31  ^Hpasswd1
33 6B C2 0F 01 00 19 00  3kÂ^O^A^@^Y^@
0E 00 00 00 07 61 64 6D  ^N^@^@^@^Gadm
69 6E 31 34 08 70 61 73  in14^Hpas
73 77 64 31 34 6B C2 0F  swd14kÂ^O
01 00 19 00 0F 00 00 00  ^A^@^Y^@^O^@^@^@
07 61 64 6D 69 6E 31 35  ^Gadmin15
08 70 61 73 73 77 64 31  ^Hpasswd1
35 6B C2 0F 01 00 19 00  5kÂ^O^A^@^Y^@
10 00 00 00 07 61 64 6D  ^P^@^@^@^Gadm
69 6E 31 36 08 70 61 73  in16^Hpas
73 77 64 31 36 6B C2 0F  swd16kÂ^O
01 00 19 00 11 00 00 00  ^A^@^Y^@^Q^@^@^@
07 61 64 6D 69 6E 31 37  ^Gadmin17
08 70 61 73 73 77 64 31  ^Hpasswd1
37 6B C2 0F 01 00 19 00  7kÂ^O^A^@^Y^@
12 00 00 00 07 61 64 6D  ^R^@^@^@^Gadm
69 6E 31 38 08 70 61 73  in18^Hpas
73 77 64 31 38 6B C2 0F  swd18kÂ^O
01 00 19 00 13 00 00 00  ^A^@^Y^@^S^@^@^@
07 61 64 6D 69 6E 31 39  ^Gadmin19
08 70 61 73 73 77 64 31  ^Hpasswd1
39 6B C2 0F 01 00 19 00  9kÂ^O^A^@^Y^@
14 00 00 00 07 61 64 6D  ^T^@^@^@^Gadm
69 6E 32 30 08 70 61 73  in20^Hpas
73 77 64 32 30 6B C2 0F  swd20kÂ^O
01 00 19 00 15 00 00 00  ^A^@^Y^@^U^@^@^@
07 61 64 6D 69 6E 32 31  ^Gadmin21
08 70 61 73 73 77 64 32  ^Hpasswd2
31 6B C2 0F 01 00 19 00  1kÂ^O^A^@^Y^@
16 00 00 00 07 61 64 6D  ^V^@^@^@^Gadm
69 6E 32 32 08 70 61 73  in22^Hpas
73 77 64 32 32 6B C2 0F  swd22kÂ^O
01 00 19 00 17 00 00 00  ^A^@^Y^@^W^@^@^@
07 61 64 6D 69 6E 32 33  ^Gadmin23
08 70 61 73 73 77 64 32  ^Hpasswd2
</code></pre>
userid=13的明细对应着一下16进制数据快.
<pre><code>01 00 19 00 0D 00 00 00  ^A^@^Y^@^M^@^@^@
07 61 64 6D 69 6E 31 33  ^Gadmin13
08 70 61 73 73 77 64 31  ^Hpasswd1
33 6B C2 0F
</code></pre>
简单解析一下这些数据结构的意思.
<blockquote>
  <ul>
  <li>01 00 19 00                              :这里是4位数据头,不代表头就是4为,这个数据头不固定</li>
  <li>0D 00 00 00                              :为userid的值13,int占4位.</li>
  <li>07 61 64 6D 69 6E 31 33        :07代表长度 后面7位为数据,varchar数据这样表示.</li>
  <li>08 70 61 73 73 77 64 31 33   :varchar和上面一样.</li>
  <li>6B C2 0F                                   :为date类型,占位为3.值为2017,计算方法是"day + month<em>32 + year</em>16*32'"</li>
  <li>具体其他数据字段长度和结构可以详见MYSQL官方文档
  https://dev.mysql.com/doc/internals/en/myisam-column-attributes.html</li>
  </ul>
</blockquote>
咱们删除一条数据看一下数据快的变化:
<pre><code>mysql&gt; delete from test where userid = 13;
Query OK, 1 row affected (0.00 sec)
mysql&gt; select * from test limit 9,10;
+--------+----------+----------+------------+
| userid | username | password | lastupdate |
+--------+----------+----------+------------+
|     12 | admin12  | passwd12 | 2017-03-11 |
|     14 | admin14  | passwd14 | 2017-03-11 |
|     15 | admin15  | passwd15 | 2017-03-11 |
|     16 | admin16  | passwd16 | 2017-03-11 |
|     17 | admin17  | passwd17 | 2017-03-11 |
|     18 | admin18  | passwd18 | 2017-03-11 |
|     19 | admin19  | passwd19 | 2017-03-11 |
|     20 | admin20  | passwd20 | 2017-03-11 |
|     21 | admin21  | passwd21 | 2017-03-11 |
|     22 | admin22  | passwd22 | 2017-03-11 |
+--------+----------+----------+------------+
10 rows in set (0.00 sec)
删除后的数据块如下:
69 6E 31 32 08 70 61 73  in12^Hpas
73 77 64 31 32 6B C2 0F  swd12kÂ^O
00 00 00 1C 00 00 00 00  ^@^@^@^\^@^@^@^@
00 00 0A D4 FF FF FF FF  ^@^@Ôÿÿÿÿ
FF FF FF FF 73 77 64 31  ÿÿÿÿswd1
33 6B C2 0F 01 00 19 00  3kÂ^O^A^@^Y^@
0E 00 00 00 07 61 64 6D  ^N^@^@^@^Gadm
69 6E 31 34 08 70 61 73  in14^Hpas
73 77 64 31 34 6B C2 0F  swd14kÂ^O
01 00 19 00 0F 00 00 00  ^A^@^Y^@^O^@^@^@
07 61 64 6D 69 6E 31 35  ^Gadmin15
08 70 61 73 73 77 64 31  ^Hpasswd1
35 6B C2 0F 01 00 19 00  5kÂ^O^A^@^Y^@
10 00 00 00 07 61 64 6D  ^P^@^@^@^Gadm
69 6E 31 36 08 70 61 73  in16^Hpas
73 77 64 31 36 6B C2 0F  swd16kÂ^O
01 00 19 00 11 00 00 00  ^A^@^Y^@^Q^@^@^@
07 61 64 6D 69 6E 31 37  ^Gadmin17
08 70 61 73 73 77 64 31  ^Hpasswd1
37 6B C2 0F 01 00 19 00  7kÂ^O^A^@^Y^@
12 00 00 00 07 61 64 6D  ^R^@^@^@^Gadm
</code></pre>
USERID=13数据块变化对比
<pre><code>delete后
00 00 00 1C 00 00 00 00  ^@^@^@^\^@^@^@^@
00 00 0A D4 FF FF FF FF  ^@^@Ôÿÿÿÿ
FF FF FF FF 73 77 64 31  ÿÿÿÿswd1
33 6B C2
delete前
01 00 19 00 0D 00 00 00  ^A^@^Y^@^M^@^@^@
07 61 64 6D 69 6E 31 33  ^Gadmin13
08 70 61 73 73 77 64 31  ^Hpasswd1
33 6B C2 0F
前20位被破坏了,但是后面的数据还可以,只是数据很少了,如果没有数据写入的话,还有一线恢复的生机,主要找到后面数据的对应关系才能恢复
如果是大批量的数据被删除,恢复就需要看运气了,大家还是定时做好备份和开始mysql的log-bin模式.
关于头长度和delete头长度请阅读mysql官方
https://dev.mysql.com/doc/internals/en/layout-record-storage-frame.html
</code></pre>
关于解析test.MYD文件格式,写了一些代码希望对理解MDY文件结构有些帮助.
<pre><code>key1088@key1088-host:~/code/repari$ cat repariMYD.c
#include &lt;stdio.h&gt;
#include &lt;string.h&gt;
#include &lt;ctype.h&gt;
#include &lt;stdlib.h&gt;
#include &lt;errno.h&gt;
#include &lt;sys/stat.h&gt;
#include &lt;fcntl.h&gt;
#include &lt;unistd.h&gt;
#include &lt;arpa/inet.h&gt;
void writeSQL(char *filebuf,unsigned int flen);
int main(int argc, char **argv)
{
    int fd=0;
    unsigned flen = 0;
    unsigned char *filebuf = NULL;
    struct stat fsbuf;
    char    *filename = NULL;
    if ( argc &lt; 2 ) {
        printf("repari Mysql MyISAM DataFile\n");
        printf("%s [MyISAM DATA .MYD File] \n", argv[0]);
        exit(-1);
    }
    filename = argv[1];
    if ( stat(filename,&amp;fsbuf) == -1 ) {
        printf("open file test.MYD error,msg = %s\n", strerror(errno));
        exit(-1);
    }
    flen = fsbuf.st_size;
    printf("Read %s filesize is %u\n", argv[1], flen);
    if ( flen == 0 ) {
        printf("file is empty\n");
        exit(-1);
    }
    if( (fd=open(filename,O_RDONLY) ) == -1 ) {
        printf("open file test.MYD error,msg = %s\n", strerror(errno));
        exit(-1);
    }
    filebuf = (unsigned char *)malloc(flen*sizeof(char)+1);
    if ( filebuf == NULL ) {
        printf("malloc error,msg = %s\n", strerror(errno));
        close(fd);
        exit(-1);
    }
    read(fd,filebuf,flen);
    close(fd);
    writeSQL(filebuf,flen);
    free(filebuf);
    return 0;
}
void writeSQL(char *filebuf,unsigned int flen)
{
    char    c;
    unsigned i = 0;
    long tmplen = 0;
    unsigned char tmp[5];
    unsigned char tmpchar[255+1];
    int y,m,d;
    while ( i &lt; flen ) {
        if ( filebuf[i] == 0x00 ) {
            i++;
        }
        printf("head=[%02x]", filebuf[i]);
        if( filebuf[i] == 0x03 ) {
            i = i + 1 + 4; /* 1 + 4head */
        } else if ( filebuf[i] == 0x01 ) {
            i = i + 1 + 3; /* 1 + 3head */
        }
        /* int 4B */
        memset(tmp,0x00,sizeof(tmp));
        if ( (i+4) &gt;  flen ) {
            printf("\nover\n");
            return;
        }
        memcpy(tmp,filebuf + i, 4);
        /*需要倒序*/
        sprintf(tmp,"%02x%02x%02x%02x",tmp[3],tmp[2],tmp[1],tmp[0]);
        printf("[%s] %ld - ", tmp, strtol(tmp,NULL, 16));
        i = i + 4;
        /*varchar */
            /* 1位长度 */
        memset(tmp,0x00,sizeof(tmp));
        if ( (i+1) &gt;  flen ) {
            printf("\nover\n");
            return;
        }
        memcpy(tmp,filebuf + i, 1);
        sprintf(tmp,"%02x",tmp[0]);
        tmplen = strtol(tmp,NULL,16);
        i = i + 1;
            /* DATA */
        memset(tmpchar,0x00,sizeof(tmpchar));
        if ( (i + tmplen)&gt;  flen ) {
            printf("\nover\n");
            return;
        }
        memcpy(tmpchar,filebuf + i, tmplen);
        printf("%s - ", tmpchar);
        i = i + tmplen;
        /*varchar*/
            /* 1位长度 */
        memset(tmp,0x00,sizeof(tmp));
        if ( (i+1) &gt;  flen ) {
            printf("\nover\n");
            return;
        }
        memcpy(tmp,filebuf + i, 1);
        sprintf(tmp,"%02x",tmp[0]);
        tmplen = strtol(tmp,NULL,16);
        i = i + 1;
            /* DATA */
        memset(tmpchar,0x00,sizeof(tmpchar));
        if ( (i+tmplen) &gt;  flen ) {
            printf("\nover\n");
            return;
        }
        memcpy(tmpchar,filebuf + i, tmplen);
        printf("%s - ", tmpchar);
        i = i + tmplen;
        /*date 3位 */
        memset(tmp,0x00,sizeof(tmp));
        memset(tmpchar,0x00,sizeof(tmpchar));
        if( (i+3) &gt; flen) {
            printf("\nover\n");
            return;
        }
        memcpy(tmp,filebuf + i,3);
        sprintf(tmpchar,"%02x%02x%02x",tmp[2],tmp[1],tmp[0]);
        tmplen = strtol(tmpchar,NULL,16);
        y = m = d = 0;
        y = tmplen / 32 / 16;
        m = (tmplen - (32*16*y)) / 32;
        d = tmplen - (32*16*y) - (32*m);
        printf("%d-%d-%d",y,m,d);
        i = i + 3;
        printf("\n");
    }
}
key1088@key1088-host:~/code/repari$
</code></pre>