title: GNS3模拟器的应用注意事项
categories: [网络工程]
tags: []
date: 2010-04-01 15:50:00
---
向大家推荐一个cisco模拟器GNS3，GNS3的确是个非常不错的cisco模拟器。和小凡的原理一样的，面对小凡超高的CPU利用率，你的电脑还能受得了吗，那里用GNS3吧，cpu利用率超少。<br />1.安装路径不要使用中文目录。安装路径最好默认，不要安装到中文文件夹里，这样会出现很多问题。<br />2.存放ISO文件的文件路径应为英文的，桌面也不行（桌面是中文）我就吃这方面的亏了。提示错误***Error: 209-unable to start VM instance 'R1'<br />3.在首选项里指定dynamips-wxp.exe的路径，并检测。不指定，有时候会提示。<br />4.开始路由器时，CPU使用率高，计算idle。路由器右键 idle pc 。多试几遍，最好选择带*的idle值。<br /><br />用过工大瑞普的朋友，应该会用命令行，挺方便的。。