#
# TABLE STRUCTURE FOR: assessment_class
#

DROP TABLE IF EXISTS assessment_class;

CREATE TABLE `assessment_class` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(30) collate utf8_bin NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO assessment_class (`id`, `parent_id`, `name`, `profile`) VALUES (1, 0, '不满意', '服务态度恶劣');
INSERT INTO assessment_class (`id`, `parent_id`, `name`, `profile`) VALUES (2, 0, '一般', '不好也不坏,没什么感觉');
INSERT INTO assessment_class (`id`, `parent_id`, `name`, `profile`) VALUES (3, 0, '满意', '服务基本上没什么问题');
INSERT INTO assessment_class (`id`, `parent_id`, `name`, `profile`) VALUES (4, 0, '非常满意', '服务态度相当的好');


#
# TABLE STRUCTURE FOR: assignwork
#

DROP TABLE IF EXISTS assignwork;

CREATE TABLE `assignwork` (
  `id` int(11) NOT NULL auto_increment,
  `bxsheet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (21, 1, 19, '');
INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (22, 7, 36, '');
INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (27, 8, 19, '');
INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (28, 8, 36, '');
INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (29, 9, 19, '');
INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (30, 10, 19, '');
INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (31, 11, 36, '');


#
# TABLE STRUCTURE FOR: bxsheet
#

DROP TABLE IF EXISTS bxsheet;

CREATE TABLE `bxsheet` (
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
  `wx_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `fault_reason` varchar(60) collate utf8_bin NOT NULL,
  `wx_profile` varchar(60) collate utf8_bin NOT NULL,
  `wx_fee` int(11) default NULL,
  `status` int(11) default '0',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `creater_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (1, 'DN201104070001', 35, '郎科计算机', '张三', '0555-1346321', '', '安徽', '马鞍山', '', '', '十七冶医院', '2011-04-10 19:20:00', '2011-04-10 22:20:00', '2011-04-10 19:20:00', 1, '电脑无缘无故坏了111111', '电脑无缘无故坏了,你们的东西实在太差了', 1, 'abcdefg', '2011-04-10 19:20:00', '操作系统坏了1', '重装了操作系统', 60, 3, '2011-04-10 19:20:16', 1);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (8, 'JD201104100002', 20, '十七冶医院', '王小明', '', '18726021081', '江苏', '苏州', '', '', '十七冶医院', '2011-04-10 00:00:00', '2011-04-10 16:00:00', '2011-04-10 21:21:00', 1, '电视机坏了', '好象给烧了', 2, '', '2011-04-16 15:59:00', 'dfdsf', 'fdasfad', 60, 3, '2011-04-10 21:21:26', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (9, 'JD201104100003', 20, '十七冶医院', '王小明', '012', '12366881236', '江苏', '苏州', '苦', 'adf', '十七冶医院', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '又坏了', '又坏了', 2, 'fdsaf', '2011-04-16 16:05:00', 'fdsaf', 'fdsafdsaf', 0, 3, '0000-00-00 00:00:00', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (10, 'JD201104160001', 35, '郎科计算机', '张三', '123', '123', '安徽', '合肥', '', '', '哈哈', '2011-04-16 00:00:00', '2011-04-20 00:00:00', '2011-04-16 15:54:00', 1, 'dfdsa', 'fdsafdsaf', 1, '收钱太黑了', '2011-04-17 23:42:00', 'adf', 'fdsafdasf王五', 1200, 3, '2011-04-16 15:55:36', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (11, 'JD201104160002', 35, 'fdsafas', 'fdsaf', 'fdsaf', 'fdsaf', '安徽', '合肥', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-04-16 16:08:00', 1, 'fdsaf', 'fdsaf', 1, '', '2011-04-18 16:08:00', 'ddd', 'afdsafdsaf王五', 0, 2, '2011-04-16 16:08:10', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (12, 'JD201104180001', 20, '十七冶医院', '王小明', '', '18726021081', '江苏', '无锡', '', '', '十七冶医院', '1970-01-01 08:00:00', '1970-01-01 08:00:00', '2011-04-18 14:23:00', 1, '', '', NULL, '', '0000-00-00 00:00:00', '', '', NULL, 0, '2011-04-18 14:23:51', NULL);


#
# TABLE STRUCTURE FOR: bxsheet_class
#

DROP TABLE IF EXISTS bxsheet_class;

CREATE TABLE `bxsheet_class` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(30) collate utf8_bin NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO bxsheet_class (`id`, `parent_id`, `name`, `profile`) VALUES (1, 0, '家电', '家电');
INSERT INTO bxsheet_class (`id`, `parent_id`, `name`, `profile`) VALUES (2, 0, '电脑', '电脑');
INSERT INTO bxsheet_class (`id`, `parent_id`, `name`, `profile`) VALUES (3, 0, '服务器', '服务器1');


#
# TABLE STRUCTURE FOR: permission
#

DROP TABLE IF EXISTS permission;

CREATE TABLE `permission` (
  `id` int(11) NOT NULL auto_increment,
  `role_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `actionname` varchar(20) collate utf8_bin NOT NULL,
  `denied` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1181 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (418, 2, 1, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (419, 2, 2, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (844, 4, 1, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (845, 4, 5, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (846, 4, 5, 'assessment', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (847, 4, 5, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (848, 4, 5, 'iprint', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (849, 4, 2, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (850, 4, 9, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (851, 4, 9, 'add', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (852, 4, 9, 'edit', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (853, 4, 9, 'delete', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (854, 4, 9, 'permission', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (871, 3, 1, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (872, 3, 4, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (873, 3, 4, 'add', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (874, 3, 4, 'edit', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (875, 3, 4, 'assigntask', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (876, 3, 6, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (877, 3, 6, 'setdown', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (878, 3, 6, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (879, 3, 6, 'iprint', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (880, 3, 2, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (881, 3, 9, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (882, 3, 9, 'add', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (883, 3, 9, 'edit', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (884, 3, 9, 'delete', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (885, 3, 9, 'permission', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (886, 3, 3, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1138, 1, 1, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1139, 1, 4, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1140, 1, 4, 'add', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1141, 1, 4, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1142, 1, 4, 'delete', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1143, 1, 4, 'assigntask', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1144, 1, 4, 'iprint', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1145, 1, 4, 'search', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1146, 1, 5, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1147, 1, 5, 'assessment', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1148, 1, 5, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1149, 1, 5, 'iprint', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1150, 1, 6, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1151, 1, 6, 'setdown', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1152, 1, 6, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1153, 1, 6, 'iprint', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1154, 1, 2, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1155, 1, 7, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1156, 1, 7, 'add', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1157, 1, 7, 'edit', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1158, 1, 7, 'delete', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1159, 1, 8, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1160, 1, 8, 'add', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1161, 1, 8, 'edit', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1162, 1, 8, 'delete', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1163, 1, 9, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1164, 1, 9, 'add', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1165, 1, 9, 'edit', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1166, 1, 9, 'delete', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1167, 1, 9, 'permission', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1168, 1, 10, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1169, 1, 10, 'optimize', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1170, 1, 10, 'backup', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1171, 1, 10, 'restore', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1172, 1, 11, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1173, 1, 11, 'add', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1174, 1, 11, 'edit', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1175, 1, 11, 'delete', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1176, 1, 12, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1177, 1, 12, 'add', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1178, 1, 12, 'edit', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1179, 1, 12, 'delete', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1180, 1, 3, 'show', 1);


#
# TABLE STRUCTURE FOR: resource
#

DROP TABLE IF EXISTS resource;

CREATE TABLE `resource` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(30) collate utf8_bin NOT NULL,
  `chinesename` varchar(30) collate utf8_bin NOT NULL,
  `actionlist` varchar(200) collate utf8_bin NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (1, 0, 'functionmodel', '功能模块', 'show', '功能模块');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (2, 0, 'systemmanager', '系统管理', 'show', '系统管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (3, 0, 'statistics', '统计分析', 'show', '统计分析');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (4, 1, 'bxsheet', '报修单管理', 'index,add,edit,show,delete,assigntask,iprint,search', '报修单管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (5, 1, 'custom_assessment', '客户评价管理', 'index,assessment,show,iprint', '客户评价管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (6, 1, 'wxsheet', '检修单管理 ', 'index,setdown,show,iprint', '检修单管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (7, 2, 'system', '系统设置', 'index,add,edit,delete', '系统设置');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (8, 2, 'user', '用户管理', 'index,add,edit,delete', '用户管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (9, 2, 'role', '角色管理', 'index,add,edit,delete,permission', '角色管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (10, 2, 'database', '数据库管理', 'index,optimize,backup,restore', '数据库管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (11, 2, 'bxsheet_class', '报修类别管理', 'index,add,edit,delete', '报修类别管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (12, 2, 'assessment_class', '评价类别管理', 'index,add,edit,delete', '评价类别管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (13, 3, 'assessment_stat', '客户满意度统计', 'index,toexcel,chart,iprint', '客户满意度统计');


#
# TABLE STRUCTURE FOR: role
#

DROP TABLE IF EXISTS role;

CREATE TABLE `role` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(30) collate utf8_bin NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO role (`id`, `parent_id`, `name`, `profile`, `type`) VALUES (1, 0, '管理员', '管理员,拥有全部权限', 3);
INSERT INTO role (`id`, `parent_id`, `name`, `profile`, `type`) VALUES (2, 0, '新进工程师', '新进工程师', 2);
INSERT INTO role (`id`, `parent_id`, `name`, `profile`, `type`) VALUES (3, 0, '熟练工程师', '熟练工程师', 2);
INSERT INTO role (`id`, `parent_id`, `name`, `profile`, `type`) VALUES (4, 0, '一般客户', '一般客户', 1);
INSERT INTO role (`id`, `parent_id`, `name`, `profile`, `type`) VALUES (5, 0, '重点客户', '重点客户', 1);
INSERT INTO role (`id`, `parent_id`, `name`, `profile`, `type`) VALUES (6, 0, '战略客户', '战略客户', 1);


#
# TABLE STRUCTURE FOR: user
#

DROP TABLE IF EXISTS user;

CREATE TABLE `user` (
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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO user (`id`, `role_id`, `username`, `password`, `realname`, `email`, `workphone`, `mobilephone`, `company`, `department`, `workaddress`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login_time`, `create_time`, `modify_time`) VALUES (18, 1, 'admin', 'c4ca4238a0b923820dcc509a6f75849b', '管理员', 'admin@localhost.com', '', '18726021081', '马鞍山携程软件', '技术部', '马鞍山花山区翠岛华庭1-602', 0, NULL, NULL, NULL, NULL, '127.0.0.1', '2011-04-05 04:56:38', '2011-04-05 04:56:32', '2011-04-18 16:10:08');
INSERT INTO user (`id`, `role_id`, `username`, `password`, `realname`, `email`, `workphone`, `mobilephone`, `company`, `department`, `workaddress`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login_time`, `create_time`, `modify_time`) VALUES (19, 2, 'engineer', 'c4ca4238a0b923820dcc509a6f75849b', '李工', 'engineer@localhost.com', '', '18726021081', '马鞍山携程软件', '技术部', '马鞍山花山区翠岛华庭1-602', 0, NULL, NULL, NULL, NULL, '127.0.0.1', '2011-04-05 04:56:38', '2011-04-05 04:56:32', '2011-04-10 17:19:57');
INSERT INTO user (`id`, `role_id`, `username`, `password`, `realname`, `email`, `workphone`, `mobilephone`, `company`, `department`, `workaddress`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login_time`, `create_time`, `modify_time`) VALUES (20, 4, 'wxm', 'c4ca4238a0b923820dcc509a6f75849b', '王小明', 'custom@localhost.com', '', '18726021081', '十七冶医院', '信息中心', '马鞍山雨山区十七冶医院2-606', 0, NULL, NULL, NULL, NULL, '127.0.0.1', '2011-04-05 14:04:14', '2011-04-05 14:01:53', '2011-04-10 21:20:22');
INSERT INTO user (`id`, `role_id`, `username`, `password`, `realname`, `email`, `workphone`, `mobilephone`, `company`, `department`, `workaddress`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login_time`, `create_time`, `modify_time`) VALUES (35, 4, 'zs', 'c4ca4238a0b923820dcc509a6f75849b', '张三', '', '0555-1346321', '', '郎科计算机', '', '安工大对面', 0, NULL, NULL, NULL, NULL, '127.0.0.1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-04-15 13:34:49');
INSERT INTO user (`id`, `role_id`, `username`, `password`, `realname`, `email`, `workphone`, `mobilephone`, `company`, `department`, `workaddress`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login_time`, `create_time`, `modify_time`) VALUES (36, 3, 'wg', 'c4ca4238a0b923820dcc509a6f75849b', '王工', '', '0555-1234567', '', '', '', '', 0, NULL, NULL, NULL, NULL, '127.0.0.1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-04-16 11:42:39');


