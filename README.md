# sut_score
沈阳工业大学德智体积分评测系统

###STAR原则

> **S** 学校对于2014级以后入学的学生实行进行全面的评测积分制度，需要一个自动化抓取并计算，分类存储奖惩记录的评测系统。  
> **T** 归纳整理2014级版学生须知手册中奖惩分级积分制度，实现批量绩点换算算法，学习Curl系列通讯函数。  
> **A** 通过分离验证码header得以获取用户cookies用于抓取数据。开发离线模式和授权模块，允许在任何时间被授权者可以随时维护自己或全体的积分项目并以Excel文件输出用于打印或签章确认。  
> **R** 成功完成一个允许教工和学生干部轻松计算、维护学生积分的平台。节约教师及学生干部每学期每人次10小时左右，目前已在沈阳工业大学投入实际使用。

###DEMO 示例

####登录界面
![登录界面](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/WSPDM2_01.png?raw=true)

####总览页面
用于修改用户密码及备份回滚或删除。
![总览页面](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/WSPDM2_02.png?raw=true)

####浏览数据
![浏览数据](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/WSPDM2_03.png?raw=true)

####查看表结构
自动标识主键、唯一、自增字段。
![查看表结构](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/WSPDM2_04.png?raw=true)

####极速SQL语句构建
比同类的phpmyadmin管理器，构建速度更快更给力，平均只需3.5秒钟。
![极速SQL语句构建](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/WSPDM2_05.png?raw=true)

####插入数据
数据类型精准而优雅。
![插入数据](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/WSPDM2_10.png?raw=true)

####多功能搜索
后台SQL语句自动构建助力您的搜索
![多功能搜索](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/WSPDM2_08.png?raw=true)

####数据分析
使用百度ECharts开源项目创建图表
![数据分析](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/WSPDM2_06.png?raw=true)

####数据库快照
存放快照于/home/用户名/WSPDM2/数据库名/表名
![数据库快照](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/WSPDM2_07.png?raw=true)

![生成的文件](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/WSPDM2_11.png?raw=true)


####即时修改数据
![即时修改数据](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/WSPDM2_09.png?raw=true)

---

##VirtualShell2
###STAR原则

> **S** 服务器只开放80端口且不向外网提供SSH和VPN。    
> **T** 使用WebSocket、进程操作、内存共享等技术  
> **A** 仿\*nix命令行式操作方式，交互接口模仿操作系统，低耦合性语言包允许任意添加或删除。  
> **R** 此应用成功在假期远程管理校园服务器。  
 
###DEMO 示例

####初始界面
选定中文语言包
![初始界面](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/VirtualShell2_01_3.png?raw=true)

选定英文语言包
![初始界面](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/VirtualShell2_01_2.png?raw=true)

选定日文语言包
![初始界面](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/VirtualShell2_01_1.png?raw=true)

####语言包
松耦合式语言包设计，允许开发者任意添加或删除语言包。
![语言包设计](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/VirtualShell2_06.png?raw=true)

####帮助命令
展示**$vs:**系列内部命令。
![帮助命令](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/VirtualShell2_02.png?raw=true)

####开发成员信息
感谢外语学院日文系**☆RYUU☆**提供日文版语言包
![帮助命令](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/VirtualShell2_03.png?raw=true)

####执行系统命令
使用安全策略：在/home/key.php存放私钥，密码尾部根据日期和小时换算出，然后将其合并。
![执行系统命令](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/VirtualShell2_04.png?raw=true)

####用户交流
![用户交流](https://github.com/SUTFutureCoder/intelligence_server/blob/master/example-img/VirtualShell2_05.png?raw=true)



