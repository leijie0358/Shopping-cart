--
-- 表的结构 `assessment_class`
--

CREATE TABLE IF NOT EXISTS `assessment_class` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(30) collate utf8_bin NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `assessment_class`
--

INSERT INTO `assessment_class` (`id`, `parent_id`, `name`, `profile`) VALUES
(1, 0, '非常满意', '感觉特别爽,无可挑剔'),
(2, 0, '满意', '感觉不错,有点问题'),
(3, 0, '一般', '没什么感觉,不好也不坏'),
(4, 0, '不满意', '态度恶劣');

-- --------------------------------------------------------

--
-- 表的结构 `assignwork`
--

CREATE TABLE IF NOT EXISTS `assignwork` (
  `id` int(11) NOT NULL auto_increment,
  `bxsheet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `assignwork`
--

INSERT INTO `assignwork` (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES
(1, 1, 2, '');

-- --------------------------------------------------------

--
-- 表的结构 `bxsheet`
--

CREATE TABLE IF NOT EXISTS `bxsheet` (
  `id` int(11) NOT NULL auto_increment,
  `number` varchar(30) collate utf8_bin NOT NULL,
  `custom_id` int(11) default NULL,
  `custom_company` varchar(30) collate utf8_bin NOT NULL,
  `custom_name` varchar(30) collate utf8_bin NOT NULL,
  `custom_workphone` varchar(30) collate utf8_bin NOT NULL,
  `custom_mobilephone` varchar(30) collate utf8_bin NOT NULL,
  `custom_addr_province` varchar(30) collate utf8_bin NOT NULL,
  `custom_addr_city` varchar(60) collate utf8_bin NOT NULL,
  `custom_addr_area` varchar(60) collate utf8_bin NOT NULL,
  `custom_addr_street` varchar(60) collate utf8_bin NOT NULL,
  `custom_addr_detail` varchar(100) collate utf8_bin NOT NULL,
  `hope_wx_time_begin` datetime NOT NULL default '0000-00-00 00:00:00',
  `hope_wx_time_end` datetime NOT NULL default '0000-00-00 00:00:00',
  `bx_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `bxsheet_class_id` int(11) default NULL,
  `fault_title` varchar(60) collate utf8_bin NOT NULL,
  `fault_profile` varchar(200) collate utf8_bin NOT NULL,
  `assessment_class_id` int(11) default NULL,
  `assessment_content` varchar(60) collate utf8_bin NOT NULL,
  `booking_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `wx_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `fault_reason` varchar(60) collate utf8_bin NOT NULL,
  `wx_profile` varchar(60) collate utf8_bin NOT NULL,
  `wx_fee` decimal(10,2) default NULL,
  `status` int(11) default '0',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `creater_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;


--
-- 表的结构 `bxsheet_class`
--

CREATE TABLE IF NOT EXISTS `bxsheet_class` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(30) collate utf8_bin NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `bxsheet_class`
--

INSERT INTO `bxsheet_class` (`id`, `parent_id`, `name`, `profile`) VALUES
(1, 0, '电脑', '电脑'),
(2, 0, '家电', '家电'),
(3, 0, '服务器', '服务器');
(4, 0, '服务器', '服务器');
-- --------------------------------------------------------

--
-- 表的结构 `device`
--

CREATE TABLE IF NOT EXISTS `device` (
  `id` int(11) NOT NULL auto_increment,
  `number` varchar(30) collate utf8_bin NOT NULL,
  `type` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `model` varchar(100) collate utf8_bin NOT NULL,
  `buy_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `count` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `treatment` int(11) NOT NULL default '0',
  `profile` varchar(600) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


--
-- 表的结构 `device_class`
--

CREATE TABLE IF NOT EXISTS `device_class` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `level` int(11) NOT NULL default '0',
  `name` varchar(30) collate utf8_bin NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 表的结构 `latlng`
--

CREATE TABLE IF NOT EXISTS `latlng` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `lat` float default NULL,
  `lng` float default NULL,
  `title` varchar(200) collate utf8_bin NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  `transit_station` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `latlng`
--


-- --------------------------------------------------------

--
-- 表的结构 `oray`
--

CREATE TABLE IF NOT EXISTS `oray` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(200) collate utf8_bin NOT NULL,
  `password` varchar(200) collate utf8_bin NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


--
-- 表的结构 `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL auto_increment,
  `role_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `actionname` varchar(20) collate utf8_bin NOT NULL,
  `denied` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=73 ;

--
-- 转存表中的数据 `permission`
--

INSERT INTO `permission` (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES
(7, 1, 1, 'show', 1),
(8, 1, 5, 'index', 1),
(9, 1, 5, 'add', 1),
(10, 1, 5, 'edit', 1),
(11, 1, 5, 'show', 1),
(12, 1, 5, 'delete', 1),
(13, 1, 5, 'assigntask', 1),
(14, 1, 5, 'iprint', 1),
(15, 1, 5, 'search', 1),
(16, 1, 6, 'index', 1),
(17, 1, 6, 'setdown', 1),
(18, 1, 6, 'show', 1),
(19, 1, 6, 'iprint', 1),
(20, 1, 7, 'index', 1),
(21, 1, 7, 'assessment', 1),
(22, 1, 7, 'show', 1),
(23, 1, 7, 'iprint', 1),
(24, 1, 2, 'show', 1),
(25, 1, 8, 'index', 1),
(26, 1, 8, 'toexcel', 1),
(27, 1, 8, 'chart', 1),
(28, 1, 8, 'iprint', 1),
(29, 1, 9, 'index', 1),
(30, 1, 9, 'toexcel', 1),
(31, 1, 9, 'chart', 1),
(32, 1, 9, 'iprint', 1),
(33, 1, 10, 'index', 1),
(34, 1, 10, 'toexcel', 1),
(35, 1, 10, 'chart', 1),
(36, 1, 10, 'iprint', 1),
(37, 1, 3, 'show', 1),
(38, 1, 11, 'index', 1),
(39, 1, 11, 'mark', 1),
(40, 1, 11, 'delete', 1),
(41, 1, 12, 'index', 1),
(42, 1, 12, 'mark', 1),
(43, 1, 12, 'delete', 1),
(44, 1, 19, 'index', 1),
(45, 1, 19, 'config', 1),
(46, 1, 19, 'register', 1),
(47, 1, 4, 'show', 1),
(48, 1, 13, 'index', 1),
(49, 1, 13, 'add', 1),
(50, 1, 13, 'edit', 1),
(51, 1, 13, 'delete', 1),
(52, 1, 14, 'index', 1),
(53, 1, 14, 'add', 1),
(54, 1, 14, 'edit', 1),
(55, 1, 14, 'delete', 1),
(56, 1, 14, 'permission', 1),
(57, 1, 15, 'index', 1),
(58, 1, 15, 'add', 1),
(59, 1, 15, 'edit', 1),
(60, 1, 15, 'delete', 1),
(61, 1, 16, 'index', 1),
(62, 1, 16, 'add', 1),
(63, 1, 16, 'edit', 1),
(64, 1, 16, 'delete', 1),
(65, 1, 17, 'index', 1),
(66, 1, 17, 'add', 1),
(67, 1, 17, 'edit', 1),
(68, 1, 17, 'delete', 1),
(69, 1, 18, 'index', 1),
(70, 1, 18, 'optimize', 1),
(71, 1, 18, 'backup', 1),
(72, 1, 18, 'restore', 1);

-- --------------------------------------------------------

--
-- 表的结构 `resource`
--

CREATE TABLE IF NOT EXISTS `resource` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(30) collate utf8_bin NOT NULL,
  `chinesename` varchar(30) collate utf8_bin NOT NULL,
  `actionlist` varchar(200) collate utf8_bin NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `resource`
--

INSERT INTO `resource` (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES
(1, 0, 'functionmodel', '功能模块', 'show', '功能模块'),
(2, 0, 'statistics', '统计分析', 'show', '统计分析'),
(3, 0, 'tools', '辅助工具', 'show', '辅助工具'),
(4, 0, 'systemmanager', '系统管理', 'show', '系统管理'),
(5, 1, 'bxsheet', '报修单管理', 'index,add,edit,show,delete,assigntask,iprint,search', '报修单管理'),
(6, 1, 'wxsheet', '检修单管理 ', 'index,setdown,show,iprint', '检修单管理'),
(7, 1, 'custom_assessment', '客户评价管理', 'index,assessment,show,iprint', '客户评价管理'),
(8, 2, 'assessment_stat', '客户满意度统计', 'index,toexcel,chart,iprint', '客户满意度统计'),
(9, 2, 'fault_stat_byclass', '故障类别统计', 'index,toexcel,chart,iprint', '故障类别统计'),
(10, 2, 'fault_stat_bycompany', '报修部门报修统计', 'index,toexcel,chart,iprint', '报修部门报修统计'),
(11, 3, 'gmap', '谷歌地图(试鲜版)', 'index,mark,delete', '谷歌地图(试鲜版)'),
(12, 3, 'bmap', '百度地图(试鲜版)', 'index,mark,delete', '百度地图(试鲜版)'),
(13, 4, 'system', '系统设置', 'index,add,edit,delete', '系统设置'),
(14, 4, 'role', '角色管理', 'index,add,edit,delete,permission', '角色管理'),
(15, 4, 'user', '用户管理', 'index,add,edit,delete', '用户管理'),
(16, 4, 'bxsheet_class', '报修类别管理', 'index,add,edit,delete', '报修类别管理'),
(17, 4, 'assessment_class', '评价类别管理', 'index,add,edit,delete', '评价类别管理'),
(18, 4, 'database', '数据库管理', 'index,optimize,backup,restore', '数据库管理'),
(19, 3, 'oray', '向日葵远程控制', 'index,config,register', '向日葵远程控制');

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(30) collate utf8_bin NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`id`, `parent_id`, `name`, `profile`, `type`) VALUES
(1, 0, '管理员', '管理员,拥有全部权限', 0),
(2, 0, '新进工程师', '新进工程师', 2),
(3, 0, '熟练工程师', '熟练工程师', 2),
(4, 0, '一般客户', '一般客户', 1),
(5, 0, '重点客户', '重点客户', 1),
(6, 0, '战略客户', '重点客户', 1);

-- --------------------------------------------------------

--
-- 表的结构 `ttsqueue`
--

CREATE TABLE IF NOT EXISTS `ttsqueue` (
  `id` int(11) NOT NULL auto_increment,
  `text` varchar(200) collate utf8_bin NOT NULL,
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `rule_name` varchar(30) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL auto_increment,
  `role_id` int(11) NOT NULL default '1',
  `username` varchar(25) collate utf8_bin NOT NULL,
  `password` varchar(34) collate utf8_bin NOT NULL,
  `realname` varchar(25) collate utf8_bin NOT NULL,
  `email` varchar(100) collate utf8_bin default NULL,
  `workphone` varchar(12) collate utf8_bin NOT NULL,
  `mobilephone` varchar(12) collate utf8_bin NOT NULL,
  `company` varchar(100) collate utf8_bin NOT NULL,
  `department` varchar(100) collate utf8_bin NOT NULL,
  `workaddress` varchar(100) collate utf8_bin NOT NULL,
  `work_addr_province` varchar(60) collate utf8_bin NOT NULL,
  `work_addr_city` varchar(60) collate utf8_bin NOT NULL,
  `work_addr_area` varchar(60) collate utf8_bin NOT NULL,
  `work_addr_street` varchar(60) collate utf8_bin NOT NULL,
  `work_addr_detail` varchar(100) collate utf8_bin NOT NULL,
  `controller` varchar(20) collate utf8_bin default 'welcome',
  `action` varchar(20) collate utf8_bin default 'index',
  `banned` tinyint(1) NOT NULL default '0',
  `ban_reason` varchar(255) collate utf8_bin default NULL,
  `newpass` varchar(34) collate utf8_bin default NULL,
  `newpass_key` varchar(32) collate utf8_bin default NULL,
  `newpass_time` datetime default NULL,
  `last_ip` varchar(40) collate utf8_bin NOT NULL,
  `last_login_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modify_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;


