-- WSPDM2 SQL Dump
-- version 2.0
-- https://github.com/SUTFutureCoder/intelligence_server/tree/master/WSPDM2
-- (C) 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
-- Project WSPDM2
-- 
-- 生成日期: 2015-07-17 23:51:19
-- 

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `sut_score`
--
CREATE DATABASE IF NOT EXISTS sut_score DEFAULT CHARSET utf8;
-- --------------------------------------------------------

--
-- 表的结构 `class_info`
--

CREATE TABLE IF NOT EXISTS `class_info` (
  `class_id` char(8) NOT NULL COMMENT '班级id',
  `class_name` char(18) NOT NULL COMMENT '班级名称',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `major_info`
--

CREATE TABLE IF NOT EXISTS `major_info` (
  `major_id` char(6) NOT NULL COMMENT '专业id',
  `major_name` char(30) NOT NULL COMMENT '专业名称',
  PRIMARY KEY (`major_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='专业信息表';

-- --------------------------------------------------------

--
-- 表的结构 `re_role_id`
--

CREATE TABLE IF NOT EXISTS `re_role_id` (
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `role_auth_id` int(11) NOT NULL COMMENT '授权者',
  `role_auth_time` datetime NOT NULL COMMENT '授权时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色id关联表';

--
-- 转存表中的数据 `re_role_id`
--

INSERT INTO `re_role_id` (`user_id`, `role_id`, `role_auth_id`, `role_auth_time`) VALUES
(120406305, 1, 0, '2015-07-17 23:39:17');

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `role_name` char(10) NOT NULL COMMENT '角色名称',
  `role_index` char(20) NOT NULL COMMENT '角色索引',
  PRIMARY KEY (`role_id`),
  KEY `role_index` (`role_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `role_index`) VALUES
(1, '完全控制', 'god'),
(2, '管理员', 'admin'),
(3, '可写全部', 'write_all'),
(4, '可写个人', 'write_person'),
(5, '禁止使用', 'ban_use');

-- --------------------------------------------------------

--
-- 表的结构 `school_info`
--

CREATE TABLE IF NOT EXISTS `school_info` (
  `school_id` char(2) NOT NULL COMMENT '学院id',
  `school_name` char(12) NOT NULL COMMENT '学院名',
  PRIMARY KEY (`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='学院信息表';

-- --------------------------------------------------------

--
-- 表的结构 `score_log`
--

CREATE TABLE IF NOT EXISTS `score_log` (
  `score_log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录流水号',
  `class_student_id` char(9) NOT NULL COMMENT '班级/学生id（用于集体或个人记录）',
  `score_type_id` char(8) NOT NULL COMMENT '分数规则id',
  `teacher_id` char(9) NOT NULL COMMENT '处理人id',
  `score_log_add_time` datetime NOT NULL COMMENT '记录添加时间',
  `score_log_judge` decimal(5,2) NOT NULL COMMENT '分数变化',
  `score_log_event_time` date NOT NULL COMMENT '事件发生时间',
  `score_log_event_tag` char(40) NOT NULL COMMENT '事件标签',
  `score_log_event_intro` varchar(500) NOT NULL COMMENT '事件说明',
  `score_log_event_certify` char(40) NOT NULL COMMENT '事件证明人',
  `score_log_event_file` varchar(100) NOT NULL COMMENT '事件证明文件位置',
  `score_log_valid` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效',
  PRIMARY KEY (`score_log_id`),
  KEY `class_student_id` (`class_student_id`),
  KEY `score_log_add_time` (`score_log_add_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `score_type`
--

CREATE TABLE IF NOT EXISTS `score_type` (
  `score_type_id` char(8) NOT NULL COMMENT '类型id',
  `score_type_content` char(10) NOT NULL COMMENT '类型描述',
  `score_type_comment` char(120) NOT NULL COMMENT '项目解释',
  `score_min` decimal(4,1) NOT NULL COMMENT '该项分数变动最小值',
  `score_max` decimal(4,1) NOT NULL COMMENT '该项分数变动最大值（可以相同）',
  `score_mod` char(1) NOT NULL COMMENT '加分i，减分d',
  PRIMARY KEY (`score_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `score_type`
--

INSERT INTO `score_type` (`score_type_id`, `score_type_content`, `score_type_comment`, `score_min`, `score_max`, `score_mod`) VALUES
('d_1_1_1', '德育基本分', '德育基本分为每个学生德育表现的基础分，包括政治信念、组织纪律、品德修养、集体观念、诚实守信、劳动卫生、爱护公物、文明礼貌等方面。各学院自行指定测评方式。', 0.0, 14.0, 'i'),
('d_2_1_1', '国家级荣誉称号', '获国家级荣誉称号者加3分。', 3.0, 3.0, 'i'),
('d_2_1_2', '省级荣誉称号', '获省级荣誉称号者加2分。', 2.0, 2.0, 'i'),
('d_2_1_3', '市级荣誉称号', '获市级荣誉称号者加1.5分。', 1.5, 1.5, 'i'),
('d_2_1_4', '校级荣誉称号', '获校级荣誉称号者加1分。', 1.0, 1.0, 'i'),
('d_2_2_1', '校级优良学风班', '获校级优良学风班每人加0.5分。', 0.5, 0.5, 'i'),
('d_2_2_2', '校级文明寝室', '校级文明寝室每人加0.3分。', 0.3, 0.3, 'i'),
('d_2_3_1', '校/院/班学生干部', '担任校、学院、班级学生干部满一年，基本胜任者加0.1-1分。其中院级、班级等学生干部的考核评分工作由其所在学院负责；校级学生干部的考核评分工作由其所在学生团体的主管部门负责，并将其评分依据和考核结果向学院通报。', 0.1, 1.0, 'i'),
('d_2_4_1', '精神文明建设表现突出', '在精神文明建设中表现突出者加0.1-1分。\r\n', 0.1, 1.0, 'i'),
('d_3_1_1', '通报批评', '学生在校期间，违反学校规章制度，受通报批评者，一次减0.5分。', 0.5, 0.5, 'd'),
('d_3_1_2', '警告处分', '学生在校期间，违反学校规章制度，受警告处分者，一次减1分。', 1.0, 1.0, 'd'),
('d_3_1_3', '严重警告', '学生在校期间，违反学校规章制度，受严重警告者，一次减2分。', 2.0, 2.0, 'd'),
('d_3_1_4', '记过处分', '学生在校期间，违反学校规章制度，受记过处分者，一次减4分。', 4.0, 4.0, 'd'),
('d_3_1_5', '留校察看', '学生在校期间，违反学校规章制度，受留校察看处分者，一次减5分。', 5.0, 5.0, 'd'),
('d_3_2_1', '寝室拒院校检/不合格', '学生所在寝室在学校或学院寝室卫生检查中，拒绝接收检查或成绩为“不合格寝室”的寝室成员一次减0.1-0.5分。', 0.1, 0.5, 'd'),
('d_3_2_2', '旷课', '学生上课期间请假，必须按规定履行请假手续，否则以旷课处理，旷课一节减0.1-0.5分。', 0.1, 0.5, 'd'),
('d_3_3_2', '旷集体活动', '按要求必须参加的集体活动未履行请假手续，无故不参加者，一次减0.1-0.5分。', 0.1, 0.5, 'd'),
('d_3_4_1', '在外留宿', '未履行请假手续在外留宿者一次减0.5分。', 0.5, 0.5, 'd'),
('d_3_4_2', '晚归', '未履行请假手续晚归一次减0.2分。', 0.2, 0.2, 'd'),
('d_3_5_1', '操行不良', '平时操行表现不好者减0.1-1分', 0.1, 1.0, 'd'),
('w_1_1_1', '体育课/体测/免测', '一、二年级以体育课为主，及格6分、良好7分、优秀8分；三、四年级学生体质健康标准测试及格6分、良好7分、优秀8分；因身体原因不能参加体育教学和学生体质健康标准测试体育教学部认可者给基础分4分。', 0.0, 8.0, 'i'),
('w_2_1_1', '个人省级以上文艺一等', '参加省市级文艺比赛：个人参赛，参加省级以上文艺比赛获一等奖加1分。', 1.0, 1.0, 'i'),
('w_2_1_2', '个人省级以上文艺二等', '参加省市级文艺比赛：个人参赛，参加省级以上文艺比赛获二等奖加0.8分。', 0.8, 0.8, 'i'),
('w_2_1_3', '个人省级以上文艺三等', '参加省市级文艺比赛：个人参赛，参加省级以上文艺比赛获三等奖加0.5分。', 0.5, 0.5, 'i'),
('w_2_1_4', '个人省级以上文艺优胜', '参加省市级文艺比赛：个人参赛，参加省级以上文艺比赛获三等奖以下加0.5分。', 0.5, 0.5, 'i'),
('w_2_1_5', '个人市级文艺一等', '参加省市级文艺比赛：个人参赛，参加市级文艺比赛获一等奖加0.8分。', 0.8, 0.8, 'i'),
('w_2_1_6', '个人市级文艺二等', '参加省市级文艺比赛：个人参赛，参加市级文艺比赛获二等奖加0.5分。', 0.5, 0.5, 'i'),
('w_2_1_7', '个人市级文艺三等', '参加省市级文艺比赛：个人参赛，参加市级文艺比赛获三等奖加0.3分。', 0.3, 0.3, 'i'),
('w_2_1_8', '个人市级文艺优胜', '参加省市级文艺比赛：个人参赛，参加市级文艺比赛获三等奖以下加0.3分。', 0.3, 0.3, 'i'),
('w_2_1_9', '非竞赛文艺汇演', '集体或个人参加各级非竞赛性文艺汇演，每人加0.1-0.3分。', 0.1, 0.3, 'i'),
('w_2_2_1', '阳光体育骨干', '积极组织发动学院和班级同学开展阳光体育运动，并在其中承担组织引导、培训示范作用的学院或班级体育骨干，经学院认可者加0.1-0.5分。', 0.1, 0.5, 'i'),
('w_2_3_1', '个人省级名次前八', '参加省、市级比赛：省级比赛获个人名次前八名者加1分。', 1.0, 1.0, 'i'),
('w_2_3_2', '个人市级名次前六', '参加省、市级比赛：市级比赛获个人名次前六名者加1分。', 1.0, 1.0, 'i'),
('w_2_3_3', '集体省级前六', '省级集体项目前六名，主力队员加1分；非主力队员加0.6分；', 0.6, 1.0, 'i'),
('w_2_3_4', '集体市级前四', '市级集体项目前四名，主力队员加1分；非主力队员加0.6分；', 0.6, 1.0, 'i'),
('w_2_4_1', '打破校体育记录', '打破校体育项目记录者加1分。', 1.0, 1.0, 'i'),
('w_2_4_2', '打破市/省/国记录', '打破市、省、全国体育项目记录者加2分。', 2.0, 2.0, 'i'),
('w_2_5_1', '参加校级体育赛事', '参加校级体育赛事加0.1-1', 0.1, 1.0, 'i'),
('w_3_3_1', '旷早操', '按规定应参加早操活动的学生，不遵守早间活动纪律，缺勤一次扣0.2分', 0.2, 0.2, 'd'),
('w_3_3_2', '体质标准测试不合格', '学生体质健康标准测试不及格者减0.2-0.3分', 0.2, 0.3, 'd'),
('w_3_3_3', '体育比赛严重违纪', '在体育比赛时出现严重违反纪律或文艺体育道德等问题时，视其情节减0.5-1分。', 0.5, 1.0, 'd'),
('z_1_1_1', '智育基础分', '[此部分由系统自动抓取]\n[取一/二考总成绩，单科绩点乘对应的学分综合除以总学分]\n基础分=平均学分绩点折合成总分平均分×70%；\n平均学分绩点的计算和平均学分绩点折合成总平均分的标准参照《沈阳工业大学本科生学分制学籍管理实施细则》计算。', 0.0, 70.0, 'i'),
('z_2_1_1', '第四学期前通过四级', '第四学期之前（含第四学期）参加全国大学生英语四级考试成绩为425分以上（含425分）者，当学期综合测评加1分；', 1.0, 1.0, 'i'),
('z_2_1_2', '第六学期前通过六级', '第六学期前（含第六学期）参加全国大学生英语六级考试成绩为425分以上（含425分）者，当学期综合测评加1分。', 1.0, 1.0, 'i'),
('z_2_1_3', '考试单科百分', '考试科目单科获得100分者加1分。', 1.0, 1.0, 'i'),
('z_2_1_4', '国家计算机三级', '通过国家计算机三级者加0.5分', 0.5, 0.5, 'i'),
('z_2_1_5', '国家计算机四级', '通过国家计算机四级者加1分', 1.0, 1.0, 'i'),
('z_2_1_6', '各专业资格证书', '取得各专业资格证书者加0.1-1分。', 0.1, 1.0, 'i'),
('z_2_2_1', '国外期刊发表论文', '在国外期刊上发表论文，每篇加3分。', 3.0, 3.0, 'i'),
('z_2_2_2', '国家重要刊物学术论文', '在国家重要刊物上发表学术论文，每篇加2分。', 2.0, 2.0, 'i'),
('z_2_2_3', '国家核心刊物学术论文', '在国家核心刊物上发表学术论文，每篇加1分。', 1.0, 1.0, 'i'),
('z_2_3_1', '发明专利', '（第一作者）发明专利加3分。', 3.0, 3.0, 'i'),
('z_2_3_2', '实用新型专利', '（第一作者）实用新型专利加2分。', 2.0, 2.0, 'i'),
('z_2_3_3', '外观设计专利', '（第一作者）外观设计专利加1分。', 1.0, 1.0, 'i'),
('z_2_4_1', '国家级竞赛', '获国家级竞赛一等奖加3分，二等奖加2分，一等奖加1分。\r\n如果参赛获奖项目为集体项目，项目负责人获项目加分总量的二分之一，其他成员平均分配加分总量的二分之一；', 0.0, 3.0, 'i'),
('z_2_4_2', '省市评比奖项', '获省、市级评比奖项的，一等奖加2分，二等奖加1分，一等奖加0.8分。\r\n如果参赛获奖项目为集体项目，项目负责人获项目加分总量的二分之一，其他成员平均分配加分总量的二分之一；', 0.0, 2.0, 'i'),
('z_2_4_3', '校级优秀评比', '获校级评比一等奖加1分，二等奖加0.8分，一等奖加0.5分。\r\n如果参赛获奖项目为集体项目，项目负责人获项目加分总量的二分之一，其他成员平均分配加分总量的二分之一；', 0.0, 1.0, 'i');

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `student_id` char(9) NOT NULL COMMENT '学号',
  `student_name` char(5) NOT NULL COMMENT '学生姓名',
  `student_class` int(11) NOT NULL COMMENT '学生班级（可换算学院专业）',
  PRIMARY KEY (`student_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='学生表';

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `teacher_id` int(11) NOT NULL COMMENT '教师id',
  `teacher_name` char(5) NOT NULL COMMENT '教师姓名',
  `teacher_password` varchar(100) NOT NULL COMMENT '教务处密码[用于离线使用]',
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='教师表';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
