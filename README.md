# VTOP 0.14
##### 贴吧吧务后台公开显示php代理
本项目为对原作者[贴吧@蓝色火焰E](https://tieba.baidu.com/home/main/?un=%E8%93%9D%E8%89%B2%E7%81%AB%E7%84%B0E)（[VICZONE](http://vicz.cn)、[SS'S TRACE](https://sst.st)）于2014~15年所维护VTOP项目的fork，其源码首发在bug吧精品区，但0.12原始版本疑已失传

## 如何安装：
1. 设置`config.php`中的配置项（吧务账号bduss，吧名等）
2. （可选）为您的web server配置urlrewrite规则以去除左侧面板链接url末尾的`.php`
    ##### nginx：
    ```nginx
    location /path/to/your/vtop {
        try_files $uri $uri/ $uri.php$is_args$query_string;
    }
    ```
    ##### apache：
    您不需要手动配置（已在`.htaccess`中配置）

    然后设置config.php中的`URL_REWRITE_ENABLED`为true

## 改进内容：
- 增加显示吧务考勤、黑名单列表、本吧数据及吧务考勤excel下载，如需隐藏可删除对应php文件
- 防止当bduss账号担任多个吧吧务时可通过手写url querystring访问指定贴吧以外贴吧的后台
- 左侧面板链接中去除`?word=$吧名`以精简url
- 支持显示删帖日志页的帖子媒体内容（图片视频等）
- （可选）隐藏删帖日志页的帖子内容
- 支持https
- 更新curl ua和超时参数
- 其他针对贴吧上游更改的同步更新

## 相似项目：
- [贴吧@投江的鱼](https://tieba.baidu.com/home/main/?un=%E6%8A%95%E6%B1%9F%E7%9A%84%E9%B1%BC) 2016年对VTOP的fork版本：https://www.52fisher.cn/349.html
- 投江的鱼2019年的全新重写版：https://www.52fisher.cn/970.html https://gitee.com/fisher52/TiebaPublicBackstage

### 以下为原作者所写`readme.php`：

LOG

VTOP 0.12
加入隐藏操作人

VTOP 0.11
修改路径为相对路径
优化算法
修正个别反人类设计

 VTOP 0.10 bug过多，跳过

2014-11 VTOP 0.9
好吧，实际上这不是一个php文件。。
沉默了这么久，我也冒个泡吧……
这是VTOP（Viczone Tieba Open Panel）0.9版本，开源无公害。
设计的比较简单，也没用OOP。十月我才比完NOIP，所以写的代码有些竞赛的感觉……

使用方法：
在config文件夹内main.php配置好cookie什么的就行了，那里都有提示。

我不是专门搞这个的= =苦逼学生一枚，有什么设计不合理的地方还多多包涵……

本软件前身是bug吧的公开后台，也是本人设计的= =不过，很不完善……
