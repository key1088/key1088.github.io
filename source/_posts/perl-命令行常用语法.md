title: perl 命令行常用语法
categories: [Perl编程]
tags: []
date: 2014-03-22 15:35:26
---
替换
将所有C程序中的foo替换成bar，旧文件备份成.bak
perl -p -i.bak -e 's/bfoob/bar/g' *.c
很强大的功能，特别是在大程序中做重构。记得只有在UltraEdit用过。 如果你不想备份，就直接写成 perl -p -i -e 或者更简单 perl -pie， 恩，pie这个单词不错
将每个文件中出现的数值都加一
perl -i.bak -pe 's/(d+)/ 1 + $1 /ge' file1 file2 ....
将换行符rn替换成n
perl -pie 's/rn/n/g' file
同dos2unix命令。
将换行符n替换成rn
perl -pie 's/n/rn/g' file
同unix2dos命令。
取出文件的一部分
显示字段0-4和字段6，字段的分隔符是空格
perl -lane 'print "@F[0..4] $F[6]"' file
很好很强大，同 awk 'print $1, $2, $3, $4, $5, $7'。参数名称lane也很好记。
如果字段分隔符不是空格而是冒号，则用
perl -F: -lane 'print "@F[0..4]n"' /etc/passwd
显示START和END之间的部分
perl -ne 'print if /^START$/ .. /^END$/' file
恐怕这个操作只有sed才做得到了吧……
相反，不显示START和END之间的部分
perl -ne 'print unless /^START$/ .. /^END$/' file
显示开头50行：
perl -pe 'exit if $. > 50' file
同命令 head -n 50
不显示开头10行：
perl -ne 'print unless 1 .. 10' file
显示15行到17行：
perl -ne 'print if 15 .. 17' file
每行取前80个字符：
perl -lne 'print substr($_, 0, 80) = ""' file
每行丢弃前10个字符：
perl -lne 'print substr($_, 10) = ""' file
搜索
查找comment字符串：
perl -ne 'print if /comment/' duptext
这个就是普通的grep命令了。
查找不含comment字符串的行：
perl -ne 'print unless /comment/' duptext
反向的grep，即grep -v。
查找包含comment或apple的行：
perl -ne 'print if /comment/ || /apple/' duptext
相同的功能就要用到egrep了，语法比较复杂，我不会……
计算
计算字段4和倒数第二字段之和：
perl -lane 'print $F[4] + $F[-2]'
要是用awk，就得写成 awk '{i=NF-1;print $5+$i}'
排序和反转
文件按行排序：
perl -e 'print sort &lt;>' file
相当于简单的sort命令。
文件按段落排序：
perl -00 -e 'print sort &lt;>' file
多个文件按文件内容排序，并返回合并后的文件：
perl -0777 -e 'print sort &lt;>' file1 file2
文件按行反转：
perl -e 'print reverse &lt;>' file1
相应的命令有吗？有……不过挺偏，tac（cat的反转）
数值计算
10进制转16进制：
perl  -ne  'printf "%xn",$_'
10进制转8进制： perl -ne 'printf "%on",$_'
16进制转10进制：
perl -ne 'print  hex($_)."n"'
8进制转10进制：
perl -ne 'print  oct($_)."n"'
简易计算器。
perl -ne 'print  eval($_)."n"'
其他
启动交互式perl：
perl -de 1
查看包含路径的内容：
perl -le 'print for @INC'
备注
与One-Liner相关的Perl命令行参数：
-0&lt;数字>
(用8进制表示)指定记录分隔符($/变量)，默认为换行
-00
段落模式，即以连续换行为分隔符
-0777
禁用分隔符，即将整个文件作为一个记录
-a
自动分隔模式，用空格分隔$_并保存到@F中。相当于@F = split ''。分隔符可以使用-F参数指定
-F
指定-a的分隔符，可以使用正则表达式
-e
执行指定的脚本。
-i&lt;扩展名>
原地替换文件，并将旧文件用指定的扩展名备份。不指定扩展名则不备份。
-l
对输入内容自动chomp，对输出内容自动添加换行
-n
自动循环，相当于 while(&lt;>) { 脚本; }
-p
自动循环+自动输出，相当于 while(&lt;>) { 脚本; print; }