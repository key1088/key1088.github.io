title: py2exe error [Errno 2] No such file or directory &amp;#039;MSVCP90.dll&amp;#039;
categories: [程序设计,Python编程]
tags: []
date: 2015-03-07 17:58:46
---
使用py2exe生产windows可执行程序时，报错：error: [Errno 2] No such file or directory: 'MSVCP90.dll'
原脚本:
<pre>
#!/usr/bin/env python
__author__ = 'key1088'
__date__ = '15-3-7'
from distutils.core import  setup
import py2exe
setup(console=["overtime.py"])
</pre>
使用生产命令：
<pre>
F:workdirpython1>D:Python27python.exe mysetup.py  py2exe
running py2exe
creating F:workdirpython1build
creating F:workdirpython1buildbdist.win32
creating F:workdirpython1buildbdist.win32winexe
creating F:workdirpython1buildbdist.win32winexecollect-2.7
creating F:workdirpython1buildbdist.win32winexebundle-2.7
creating F:workdirpython1buildbdist.win32winexetemp
creating F:workdirpython1dist
*** searching for required modules ***
*** parsing results ***
creating python loader for extension 'unicodedata' (D:Python27DLLsunicodedata.pyd -> unicodedata.pyd)
creating python loader for extension 'wx._misc_' (D:Python27libsite-packageswx-3.0-mswwx_misc_.pyd -> wx._misc_.pyd)
creating python loader for extension 'select' (D:Python27DLLsselect.pyd -> select.pyd)
creating python loader for extension 'wx._windows_' (D:Python27libsite-packageswx-3.0-mswwx_windows_.pyd -> wx._windows_.pyd)
creating python loader for extension '_hashlib' (D:Python27DLLs_hashlib.pyd -> _hashlib.pyd)
creating python loader for extension 'wx._gdi_' (D:Python27libsite-packageswx-3.0-mswwx_gdi_.pyd -> wx._gdi_.pyd)
creating python loader for extension 'wx._controls_' (D:Python27libsite-packageswx-3.0-mswwx_controls_.pyd -> wx._controls_.pyd)
creating python loader for extension '_sqlite3' (D:Python27DLLs_sqlite3.pyd -> _sqlite3.pyd)
creating python loader for extension 'bz2' (D:Python27DLLsbz2.pyd -> bz2.pyd)
creating python loader for extension 'wx._core_' (D:Python27libsite-packageswx-3.0-mswwx_core_.pyd -> wx._core_.pyd)
*** finding dlls needed ***
error: [Errno 2] No such file or directory: 'MSVCP90.dll'
</pre>
修改代码最后一行：
<pre>
setup(console=["overtime.py"],options = { "py2exe":{"dll_excludes":["MSVCP90.dll"]}})
</pre>
生成exe文件成功。
为了使py2exe打出来的可执行文件不出现中文乱码，每次输出要采用以下格式：print unicode("中文","utf-8")