# sut_score
沈阳工业大学德智体积分评测系统

###STAR原则

> **S** 学校对于2014级以后入学的学生实行进行全面的评测积分制度，需要一个自动化抓取并计算，分类存储奖惩记录的评测系统。  
> **T** 归纳整理2014级版学生须知手册中奖惩分级积分制度，实现批量绩点换算算法，学习Curl系列通讯函数。  
> **A** 通过分离验证码header得以获取用户cookies用于抓取数据。开发离线模式和授权模块，允许在任何时间被授权者可以随时维护自己或全体的积分项目并以Excel文件输出用于打印或签章确认。  
> **R** 成功完成一个允许教工和学生干部轻松计算、维护学生积分的平台。节约教师及学生干部每学期每人次10小时左右，目前已在沈阳工业大学投入实际使用。

###DEMO 示例

####登录界面
![登录界面](https://raw.githubusercontent.com/SUTFutureCoder/sut_score/master/demo/demo1.png)

####记录添加
用于添加奖惩记录。
![记录添加](https://raw.githubusercontent.com/SUTFutureCoder/sut_score/master/demo/demo2.png)

####记录查询
用于进行班级、个人记录查询并支持导出至Excel表格中供审批。
![记录查询_个人](https://raw.githubusercontent.com/SUTFutureCoder/sut_score/master/demo/demo3.png)

![记录查询_集体](https://raw.githubusercontent.com/SUTFutureCoder/sut_score/master/demo/demo5.png)

####多功能学生信息一键查询
支持从教务处抓取学生基本信息、名单、成绩、绩点以及更新全校名单到数据库中。
![教务处抓取](https://raw.githubusercontent.com/SUTFutureCoder/sut_score/master/demo/demo6.png)

####权限控制
用于授予教师或学生干部以只读、完全控制、管理员、可写全部、可写个人和禁止使用的权限。
![权限控制](https://raw.githubusercontent.com/SUTFutureCoder/sut_score/master/demo/demo7.png)