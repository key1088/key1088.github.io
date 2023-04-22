title: 解决dedecms在php高版本中不兼容登录的问题
categories: [Php编程]
tags: []
date: 2013-04-13 12:41:45
---
帮gf把网站给迁移的时候,因为php版本比较高,导致登录的时候不能访问后台,只返回空页面,高版本不兼容,郁闷。wordpress做的挺好,主流兼容性比较好.
百度之,搜了一下解决的方法,原来是一个函数的问题,下面是解决的方法。
登陆dedemcs后台输入用户名和密码后没有提示显示为空白，主要原为是php5.4的版本废除了session_register函数
可以采用如$_SESSION[$this->keepUserIDTag] = $this->userID; 这种方式处理完整代码如下
首先打开 include/userlogin.class.php这个文件，在287行到308行原内容如下：
<pre>
@session_register($this->keepUserIDTag);
$_SESSION[$this->keepUserIDTag] = $this->userID;
@session_register($this->keepUserTypeTag);
$_SESSION[$this->keepUserTypeTag] = $this->userType;
@session_register($this->keepUserChannelTag);
$_SESSION[$this->keepUserChannelTag] = $this->userChannel;
@session_register($this->keepUserNameTag);
$_SESSION[$this->keepUserNameTag] = $this->userName;
@session_register($this->keepUserPurviewTag);
$_SESSION[$this->keepUserPurviewTag] = $this->userPurview;
@session_register($this->keepAdminStyleTag);
$_SESSION[$this->keepAdminStyleTag] = $adminstyle;
PutCookie(‘DedeUserID’, $this->userID, 3600 * 24, ‘/’);
PutCookie(‘DedeLoginTime’, time(), 3600 * 24, ‘/’);
</pre>
替换成
<pre>
global $admincachefile,$adminstyle;
if(empty($adminstyle)) $adminstyle = ‘dedecms’;
//@session_register($this->keepUserIDTag);
$_SESSION[$this->keepUserIDTag] = $this->keepUserIDTag;
$_SESSION[$this->keepUserIDTag] = $this->userID;
//@session_register($this->keepUserTypeTag);
$_SESSION[$this->keepUserTypeTag] = $this->keepUserTypeTag;
$_SESSION[$this->keepUserTypeTag] = $this->userType;
// @session_register($this->keepUserChannelTag);
$_SESSION[$this->keepUserChannelTag] = $this->keepUserChannelTag;
$_SESSION[$this->keepUserChannelTag] = $this->userChannel;
//@session_register($this->keepUserNameTag);
$_SESSION[$this->keepUserNameTag] = $this->keepUserNameTag;
$_SESSION[$this->keepUserNameTag] = $this->userName;
//@session_register($this->keepUserPurviewTag);
$_SESSION[$this->keepUserPurviewTag] = $this->keepUserPurviewTag;
$_SESSION[$this->keepUserPurviewTag] = $this->userPurview;
// @session_register($this->keepAdminStyleTag);
$_SESSION[$this->keepAdminStyleTag] = $this->keepAdminStyleTag;
$_SESSION[$this->keepAdminStyleTag] = $adminstyle;
PutCookie(‘DedeUserID’, $this->userID, 3600 * 24, ‘/’);
PutCookie(‘DedeLoginTime’, time(), 3600 * 24, ‘/’);
</pre>