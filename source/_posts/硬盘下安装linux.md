title: 硬盘下安装linux
categories: [Linux]
tags: []
date: 2010-11-25 17:53:00
---
<p>公司新来一批设备，主板没有IDE口，IDE光驱就不能用了。</p><p>用USB光驱装，竟然不能初始化过来，郁闷死了、我要安装的linux系统，太老了，驱动应该支持的少。</p><p>没有办法，公司没有sata光驱，只能硬盘安装了。</p><p> </p><p> </p><p>在另一个linux系统上，上传linux镜像iso。再把iso里面的isolinux文件提取出来。</p><p>这个文件，大家都知道吧，安装引导文件。</p><p>从一个linux启动，进入grub，就是刚刚进去系统时的东西，进入grub命令行（按”c“）。</p><p>kernel （hd0,0)/路径/isolinux/vmlinuz</p><p>&#8205; </p><p>initrd（hd0,0)/路径/isolinux/initd.img</p><p> </p><p>boot</p><p> </p><p>进入安装界面，选择硬盘安装。选择iso的目录就行，不</p><p></p>