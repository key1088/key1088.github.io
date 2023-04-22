title: Ubuntu 安装minikebe
categories: [操作系统,Linux,容器]
tags: [k8s,minikube]
date: 2019-11-26 23:22:00
---
&nbsp;
<h5>1.下载并安装</h5>
<code class="language-shell" data-lang="shell">curl -LO https://storage.googleapis.com/minikube/releases/latest/minikube_1.5.2.deb \
&amp;&amp; sudo dpkg -i minikube_1.5.2.deb</code>

2.查看是否支持虚拟化
<div class="highlight">
<h5><code class="language-shell" data-lang="shell">egrep -q 'vmx|svm' /proc/cpuinfo &amp;&amp; echo yes || echo no</code></h5>
3.启动minikebe，需要网络下载
<div class="highlight">
<pre><code class="language-shell" data-lang="shell">1)本地运行

sudo minikube start --vm-driver=none</code> <code class="language-shell" data-lang="shell">2)使用vbox运行（不能使用root用户，vbox非不能用root）</code></pre>
<div class="highlight">
<pre><code class="language-shell" data-lang="shell">minikube start --vm-driver=virtualbox</code> <code class="language-shell" data-lang="shell">3)设置默认运行环境
</code><code class="language-shell" data-lang="shell">sudo minikube config set vm-driver none</code></pre>
<div class="code-tabs">
<div class="tab-content">
<div class="tab-pane active" title="虚拟盒子">
<div class="highlight">
<div class="code-tabs">
<div class="tab-content">
<div class="tab-pane active" title="无（裸金属）">
<div class="highlight">
<pre><code class="language-shell" data-lang="shell">or</code></pre>
</div>
</div>
</div>
</div>
<pre><code class="language-shell" data-lang="shell">minikube config set vm-driver virtualbox

4)国内网络限制，使用aliyun的资源
</code></pre>
<pre><code>minikube start --vm-driver=virtualbox --image-mirror-country=cn 
?  Ubuntu 18.04 上的 minikube v1.5.2
?  Tip: Use 'minikube start -p &lt;name&gt;' to create a new cluster, or 'minikube delete' to delete this one.
?  Starting existing virtualbox VM for "minikube" ...
⌛  Waiting for the host to be provisioned ...
⚠️  VM is unable to access k8s.gcr.io, you may need to configure a proxy or set --image-repository
?  正在 Docker '18.09.9' 中准备 Kubernetes v1.16.2…
?  Relaunching Kubernetes using kubeadm ... 
⌛  Waiting for: apiserver
?  完成！kubectl 已经配置至 "minikube"
?  为获得最佳结果，请安装 kubectl：https://kubernetes.io/docs/tasks/tools/install-kubectl/</code></pre>
</div>
</div>
</div>
</div>
</div>
<h5>4.查看状态minikube，连接ssh</h5>
<pre><code class="language-shell" data-lang="shell">key1088@key1088-Vostro-3459:~$ minikube status
host: Running
kubelet: Running
apiserver: Running
kubeconfig: Configured

</code>key1088@key1088-Vostro-3459:~$ minikube ssh _ _ _ _ ( ) ( ) ___ ___ (_) ___ (_)| |/') _ _ | |_ __ /' _ ` _ `\| |/' _ `\| || , &lt; ( ) ( )| '_`\ /'__`\ | ( ) ( ) || || ( ) || || |\`\ | (_) || |_) )( ___/ (_) (_) (_)(_)(_) (_)(_)(_) (_)`\___/'(_,__/'`\____)</pre>
<pre><code class="language-shell" data-lang="shell"></code></pre>
$ exit
<pre><code class="language-shell" data-lang="shell"></code></pre>
<h5>5.启动dashboard</h5>
<h5><code class="language-shell" data-lang="shell">添加PATH变量</code></h5>
<h5>export PATH=$PATH:$HOME/.minikube/cache/v1.16.2/<code class="language-shell" data-lang="shell">
</code><code class="language-shell" data-lang="shell">minikube dashboard</code></h5>
</div>
<img class="alignnone size-full wp-image-605" src="/images/2019/11/2019-11-27-22-46-48屏幕截图.png" alt="" width="1287" height="639" />

参考：https://minikube.sigs.k8s.io/docs/start/linux/

</div>