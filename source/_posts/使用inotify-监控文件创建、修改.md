title: 使用inotify 监控文件创建、修改
categories: [程序设计,Linux,C编程]
tags: []
date: 2013-07-17 22:36:27
---
例子为：使用inotify 监控文件创建，可用于安全防护，在创建文件时，检测文件内容，以及后续的操作。
监控类型在/usr/include/sys/inotify.h头文件查看
<pre>
#define IN_ACCESS        0x00000001     /* File was accessed.  */
#define IN_MODIFY        0x00000002     /* File was modified.  */
#define IN_ATTRIB        0x00000004     /* Metadata changed.  */
#define IN_CLOSE_WRITE   0x00000008     /* Writtable file was closed.  */
#define IN_CLOSE_NOWRITE 0x00000010     /* Unwrittable file closed.  */
#define IN_CLOSE         (IN_CLOSE_WRITE | IN_CLOSE_NOWRITE) /* Close.  */
#define IN_OPEN          0x00000020     /* File was opened.  */
#define IN_MOVED_FROM    0x00000040     /* File was moved from X.  */
#define IN_MOVED_TO      0x00000080     /* File was moved to Y.  */
#define IN_MOVE          (IN_MOVED_FROM | IN_MOVED_TO) /* Moves.  */
#define IN_CREATE        0x00000100     /* Subfile was created.  */
#define IN_DELETE        0x00000200     /* Subfile was deleted.  */
#define IN_DELETE_SELF   0x00000400     /* Self was deleted.  */
#define IN_MOVE_SELF     0x00000800     /* Self was moved.  */
/* Events sent by the kernel.  */
#define IN_UNMOUNT       0x00002000     /* Backing fs was unmounted.  */
#define IN_Q_OVERFLOW    0x00004000     /* Event queued overflowed.  */
#define IN_IGNORED       0x00008000     /* File was ignored.  */
/* Helper events.  */
#define IN_CLOSE         (IN_CLOSE_WRITE | IN_CLOSE_NOWRITE)    /* Close.  */
#define IN_MOVE          (IN_MOVED_FROM | IN_MOVED_TO)          /* Moves.  */
/* Special flags.  */
#define IN_ONLYDIR       0x01000000     /* Only watch the path if it is a
                                           directory.  */
#define IN_DONT_FOLLOW   0x02000000     /* Do not follow a sym link.  */
#define IN_EXCL_UNLINK   0x04000000     /* Exclude events on unlinked
                                           objects.  */
#define IN_MASK_ADD      0x20000000     /* Add to the mask of an already
#define IN_ONESHOT       0x80000000     /* Only send event once.  */
/* All events which a program can wait on.  */
#define IN_ALL_EVENTS    (IN_ACCESS | IN_MODIFY | IN_ATTRIB | IN_CLOSE_WRITE
                          | IN_CLOSE_NOWRITE | IN_OPEN | IN_MOVED_FROM
                          | IN_MOVED_TO | IN_CREATE | IN_DELETE
                          | IN_DELETE_SELF | IN_MOVE_SELF)
</pre>
监控制定目录下面创建文件和目录
<pre>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <sys/types.h>
#include <sys/inotify.h>
#define	EVENT_SIZE ( sizeof(struct inotify_event) )
#define	BUFF_LEN ( 1024 * ( EVENT_SIZE + 16 ))
int main(void)
{
	int	length, i = 0;
	int	fd;
	int	wd;
	char	buff[BUFF_LEN];
	fd = inotify_init();
	if ( fd < 0) {
		perror("inotify_init error:");
		exit(-1);
	}
	wd = inotify_add_watch(fd, "/home/key1088/code/c/test", IN_CREATE);
	struct inotify_event *event;
	while ( 1 ) {
		memset(buff, 0x00, sizeof(buff));
		length = read(fd, buff, BUFF_LEN);
		if ( length < 0) {
			perror("read:");
		}
		event = ( struct inotify_event * ) &buff[ i ];
		if ( event->len ) {
			if (event->mask & IN_CREATE) {
				if(event->mask & IN_ISDIR) {
					printf("create dir,dirname=[%s]n", event->name);
				}else{
					printf("create file,filename=[%s]n", event->name);
				}
			}
		}
	}
	inotify_rm_watch(fd, wd);
	close(fd);
	return 0;
}
</pre>
参考：http://www.ibm.com/developerworks/cn/linux/l-ubuntu-inotify/