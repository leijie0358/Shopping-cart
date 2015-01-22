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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (21, 1, 19, '');
INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (27, 8, 19, '');
INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (29, 9, 19, '');
INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (30, 10, 19, '');
INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (31, 26, 36, '');
INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (32, 63, 36, '');
INSERT INTO assignwork (`id`, `bxsheet_id`, `user_id`, `profile`) VALUES (34, 66, 36, '');


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
  `booking_time` datetime NOT NULL,
  `wx_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `fault_reason` varchar(60) collate utf8_bin NOT NULL,
  `wx_profile` varchar(60) collate utf8_bin NOT NULL,
  `wx_fee` decimal(10,2) default NULL,
  `status` int(11) default '0',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `creater_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `booking_time`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (1, 'DN201104070001', 35, '郎科计算机', '张三', '0555-1346321', '', '安徽', '马鞍山', '', '', '十七冶医院', '2011-04-10 19:20:00', '2011-04-10 22:20:00', '2011-04-10 19:20:00', 1, '电脑无缘无故坏了', '电脑无缘无故坏了,你们的东西实在太差了', 1, 'abcdefg', '0000-00-00 00:00:00', '2011-04-10 19:20:00', '操作系统坏了', '重装了操作系统', '60.00', 2, '2011-04-10 19:20:16', 1);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `booking_time`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (8, 'JD201104100002', 20, '十七冶医院', '王小明', '', '18726021081', '江苏', '苏州', '', '', '十七冶医院', '2011-04-10 00:00:00', '2011-04-10 16:00:00', '2011-04-10 21:21:00', 1, '电视机坏了', '好象给烧了', 2, '', '0000-00-00 00:00:00', '2011-04-16 15:59:00', '未知', '去的时候就好了', '60.00', 3, '2011-04-10 21:21:26', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `booking_time`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (9, 'JD201104100003', 20, '十七冶医院', '王小明', '012', '12366881236', '江苏', '苏州', '苦', 'adf', '十七冶医院', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '又坏了', '又坏了', 2, 'fdsaf', '0000-00-00 00:00:00', '2011-04-16 16:05:00', '不知道', '莫名其妙就好了', '234.00', 3, '0000-00-00 00:00:00', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `booking_time`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (31, 'DN201105020001', 20, '十七冶医院', '王小明', '', '18726021081', '安徽', '马鞍山', '', '', '雨山区十七冶医院2-606', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-05-02 18:14:00', 2, '电脑坏了', '', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', NULL, 0, '2011-05-02 18:14:44', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `booking_time`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (34, 'DN201105020001', 20, '十七冶医院', '王小明', '', '18726021081', '安徽', '马鞍山', '', '', '雨山区十七冶医院2-606', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-05-02 18:23:00', 2, '电脑打不开了', '', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', NULL, 0, '2011-05-02 18:23:51', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `booking_time`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (57, 'JD201105020001', 0, '马鞍山携程软件研发有限公司', '刘长青', '', '', '安徽', '马鞍山', '', '', '翠岛华庭1-602', '1970-01-01 08:00:00', '1970-01-01 08:00:00', '2011-05-02 23:37:00', 1, '微波炉烧了很可怜', '', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', NULL, 0, '2011-05-02 23:38:41', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `booking_time`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (58, 'JD201105020002', 35, '明远计算机', '许慧', '0555-1346321', '', '安徽', '马鞍山', '', '', '华海3C', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-05-02 23:41:00', 1, 'MP8不能播放音乐了', '', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', NULL, 0, '2011-05-02 23:42:33', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `booking_time`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (61, 'JD201105030001', 20, '十七冶医院', '王小明', '', '18726021081', '安徽', '马鞍山', '', '', '雨山区十七冶医院2-606', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-05-03 09:02:00', 1, '坏的很严重', '', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', NULL, 0, '2011-05-03 09:03:02', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `booking_time`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (62, 'FWQ201105030001', 0, '马鞍山携程软件研发有限公司', '刘长青', '', '13812345678', '安徽', '马鞍山', '', '', '翠岛华庭1－602', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-05-03 09:04:00', 3, '启动不了了', '故障现象', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', NULL, 0, '2011-05-03 09:05:00', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `booking_time`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (63, 'JD201105030002', 20, '十七冶医院', '王小明', '23345333', '18726021081', '安徽', '马鞍山', '', '', '雨山区十七冶医院2-606', '2011-05-03 10:00:00', '2011-05-03 11:00:00', '2011-05-03 09:06:00', 1, '黑屏打不开', '有声音打不开电视了！', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', NULL, 1, '2011-05-03 09:07:32', NULL);
INSERT INTO bxsheet (`id`, `number`, `custom_id`, `custom_company`, `custom_name`, `custom_workphone`, `custom_mobilephone`, `custom_addr_province`, `custom_addr_city`, `custom_addr_area`, `custom_addr_street`, `custom_addr_detail`, `hope_wx_time_begin`, `hope_wx_time_end`, `bx_time`, `bxsheet_class_id`, `fault_title`, `fault_profile`, `assessment_class_id`, `assessment_content`, `booking_time`, `wx_time`, `fault_reason`, `wx_profile`, `wx_fee`, `status`, `create_time`, `creater_id`) VALUES (66, 'DN201105030001', 20, '十七冶医院', '王小明', '', '18726021081', '安徽', '马鞍山', '', '', '雨山区十七冶医院2-606', '2011-05-03 10:00:00', '2011-05-03 16:00:00', '2011-05-03 15:47:00', 2, '电脑黑屏', '电脑死机打不开了', 4, '服务速度很快，解决问题很及时', '0000-00-00 00:00:00', '2011-05-03 16:08:00', '显卡已损坏，导致电脑打不开', '已经更换新的显卡，故障已解决', '358.50', 3, '2011-05-03 15:48:48', NULL);


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
INSERT INTO bxsheet_class (`id`, `parent_id`, `name`, `profile`) VALUES (3, 0, '服务器', '服务器');


#
# TABLE STRUCTURE FOR: latlng
#

DROP TABLE IF EXISTS latlng;

CREATE TABLE `latlng` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `lat` float default NULL,
  `lng` float default NULL,
  `title` varchar(200) collate utf8_bin NOT NULL,
  `profile` varchar(200) collate utf8_bin NOT NULL,
  `transit_station` varchar(200) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO latlng (`id`, `user_id`, `lat`, `lng`, `title`, `profile`, `transit_station`) VALUES (77, 35, '31.6975', '118.517', '公司地址', '公司地址', '解放路');
INSERT INTO latlng (`id`, `user_id`, `lat`, `lng`, `title`, `profile`, `transit_station`) VALUES (86, 20, '31.694', '118.502', '公司地址', '儿童公园三幢8号房', '安徽工业大学');
INSERT INTO latlng (`id`, `user_id`, `lat`, `lng`, `title`, `profile`, `transit_station`) VALUES (88, 20, '31.7036', '118.516', '仓库', '体育馆附近', '美华电脑学校(文化宫)');


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
) ENGINE=InnoDB AUTO_INCREMENT=1368 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (418, 2, 1, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (419, 2, 2, 'show', 1);
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
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1228, 3, 1, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1229, 3, 4, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1230, 3, 4, 'add', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1231, 3, 4, 'edit', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1232, 3, 4, 'assigntask', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1233, 3, 6, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1234, 3, 6, 'setdown', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1235, 3, 6, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1236, 3, 6, 'iprint', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1237, 3, 2, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1238, 3, 9, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1239, 3, 9, 'add', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1240, 3, 9, 'edit', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1241, 3, 9, 'delete', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1242, 3, 9, 'permission', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1324, 7, 5, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1325, 7, 5, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1326, 7, 5, 'iprint', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1327, 7, 6, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1328, 7, 6, 'setdown', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1329, 7, 6, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1330, 7, 6, 'iprint', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1331, 7, 7, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1332, 7, 2, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1333, 7, 8, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1334, 7, 9, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1335, 7, 10, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1336, 7, 3, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1337, 7, 11, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1338, 7, 11, 'delete', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1339, 7, 12, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1340, 7, 12, 'delete', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1341, 7, 4, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1342, 7, 13, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1348, 8, 1, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1349, 8, 6, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1350, 8, 6, 'setdown', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1351, 8, 6, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1352, 8, 6, 'iprint', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1353, 10, 1, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1354, 10, 6, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1355, 10, 6, 'setdown', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1356, 10, 6, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1357, 10, 6, 'iprint', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1358, 4, 1, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1359, 4, 5, 'index', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1360, 4, 5, 'add', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1361, 4, 5, 'edit', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1362, 4, 5, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1363, 4, 5, 'delete', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1364, 4, 5, 'iprint', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1365, 4, 5, 'search', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1366, 4, 2, 'show', 1);
INSERT INTO permission (`id`, `role_id`, `resource_id`, `actionname`, `denied`) VALUES (1367, 4, 9, 'index', 1);


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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (1, 0, 'functionmodel', '功能模块', 'show', '功能模块');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (2, 0, 'statistics', '统计分析', 'show', '统计分析');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (3, 0, 'tools', '辅助工具', 'show', '辅助工具');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (4, 0, 'systemmanager', '系统管理', 'show', '系统管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (5, 1, 'bxsheet', '报修单管理', 'index,add,edit,show,delete,assigntask,iprint,search', '报修单管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (6, 1, 'wxsheet', '检修单管理 ', 'index,setdown,show,iprint', '检修单管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (7, 1, 'custom_assessment', '客户评价管理', 'index,assessment,show,iprint', '客户评价管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (8, 2, 'assessment_stat', '客户满意度统计', 'index,toexcel,chart,iprint', '客户满意度统计');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (9, 2, 'fault_stat_byclass', '故障类别统计', 'index,toexcel,chart,iprint', '故障类别统计');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (10, 2, 'fault_stat_bycompany', '报修部门报修统计', 'index,toexcel,chart,iprint', '报修部门报修统计');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (11, 3, 'gmap', '谷歌地图(试鲜版)', 'index,mark,delete', '谷歌地图(试鲜版)');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (12, 3, 'bmap', '百度地图(试鲜版)', 'index,mark,delete', '百度地图(试鲜版)');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (13, 4, 'system', '系统设置', 'index,add,edit,delete', '系统设置');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (14, 4, 'role', '角色管理', 'index,add,edit,delete,permission', '角色管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (15, 4, 'user', '用户管理', 'index,add,edit,delete', '用户管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (16, 4, 'bxsheet_class', '报修类别管理', 'index,add,edit,delete', '报修类别管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (17, 4, 'assessment_class', '评价类别管理', 'index,add,edit,delete', '评价类别管理');
INSERT INTO resource (`id`, `parent_id`, `name`, `chinesename`, `actionlist`, `profile`) VALUES (18, 4, 'database', '数据库管理', 'index,optimize,backup,restore', '数据库管理');


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
INSERT INTO role (`id`, `parent_id`, `name`, `profile`, `type`) VALUES (6, 0, '战略工程师', '战略工程师', 2);


#
# TABLE STRUCTURE FOR: ttsqueue
#

DROP TABLE IF EXISTS ttsqueue;

CREATE TABLE `ttsqueue` (
  `id` int(11) NOT NULL auto_increment,
  `text` varchar(200) collate utf8_bin NOT NULL,
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `rule_name` varchar(30) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO ttsqueue (`id`, `text`, `create_time`, `rule_name`) VALUES (13, '十七冶医院-王小明的电脑出现了一个问题:电脑黑屏,报修时间为2011-05-03 15:47,请处理', '2011-05-03 15:48:00', '');
INSERT INTO ttsqueue (`id`, `text`, `create_time`, `rule_name`) VALUES (14, '马鞍山携程软件-张总的服务器出现了一个问题:服务器系统崩溃,报修时间为2011-05-03 15:49,请处理', '2011-05-03 15:50:00', '');


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
  `work_addr_province` varchar(100) collate utf8_bin NOT NULL,
  `work_addr_city` varchar(100) collate utf8_bin NOT NULL,
  `work_addr_area` varchar(100) collate utf8_bin NOT NULL,
  `work_addr_street` varchar(100) collate utf8_bin NOT NULL,
  `work_addr_detail` varchar(100) collate utf8_bin NOT NULL,
  `controller` varchar(20) collate utf8_bin NOT NULL default 'welcome',
  `action` varchar(20) collate utf8_bin NOT NULL default 'index',
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

INSERT INTO user (`id`, `role_id`, `username`, `password`, `realname`, `email`, `workphone`, `mobilephone`, `company`, `department`, `workaddress`, `work_addr_province`, `work_addr_city`, `work_addr_area`, `work_addr_street`, `work_addr_detail`, `controller`, `action`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login_time`, `create_time`, `modify_time`) VALUES (18, 1, 'admin', 'c4ca4238a0b923820dcc509a6f75849b', '管理员', 'admin@localhost.com', '', '18726021081', '马鞍山携程软件', '技术部', '马鞍山花山区翠岛华庭1-602', '安徽', '马鞍山', '', '', '花山区翠岛华庭1-602', 'welcome', 'index', 0, NULL, NULL, NULL, NULL, '127.0.0.1', '2011-04-05 04:56:38', '2011-04-05 04:56:32', '2011-04-29 23:21:42');
INSERT INTO user (`id`, `role_id`, `username`, `password`, `realname`, `email`, `workphone`, `mobilephone`, `company`, `department`, `workaddress`, `work_addr_province`, `work_addr_city`, `work_addr_area`, `work_addr_street`, `work_addr_detail`, `controller`, `action`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login_time`, `create_time`, `modify_time`) VALUES (19, 2, 'engineer', 'c4ca4238a0b923820dcc509a6f75849b', '李工', 'engineer@localhost.com', '', '18726021081', '马鞍山携程软件 this is a book  this is a book', '技术部', '', '安徽', '马鞍山', '', '', '花山区翠岛华庭1-602', 'welcome', 'index', 0, '', NULL, NULL, NULL, '127.0.0.1', '2011-04-05 04:56:38', '2011-04-05 04:56:32', '2011-04-30 12:02:29');
INSERT INTO user (`id`, `role_id`, `username`, `password`, `realname`, `email`, `workphone`, `mobilephone`, `company`, `department`, `workaddress`, `work_addr_province`, `work_addr_city`, `work_addr_area`, `work_addr_street`, `work_addr_detail`, `controller`, `action`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login_time`, `create_time`, `modify_time`) VALUES (20, 4, 'wxm', 'c4ca4238a0b923820dcc509a6f75849b', '王小明', 'custom@localhost.com', '', '18726021081', '十七冶医院', '信息中心', '', '安徽', '马鞍山', '', '', '雨山区十七冶医院2-606', 'custom_assessment', 'index', 0, '客户已不联系', NULL, NULL, NULL, '127.0.0.1', '2011-04-05 14:04:14', '2011-04-05 14:01:53', '2011-04-29 23:23:05');
INSERT INTO user (`id`, `role_id`, `username`, `password`, `realname`, `email`, `workphone`, `mobilephone`, `company`, `department`, `workaddress`, `work_addr_province`, `work_addr_city`, `work_addr_area`, `work_addr_street`, `work_addr_detail`, `controller`, `action`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login_time`, `create_time`, `modify_time`) VALUES (35, 4, 'zs', 'c4ca4238a0b923820dcc509a6f75849b', '张三', '', '0555-1346321', '', '明远计算机', '', '安工大对面', '安徽', '马鞍山', '', '', '华海3C', 'bxsheet', 'index', 0, NULL, NULL, NULL, NULL, '127.0.0.1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-04-29 23:23:17');
INSERT INTO user (`id`, `role_id`, `username`, `password`, `realname`, `email`, `workphone`, `mobilephone`, `company`, `department`, `workaddress`, `work_addr_province`, `work_addr_city`, `work_addr_area`, `work_addr_street`, `work_addr_detail`, `controller`, `action`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login_time`, `create_time`, `modify_time`) VALUES (36, 3, 'wg', 'c4ca4238a0b923820dcc509a6f75849b', '王明', '', '0555-3501119', '', '', '', '', '江苏', '无锡', '', '', '', 'wxsheet', 'index', 0, '', NULL, NULL, NULL, '127.0.0.1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2011-04-30 12:03:57');


