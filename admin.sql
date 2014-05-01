/*
Navicat MySQL Data Transfer

Source Server         : conn
Source Server Version : 50106
Source Host           : localhost:3306
Source Database       : admin

Target Server Type    : MYSQL
Target Server Version : 50106
File Encoding         : 65001

Date: 2014-05-02 03:51:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `kl_addons`
-- ----------------------------
DROP TABLE IF EXISTS `kl_addons`;
CREATE TABLE `kl_addons` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` char(50) default NULL,
  `mark` char(50) default NULL,
  `version` char(50) default NULL,
  `author` char(50) default NULL,
  `descr` varchar(255) default NULL,
  `install` tinyint(1) NOT NULL default '1',
  `param` text,
  `type` char(50) default 'other',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kl_addons
-- ----------------------------
INSERT INTO `kl_addons` VALUES ('4', '系统信息', 'AdminInfo', '1.0', 'qiaokeli', '插件描述', '1', null, 'system', '1');
INSERT INTO `kl_addons` VALUES ('6', 'HTML编辑器', 'Editor', '4.1.7', 'qiaokeli', 'Editor', '1', '{\"edittype\":\"1\"}', 'system', '1');
INSERT INTO `kl_addons` VALUES ('7', '系统内容信息', 'ConInfo', '1.0', 'qiaokeli', '插件描述', '1', null, 'system', '1');

-- ----------------------------
-- Table structure for `kl_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `kl_attribute`;
CREATE TABLE `kl_attribute` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '' COMMENT '字段名',
  `title` varchar(100) NOT NULL default '' COMMENT '字段注释',
  `field` varchar(100) NOT NULL default '' COMMENT '字段定义',
  `type` varchar(20) NOT NULL default '' COMMENT '数据类型',
  `value` varchar(100) NOT NULL default '' COMMENT '字段默认值',
  `remark` varchar(100) NOT NULL default '' COMMENT '备注',
  `is_show` tinyint(1) unsigned NOT NULL default '1' COMMENT '是否显示',
  `extra` text NOT NULL COMMENT '参数',
  `model_id` int(10) unsigned NOT NULL default '0' COMMENT '模型id',
  `is_must` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否必填',
  `status` tinyint(2) NOT NULL default '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL default '0' COMMENT '更新时间',
  `create_time` int(11) unsigned NOT NULL default '0' COMMENT '创建时间',
  `validate_rule` varchar(255) NOT NULL,
  `validate_time` tinyint(1) unsigned NOT NULL,
  `error_info` varchar(100) NOT NULL,
  `validate_type` varchar(25) NOT NULL,
  `auto_rule` varchar(100) NOT NULL,
  `auto_time` tinyint(1) unsigned NOT NULL,
  `auto_type` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `model_id` (`model_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='模型属性表';

-- ----------------------------
-- Records of kl_attribute
-- ----------------------------
INSERT INTO `kl_attribute` VALUES ('1', 'uid', '用户ID', 'int(10) unsigned NOT NULL ', 'num', '0', '', '0', '', '1', '0', '1', '1384508362', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('2', 'name', '标识', 'char(40) NOT NULL ', 'string', '', '同一根节点下标识不重复', '0', '', '1', '0', '1', '1397071245', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `kl_attribute` VALUES ('3', 'title', '标题', 'char(80) NOT NULL ', 'string', '', '文档标题', '1', '', '1', '0', '1', '1383894778', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('4', 'category_id', '所属分类', 'int(10) unsigned NOT NULL ', 'string', '', '', '0', '', '1', '0', '1', '1384508336', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('5', 'description', '描述', 'char(140) NOT NULL ', 'textarea', '', '', '1', '', '1', '0', '1', '1383894927', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('6', 'root', '根节点', 'int(10) unsigned NOT NULL ', 'num', '0', '该文档的顶级文档编号', '0', '', '1', '0', '1', '1384508323', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('7', 'pid', '所属ID', 'int(10) unsigned NOT NULL ', 'num', '0', '父文档编号', '0', '', '1', '0', '1', '1384508543', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('8', 'model_id', '内容模型ID', 'tinyint(3) unsigned NOT NULL ', 'num', '0', '该文档所对应的模型', '0', '', '1', '0', '1', '1384508350', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('9', 'type', '内容类型', 'tinyint(3) unsigned NOT NULL ', 'select', '2', '', '0', '1:目录\r\n2:主题\r\n3:段落', '1', '0', '1', '1397071277', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `kl_attribute` VALUES ('10', 'position', '推荐位', 'smallint(5) unsigned NOT NULL ', 'checkbox', '0', '多个推荐则将其推荐值相加', '1', '1:列表推荐\r\n2:频道页推荐\r\n4:首页推荐', '1', '0', '1', '1383895640', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('11', 'link_id', '外链', 'int(10) unsigned NOT NULL ', 'num', '0', '0-非外链，大于0-外链ID,需要函数进行链接与编号的转换', '0', '', '1', '0', '1', '1397070976', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `kl_attribute` VALUES ('12', 'cover_id', '封面', 'int(10) unsigned NOT NULL ', 'picture', '0', '0-无封面，大于0-封面图片ID，需要函数处理', '1', '', '1', '0', '1', '1384147827', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('13', 'display', '可见性', 'tinyint(3) unsigned NOT NULL ', 'radio', '1', '', '0', '0:不可见\r\n1:所有人可见', '1', '0', '1', '1397071340', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `kl_attribute` VALUES ('14', 'deadline', '截至时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '0-永久有效', '1', '', '1', '0', '1', '1387163248', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `kl_attribute` VALUES ('15', 'attach', '附件数量', 'tinyint(3) unsigned NOT NULL ', 'num', '0', '', '0', '', '1', '0', '1', '1387260355', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `kl_attribute` VALUES ('16', 'view', '浏览量', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '1', '0', '1', '1383895835', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('17', 'comment', '评论数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '1', '0', '1', '1383895846', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('18', 'extend', '扩展统计字段', 'int(10) unsigned NOT NULL ', 'num', '0', '根据需求自行使用', '0', '', '1', '0', '1', '1384508264', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('19', 'level', '优先级', 'int(10) unsigned NOT NULL ', 'num', '0', '越高排序越靠前', '0', '', '1', '0', '1', '1397071377', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `kl_attribute` VALUES ('20', 'create_time', '创建时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '', '1', '', '1', '0', '1', '1383895903', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('21', 'update_time', '更新时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '', '0', '', '1', '0', '1', '1384508277', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('22', 'status', '数据状态', 'tinyint(4) NOT NULL ', 'radio', '0', '', '0', '-1:删除\r\n0:禁用\r\n1:正常\r\n2:待审核\r\n3:草稿', '1', '0', '1', '1384508496', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('23', 'parse', '内容解析类型', 'tinyint(3) unsigned NOT NULL ', 'select', '0', '', '0', '0:html\r\n1:ubb\r\n2:markdown', '2', '0', '1', '1384511049', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('24', 'content', '文章内容', 'text NOT NULL ', 'editor', '', '', '1', '', '2', '0', '1', '1383896225', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('25', 'template', '详情页显示模板', 'varchar(100) NOT NULL ', 'string', '', '参照display方法参数的定义', '1', '', '2', '0', '1', '1383896190', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('26', 'bookmark', '收藏数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '2', '0', '1', '1383896103', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('27', 'parse', '内容解析类型', 'tinyint(3) unsigned NOT NULL ', 'select', '0', '', '0', '0:html\r\n1:ubb\r\n2:markdown', '3', '0', '1', '1387260461', '1383891252', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `kl_attribute` VALUES ('28', 'content', '下载详细描述', 'text NOT NULL ', 'editor', '', '', '1', '', '3', '0', '1', '1383896438', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('29', 'template', '详情页显示模板', 'varchar(100) NOT NULL ', 'string', '', '', '1', '', '3', '0', '1', '1383896429', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('30', 'file_id', '文件ID', 'int(10) unsigned NOT NULL ', 'file', '0', '需要函数处理', '1', '', '3', '0', '1', '1383896415', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('31', 'download', '下载次数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '3', '0', '1', '1383896380', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('32', 'size', '文件大小', 'bigint(20) unsigned NOT NULL ', 'num', '0', '单位bit', '1', '', '3', '0', '1', '1383896371', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `kl_attribute` VALUES ('43', 'testtitlea', '测试标题', 'varchar(255) NOT NULL', 'string', '', '', '1', '', '13', '0', '1', '1398880850', '1398880850', '', '3', '', 'regex', '', '3', 'function');
INSERT INTO `kl_attribute` VALUES ('44', 'testtitlea6', '测试标题', 'varchar(255) NOT NULL', 'string', '', '', '1', '', '13', '0', '1', '1398880896', '1398880896', '', '3', '', 'regex', '', '3', 'function');
INSERT INTO `kl_attribute` VALUES ('42', 'testtitle', '测试标题', 'varchar(255) NOT NULL', 'string', '', '', '1', '', '13', '0', '1', '1398881178', '1398880745', '', '3', '', 'regex', '', '3', 'function');

-- ----------------------------
-- Table structure for `kl_category`
-- ----------------------------
DROP TABLE IF EXISTS `kl_category`;
CREATE TABLE `kl_category` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '分类ID',
  `name` varchar(30) NOT NULL COMMENT '标志',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `pid` int(10) unsigned NOT NULL default '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL default '0' COMMENT '排序（同级有效）',
  `list_row` tinyint(3) unsigned NOT NULL default '10' COMMENT '列表每页行数',
  `meta_title` varchar(50) NOT NULL default '' COMMENT 'SEO的网页标题',
  `keywords` varchar(255) NOT NULL default '' COMMENT '关键字',
  `description` varchar(255) NOT NULL default '' COMMENT '描述',
  `template_index` varchar(100) NOT NULL COMMENT '频道页模板',
  `template_lists` varchar(100) NOT NULL COMMENT '列表页模板',
  `template_detail` varchar(100) NOT NULL COMMENT '详情页模板',
  `template_edit` varchar(100) NOT NULL COMMENT '编辑页模板',
  `model` varchar(100) NOT NULL default '' COMMENT '关联模型',
  `type` varchar(100) NOT NULL default '' COMMENT '允许发布的内容类型',
  `link_id` int(10) unsigned NOT NULL default '0' COMMENT '外链',
  `allow_publish` tinyint(3) unsigned NOT NULL default '0' COMMENT '是否允许发布内容',
  `display` tinyint(3) unsigned NOT NULL default '0' COMMENT '可见性',
  `reply` tinyint(3) unsigned NOT NULL default '0' COMMENT '是否允许回复',
  `check` tinyint(3) unsigned NOT NULL default '0' COMMENT '发布的文章是否需要审核',
  `reply_model` varchar(100) NOT NULL default '',
  `extend` text NOT NULL COMMENT '扩展设置',
  `create_time` int(10) unsigned NOT NULL default '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL default '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL default '0' COMMENT '数据状态',
  `icon` int(10) unsigned NOT NULL default '0' COMMENT '分类图标',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of kl_category
-- ----------------------------
INSERT INTO `kl_category` VALUES ('1', 'zbgg', '招标公告', '0', '2', '5', '', '', '', '', '', '', '', '2', '3', '0', '0', '1', '0', '0', '1', '', '1379474947', '1398472288', '1', '7');
INSERT INTO `kl_category` VALUES ('62', 'xxhywl', '信息化与网络', '1', '8', '10', '', '', '', '', '', '', '', '2', '2', '0', '1', '1', '1', '0', '', '', '1395788751', '1396493547', '1', '7');
INSERT INTO `kl_category` VALUES ('39', 'fagui', '政策法规', '0', '5', '10', '', '', '', '', '', '', '', '2', '3', '0', '2', '1', '1', '0', '', '', '1393079231', '1398921970', '1', '7');
INSERT INTO `kl_category` VALUES ('40', 'wztz', '网站通知', '0', '3', '10', '', '', '', '', '', '', '', '2', '3', '0', '2', '1', '1', '0', '', '', '1393079272', '1396021799', '1', '7');
INSERT INTO `kl_category` VALUES ('61', 'hgjc', '化工建材', '1', '4', '10', '', '', '', '', '', '', '', '2', '3', '0', '1', '1', '1', '0', '', '', '1395788676', '1396493382', '1', '7');
INSERT INTO `kl_category` VALUES ('63', 'gnyp', '各类油品', '1', '7', '10', '', '', '', '', '', '', '', '2', '3', '0', '1', '1', '1', '0', '', '', '1395788982', '1396493536', '1', '7');
INSERT INTO `kl_category` VALUES ('58', 'jscl', '金属材料', '1', '3', '10', '', '', '', '', '', '', '', '2', '3', '0', '1', '1', '1', '0', '', '', '1395655385', '1396493368', '1', '7');
INSERT INTO `kl_category` VALUES ('48', 'zbgs', '中标公示', '0', '2', '10', '', '', '', '', '', '', '', '2', '3', '0', '2', '1', '1', '0', '', '', '1394392244', '1398959649', '1', '7');
INSERT INTO `kl_category` VALUES ('67', 'zigongsi', '集团子公司', '0', '9', '10', '', '', '', '', '', '', '', '', '1', '0', '1', '1', '1', '0', '', '', '1396328210', '1398946678', '1', '0');
INSERT INTO `kl_category` VALUES ('68', 'zigs1', ' 开封分公司', '67', '4', '10', '', '', '', '', '', '', '', '', '2', '0', '1', '1', '1', '0', '', '', '1396328267', '1396493166', '1', '0');
INSERT INTO `kl_category` VALUES ('64', 'dqpj', '电气配件', '1', '5', '10', '', '', '', '', '', '', '', '2', '3', '0', '1', '1', '1', '0', '', '', '1395789033', '1396493510', '1', '7');
INSERT INTO `kl_category` VALUES ('65', 'xjzp', '橡胶制品', '1', '2', '10', '', '', '', '', '', '', '', '2', '3', '0', '1', '1', '1', '0', '', '', '1395789065', '1396492411', '1', '7');
INSERT INTO `kl_category` VALUES ('69', 'zigs2', '洛阳分公司', '67', '3', '10', '', '', '', '', '', '', '', '', '1', '0', '1', '1', '1', '0', '', '', '1396328285', '1396493155', '1', '0');
INSERT INTO `kl_category` VALUES ('71', 'xfqc', '消防器材', '1', '6', '10', '', '', '', '', '', '', '', '2', '2', '0', '1', '1', '1', '0', '', '', '1396492722', '1396495308', '1', '0');
INSERT INTO `kl_category` VALUES ('72', 'zjsb', '整机设备', '1', '1', '10', '', '', '', '', '', '', '', '2', '2', '0', '1', '1', '1', '0', '', '', '1396492979', '1396495281', '1', '0');
INSERT INTO `kl_category` VALUES ('73', 'jt', '集团公司', '67', '1', '10', '', '', '', '', '', '', '', '13', '2', '0', '1', '1', '1', '1', '', '', '1396493062', '1398921624', '1', '20');
INSERT INTO `kl_category` VALUES ('74', 'ny', '南阳分公司', '67', '2', '10', '', '', '', '', '', '', '', '2', '2', '0', '2', '1', '1', '0', '', '', '1396493084', '1396920168', '1', '0');
INSERT INTO `kl_category` VALUES ('77', 'qt', '其他材料', '1', '9', '10', '', '', '', '', '', '', '', '2', '2', '0', '1', '1', '1', '0', '', '', '1396493576', '1396495326', '1', '0');
INSERT INTO `kl_category` VALUES ('78', 'zz', '郑州分公司', '67', '7', '10', '', '', '', '', '', '', '', '', '', '0', '1', '1', '1', '0', '', '', '1396494425', '1396494425', '1', '0');
INSERT INTO `kl_category` VALUES ('79', 'ay', '安阳分公司', '67', '8', '10', '', '', '', '', '', '', '', '', '2', '0', '1', '1', '1', '0', '', '', '1396494562', '1396494577', '1', '0');

-- ----------------------------
-- Table structure for `kl_channel`
-- ----------------------------
DROP TABLE IF EXISTS `kl_channel`;
CREATE TABLE `kl_channel` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '频道ID',
  `pid` int(10) unsigned NOT NULL default '0' COMMENT '上级频道ID',
  `title` char(30) NOT NULL COMMENT '频道标题',
  `url` char(100) NOT NULL COMMENT '频道连接',
  `sort` int(10) unsigned NOT NULL default '0' COMMENT '导航排序',
  `create_time` int(10) unsigned NOT NULL default '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL default '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL default '0' COMMENT '状态',
  `target` tinyint(2) unsigned NOT NULL default '0' COMMENT '新窗口打开',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kl_channel
-- ----------------------------
INSERT INTO `kl_channel` VALUES ('1', '0', ' 招标首页', '/', '1', '1379475111', '1396425742', '1', '0');
INSERT INTO `kl_channel` VALUES ('2', '0', '招标公告', 'cat/zbgg', '2', '1379475131', '1395651570', '1', '0');
INSERT INTO `kl_channel` VALUES ('5', '0', '政策法规', 'cat/fagui', '4', '1393176526', '1396021884', '1', '0');
INSERT INTO `kl_channel` VALUES ('6', '0', '中标公示', 'cat/zbgs', '3', '1393861730', '1396021869', '1', '0');
INSERT INTO `kl_channel` VALUES ('7', '0', '集团首页', '/', '1', '1396493193', '1396493193', '1', '0');

-- ----------------------------
-- Table structure for `kl_config`
-- ----------------------------
DROP TABLE IF EXISTS `kl_config`;
CREATE TABLE `kl_config` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '配置ID',
  `name` varchar(30) NOT NULL default '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL default '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL default '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL default '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL default '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL default '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL default '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL default '0' COMMENT '状态',
  `value` text NOT NULL COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL default '0' COMMENT '排序',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kl_config
-- ----------------------------
INSERT INTO `kl_config` VALUES ('1', 'WEB_SITE_TITLE', '1', '网站标题', '1', '', '网站标题前台显示标题', '1378898976', '1379235274', '1', '招标平台', '0');
INSERT INTO `kl_config` VALUES ('2', 'WEB_SITE_DESCRIPTION', '2', '网站描述', '1', '', '网站搜索引擎描述', '1378898976', '1379235841', '1', '招标平台', '1');
INSERT INTO `kl_config` VALUES ('3', 'WEB_SITE_KEYWORD', '2', '网站关键字', '1', '', '网站搜索引擎关键字', '1378898976', '1381390100', '1', '招标平台', '8');
INSERT INTO `kl_config` VALUES ('4', 'WEB_SITE_CLOSE', '4', '关闭站点', '1', '0:关闭,1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', '1378898976', '1379235296', '1', '1', '1');
INSERT INTO `kl_config` VALUES ('9', 'CONFIG_TYPE_LIST', '3', '配置类型列表', '4', '', '主要用于数据解析和页面表单的生成', '1378898976', '1379235348', '1', '0:数字\r\n1:字符\r\n2:文本\r\n3:数组\r\n4:枚举\r\n5:密码类型\r\n6:HTML文本', '2');
INSERT INTO `kl_config` VALUES ('10', 'WEB_SITE_ICP', '1', '网站备案号', '1', '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', '1378900335', '1379235859', '1', '', '9');
INSERT INTO `kl_config` VALUES ('20', 'CONFIG_GROUP_LIST', '3', '配置分组', '4', '', '配置分组', '1379228036', '1397857530', '1', '1:基本\r\n3:用户\r\n5:邮件\r\n4:系统\r\n\r\n', '4');
INSERT INTO `kl_config` VALUES ('48', 'USER_ALLOW_REGISTER', '4', '是否允许用户注册', '3', '0:关闭注册\r\n1:允许注册', '是否开放用户注册', '1379504487', '1397857952', '1', '0', '3');
INSERT INTO `kl_config` VALUES ('28', 'DATA_BACKUP_PATH', '1', '数据库备份根路径', '4', '', '路径必须以 / 结尾', '1381482411', '1381482411', '1', './Uploads/DataBak/', '5');
INSERT INTO `kl_config` VALUES ('29', 'DATA_BACKUP_PART_SIZE', '0', '数据库备份卷大小', '4', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '1381482488', '1381729564', '1', '20971520', '7');
INSERT INTO `kl_config` VALUES ('30', 'DATA_BACKUP_COMPRESS', '4', '数据库备份文件是否启用压缩', '4', '0:不压缩\r\n1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '1381713345', '1381729544', '1', '1', '9');
INSERT INTO `kl_config` VALUES ('31', 'DATA_BACKUP_COMPRESS_LEVEL', '4', '数据库备份文件压缩级别', '4', '1:普通\r\n4:一般\r\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '1381713408', '1381713408', '1', '9', '10');
INSERT INTO `kl_config` VALUES ('32', 'DEVELOP_MODE', '4', '开启开发者模式', '4', '0:关闭\r\n1:开启', '是否开启开发者模式', '1383105995', '1383291877', '1', '0', '11');
INSERT INTO `kl_config` VALUES ('33', 'ALLOW_VISIT', '3', '不受限控制器方法', '0', '', '', '1386644047', '1386644741', '1', '0:article/draftbox\r\n1:article/mydocument\r\n2:Category/tree\r\n3:Index/verify\r\n4:file/upload\r\n5:file/download\r\n6:user/updatePassword\r\n7:user/updateNickname\r\n8:user/submitPassword\r\n9:user/submitNickname\r\n10:file/uploadpicture', '0');
INSERT INTO `kl_config` VALUES ('34', 'DENY_VISIT', '3', '超管专限控制器方法', '0', '', '仅超级管理员可访问的控制器方法', '1386644141', '1386644659', '1', '0:Addons/addhook\r\n1:Addons/edithook\r\n2:Addons/delhook\r\n3:Addons/updateHook\r\n4:Admin/getMenus\r\n5:Admin/recordList\r\n6:AuthManager/updateRules\r\n7:AuthManager/tree', '0');
INSERT INTO `kl_config` VALUES ('36', 'ADMIN_ALLOW_IP', '2', '后台允许访问IP', '4', '', '多个用逗号分隔，如果不配置表示不限制IP访问', '1387165454', '1387165553', '1', '', '12');
INSERT INTO `kl_config` VALUES ('37', 'SHOW_PAGE_TRACE', '4', '是否显示页面Trace', '4', '0:关闭\r\n1:开启', '是否显示页面Trace信息', '1387165685', '1387165685', '1', '1', '1');
INSERT INTO `kl_config` VALUES ('38', 'APP_GROUP_LIST', '4', '项目分组设定', '3', '0:Home\r\n1:Admin', '默认分组', '1392954591', '1392954783', '1', '0', '0');
INSERT INTO `kl_config` VALUES ('39', 'URL_CASE_INSENSITIVE', '0', '不区分大小写', '3', '', '不区分大小写', '1392955163', '1392987226', '1', '0', '0');
INSERT INTO `kl_config` VALUES ('40', 'URL_MODEL', '0', 'URL模式', '3', '', 'URL模式', '1392959182', '1392959257', '1', '2', '0');
INSERT INTO `kl_config` VALUES ('41', 'MAIL_TYPE', '4', '邮件类型', '5', '0:SMTP邮件类型', '', '1393438206', '1393438254', '1', '0', '0');
INSERT INTO `kl_config` VALUES ('42', 'MAIL_SMTP_HOST', '1', 'SMTP服务器', '5', '', '', '1393438336', '1393443535', '1', 'smtp.163.com', '0');
INSERT INTO `kl_config` VALUES ('43', 'MAIL_SMTP_PORT', '0', 'SMTP服务器端口', '5', '', '默认25', '1393438384', '1393443522', '1', '25', '0');
INSERT INTO `kl_config` VALUES ('44', 'MAIL_SMTP_USER', '1', 'SMTP服务器用户名', '5', '', '填写您的完整用户名(如xxx@163.com)', '1393438416', '1393444370', '1', 'deariloveyoutoever@163.com', '0');
INSERT INTO `kl_config` VALUES ('45', 'MAIL_SMTP_PASS', '5', 'SMTP服务器密码', '5', '', '填写您的密码', '1393438502', '1393487102', '1', '01227328', '0');
INSERT INTO `kl_config` VALUES ('46', 'MAIL_SMTP_CE', '1', '邮件发送测试', '5', '', '填写测试邮件地址', '1393438568', '1393446669', '1', '735579768@qq.com', '0');
INSERT INTO `kl_config` VALUES ('47', 'MAIL_REG_SUCCESS', '6', '注册成功邮件内容', '5', '', '注册成功邮件内容', '1393488787', '1393488809', '1', '<p>hglkjljlkjlkj</p>', '0');

-- ----------------------------
-- Table structure for `kl_document`
-- ----------------------------
DROP TABLE IF EXISTS `kl_document`;
CREATE TABLE `kl_document` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '文档ID',
  `uid` int(10) unsigned NOT NULL default '0' COMMENT '用户ID',
  `name` char(40) NOT NULL default '' COMMENT '标识',
  `title` char(80) NOT NULL default '' COMMENT '标题',
  `category_id` int(10) unsigned NOT NULL COMMENT '所属分类',
  `description` char(140) NOT NULL default '' COMMENT '描述',
  `root` int(10) unsigned NOT NULL default '0' COMMENT '根节点',
  `pid` int(10) unsigned NOT NULL default '0' COMMENT '所属ID',
  `model_id` tinyint(3) unsigned NOT NULL default '0' COMMENT '内容模型ID',
  `type` tinyint(3) unsigned NOT NULL default '2' COMMENT '内容类型',
  `position` smallint(5) unsigned NOT NULL default '0' COMMENT '推荐位',
  `link_id` int(10) unsigned NOT NULL default '0' COMMENT '外链',
  `cover_id` int(10) unsigned NOT NULL default '0' COMMENT '封面',
  `display` tinyint(3) unsigned NOT NULL default '1' COMMENT '可见性',
  `deadline` int(10) unsigned NOT NULL default '1404432000' COMMENT '截至时间',
  `attach` tinyint(3) unsigned NOT NULL default '0' COMMENT '附件数量',
  `view` int(10) unsigned NOT NULL default '0' COMMENT '浏览量',
  `comment` int(10) unsigned NOT NULL default '0' COMMENT '评论数',
  `extend` int(10) unsigned NOT NULL default '0' COMMENT '扩展统计字段',
  `level` int(10) NOT NULL default '0' COMMENT '优先级',
  `create_time` int(10) unsigned NOT NULL default '1404432000' COMMENT '开标时间',
  `update_time` int(10) unsigned NOT NULL default '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL default '0' COMMENT '数据状态',
  PRIMARY KEY  (`id`),
  KEY `idx_category_status` (`category_id`,`status`),
  KEY `idx_status_type_pid` (`status`,`uid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型基础表';

-- ----------------------------
-- Records of kl_document
-- ----------------------------
INSERT INTO `kl_document` VALUES ('75', '1', '', '在标公示在标公示在标公示34234', '48', '在标公示在标公示在标公示', '0', '0', '2', '2', '7', '0', '0', '1', '1398938700', '0', '0', '0', '0', '0', '1398938700', '1398967068', '1');
INSERT INTO `kl_document` VALUES ('76', '1', '', '在标公示在标公示在标公示', '48', '在标公示在标公示在标公示', '0', '0', '2', '2', '0', '0', '0', '1', '1398938726', '0', '0', '0', '0', '0', '1398938726', '1398942199', '1');

-- ----------------------------
-- Table structure for `kl_document_article`
-- ----------------------------
DROP TABLE IF EXISTS `kl_document_article`;
CREATE TABLE `kl_document_article` (
  `id` int(10) unsigned NOT NULL default '0' COMMENT '文档ID',
  `parse` tinyint(3) unsigned NOT NULL default '0' COMMENT '内容解析类型',
  `content` text NOT NULL COMMENT '文章内容',
  `template` varchar(100) NOT NULL default '' COMMENT '详情页显示模板',
  `bookmark` int(10) unsigned NOT NULL default '0' COMMENT '收藏数',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型文章表';

-- ----------------------------
-- Records of kl_document_article
-- ----------------------------
INSERT INTO `kl_document_article` VALUES ('75', '0', '3534534234523452345', '', '0');
INSERT INTO `kl_document_article` VALUES ('76', '0', '在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示在标公示', '', '0');

-- ----------------------------
-- Table structure for `kl_document_download`
-- ----------------------------
DROP TABLE IF EXISTS `kl_document_download`;
CREATE TABLE `kl_document_download` (
  `id` int(10) unsigned NOT NULL default '0' COMMENT '文档ID',
  `parse` tinyint(3) unsigned NOT NULL default '0' COMMENT '内容解析类型',
  `content` text NOT NULL COMMENT '下载详细描述',
  `template` varchar(100) NOT NULL default '' COMMENT '详情页显示模板',
  `file_id` int(10) unsigned NOT NULL default '0' COMMENT '文件ID',
  `download` int(10) unsigned NOT NULL default '0' COMMENT '下载次数',
  `size` bigint(20) unsigned NOT NULL default '0' COMMENT '文件大小',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型下载表';

-- ----------------------------
-- Records of kl_document_download
-- ----------------------------

-- ----------------------------
-- Table structure for `kl_document_goods`
-- ----------------------------
DROP TABLE IF EXISTS `kl_document_goods`;
CREATE TABLE `kl_document_goods` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '主键',
  `goodspic` int(10) unsigned NOT NULL COMMENT '商品图',
  `goodsdescr` text NOT NULL COMMENT '商品详情',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of kl_document_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `kl_document_test`
-- ----------------------------
DROP TABLE IF EXISTS `kl_document_test`;
CREATE TABLE `kl_document_test` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '主键',
  `testtitle` varchar(255) NOT NULL COMMENT '测试标题',
  `testtitlea` varchar(255) NOT NULL COMMENT '测试标题',
  `testtitlea6` varchar(255) NOT NULL COMMENT '测试标题',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of kl_document_test
-- ----------------------------

-- ----------------------------
-- Table structure for `kl_document_wallpaper`
-- ----------------------------
DROP TABLE IF EXISTS `kl_document_wallpaper`;
CREATE TABLE `kl_document_wallpaper` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '主键',
  `pic` varchar(255) NOT NULL COMMENT '壁纸地址',
  `fenbianlv` char(200) NOT NULL default '0' COMMENT '分辨率',
  `morc` char(10) NOT NULL default '0' COMMENT '手机或电脑壁纸',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of kl_document_wallpaper
-- ----------------------------

-- ----------------------------
-- Table structure for `kl_document_zhaobiao`
-- ----------------------------
DROP TABLE IF EXISTS `kl_document_zhaobiao`;
CREATE TABLE `kl_document_zhaobiao` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '主键',
  `danwei` varchar(255) NOT NULL COMMENT '所属单位',
  `zbcontent` text NOT NULL COMMENT '公告内容',
  `ggfujian` int(10) unsigned NOT NULL COMMENT '公告附件',
  `jxstatus` char(50) NOT NULL default '0' COMMENT '进行状态',
  `islogindown` char(10) NOT NULL default '0' COMMENT '是否要登陆下载',
  `kbtime` int(10) NOT NULL COMMENT '开标时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of kl_document_zhaobiao
-- ----------------------------

-- ----------------------------
-- Table structure for `kl_file`
-- ----------------------------
DROP TABLE IF EXISTS `kl_file`;
CREATE TABLE `kl_file` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '文件ID',
  `name` char(30) NOT NULL default '' COMMENT '原始文件名',
  `savename` char(20) NOT NULL default '' COMMENT '保存名称',
  `savepath` char(30) NOT NULL default '' COMMENT '文件保存路径',
  `ext` char(5) NOT NULL default '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL default '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL default '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL default '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL default '' COMMENT '文件 sha1编码',
  `location` tinyint(3) unsigned NOT NULL default '0' COMMENT '文件保存位置',
  `create_time` int(10) unsigned NOT NULL COMMENT '上传时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uk_md5` (`md5`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文件表';

-- ----------------------------
-- Records of kl_file
-- ----------------------------

-- ----------------------------
-- Table structure for `kl_hooks`
-- ----------------------------
DROP TABLE IF EXISTS `kl_hooks`;
CREATE TABLE `kl_hooks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` char(12) NOT NULL,
  `mark` char(255) default NULL,
  `pluginid` varchar(255) default NULL,
  `descr` varchar(255) default NULL,
  `type` char(50) default 'other',
  `status` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kl_hooks
-- ----------------------------
INSERT INTO `kl_hooks` VALUES ('1', '测试钩子', 'Test', '15,19', '测试钩子1', null, '0');
INSERT INTO `kl_hooks` VALUES ('4', '系统环境信息模板', 'AdminInfo', '4,7', '后台首页扩展钩子', 'system', '1');
INSERT INTO `kl_hooks` VALUES ('3', 'asdf', 'asdf', '15,14', 'asdf', null, '0');
INSERT INTO `kl_hooks` VALUES ('6', 'html编辑器', 'Editor', '6', 'html在线编辑器', 'system', '1');

-- ----------------------------
-- Table structure for `kl_member`
-- ----------------------------
DROP TABLE IF EXISTS `kl_member`;
CREATE TABLE `kl_member` (
  `id` int(11) NOT NULL auto_increment,
  `groupid` int(11) default NULL,
  `username` char(32) default NULL,
  `password` char(32) default NULL,
  `email` char(32) default NULL,
  `mobile` char(32) default NULL,
  `reg_time` int(11) default NULL,
  `reg_ip` char(32) default NULL,
  `login` int(11) unsigned NOT NULL,
  `update_time` int(11) default NULL,
  `last_login_time` int(11) default NULL,
  `last_login_ip` char(12) default NULL,
  `status` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kl_member
-- ----------------------------
INSERT INTO `kl_member` VALUES ('1', '22', 'admin', 'ce7a419fe01a1e014c1e564fdd457cd0', 'ce7a419fe01a1e014c1e564fdd457cd0', null, '1398352591', '2130706433', '0', '1398352591', '1398906955', '2130706433', '1');
INSERT INTO `kl_member` VALUES ('2', '22', 'testtest', '3649a77008d6d2ee8c14e848a31d5d24', '7355798@qq.com', null, '1398351645', '2130706433', '0', '1398351645', null, null, '1');
INSERT INTO `kl_member` VALUES ('9', '22', '123456', 'c9f43c3d0abf82620fb06eae6d02221b', '123456@qq.com', null, '1398357299', '2130706433', '0', '1398357299', null, null, '1');

-- ----------------------------
-- Table structure for `kl_member_group`
-- ----------------------------
DROP TABLE IF EXISTS `kl_member_group`;
CREATE TABLE `kl_member_group` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '用户ID',
  `title` char(32) NOT NULL,
  `auth` text NOT NULL COMMENT '用户名',
  `status` tinyint(4) default '1' COMMENT '用户状态',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of kl_member_group
-- ----------------------------
INSERT INTO `kl_member_group` VALUES ('22', '管理员组', '', '1');
INSERT INTO `kl_member_group` VALUES ('21', '会员组', '', '1');
INSERT INTO `kl_member_group` VALUES ('23', '编辑员组', '', '1');

-- ----------------------------
-- Table structure for `kl_menu`
-- ----------------------------
DROP TABLE IF EXISTS `kl_menu`;
CREATE TABLE `kl_menu` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '文档ID',
  `title` varchar(50) NOT NULL default '' COMMENT '标题',
  `pid` int(10) unsigned NOT NULL default '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL default '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL default '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否隐藏',
  `tip` varchar(255) NOT NULL default '' COMMENT '提示',
  `group` varchar(50) NOT NULL default '' COMMENT '分组',
  `type` char(50) NOT NULL default 'system',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kl_menu
-- ----------------------------
INSERT INTO `kl_menu` VALUES ('1', '首页', '0', '0', 'Index/index', '0', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('68', '系统', '0', '10', 'Config/group', '0', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('122', '菜单列表', '68', '20', 'Menu/index', '0', '', '后台菜单', 'system', '1');
INSERT INTO `kl_menu` VALUES ('123', '添加导航', '68', '0', 'Channel/add', '0', '', '导航管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('124', '插件', '0', '8', 'Addon/index', '0', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('125', '插件列表', '124', '0', 'Addon/index', '0', '', '插件管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('126', '钩子列表', '124', '0', 'Hook/index', '0', '', '插件管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('127', '添加钩子', '124', '0', 'Hook/add', '0', '', '插件管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('128', '编辑钩子', '124', '0', 'Hook/manage', '1', '', '插件管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('129', '用户', '0', '3', 'Member/index', '0', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('130', '用户列表', '129', '0', 'Member/index', '0', '', '用户管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('131', '用户组列表', '129', '10', 'MemberGroup/index', '0', '', '用户组管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('132', '用户组编辑', '129', '10', 'MemberGroup/edit', '1', '', '用户组管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('133', '添加用户', '129', '0', 'Member/add', '0', '', '用户管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('134', '修改密码', '129', '0', 'Member/updatepwd', '1', '', '用户管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('135', '添加用户组', '129', '10', 'MemberGroup/add', '0', '', '用户组管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('136', '用户回收站', '129', '0', 'Member/recycling', '0', '', '用户管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('137', '添加菜单', '68', '20', 'Menu/add', '0', '', '后台菜单', 'system', '1');
INSERT INTO `kl_menu` VALUES ('140', '导航列表', '68', '0', 'Channel/index', '0', '', '导航管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('141', '编辑菜单', '68', '20', 'Menu/edit', '1', '', '后台菜单', 'system', '1');
INSERT INTO `kl_menu` VALUES ('147', '分类列表', '68', '10', 'category/index', '0', '', '分类管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('148', '添加分类', '68', '10', 'Category/add', '0', '', '分类管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('146', '导航编辑', '68', '0', 'Channel/edit', '1', '', '导航管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('149', '编辑分类', '68', '10', 'Category/edit', '1', '', '分类管理', 'system', '1');
INSERT INTO `kl_menu` VALUES ('155', '测试插件', '124', '10', 'Addon/Plugin?name=Test&amp;method=set', '0', '', '已安装插件', 'Test', '1');
INSERT INTO `kl_menu` VALUES ('156', '配置管理', '68', '40', 'Config/index', '0', '', '系统设置', 'system', '1');
INSERT INTO `kl_menu` VALUES ('157', '网站设置', '68', '40', 'Config/group', '0', '', '系统设置', 'system', '1');
INSERT INTO `kl_menu` VALUES ('158', '编辑配置', '68', '9', 'Config/edit', '1', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('159', '添加配置', '68', '9', 'Config/add', '1', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('160', '配置排序', '68', '9', 'Config/sort', '1', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('161', '备份数据库', '68', '99', 'Database/index?type=export', '0', '', '数据备份', 'system', '1');
INSERT INTO `kl_menu` VALUES ('162', '还原数据库', '68', '99', 'Database/index?type=import', '0', '', '数据备份', 'system', '1');
INSERT INTO `kl_menu` VALUES ('165', '内容', '0', '2', 'Article/mydocument', '0', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('164', 'Editor插件', '124', '10', 'Addon/Plugin?name=Editor&amp;method=set', '0', '', '已安装插件', 'Editor', '1');
INSERT INTO `kl_menu` VALUES ('168', '内容模型', '68', '30', 'Model/index', '0', '', '内容模型', 'system', '1');
INSERT INTO `kl_menu` VALUES ('169', '添加模型', '68', '30', 'Model/add', '0', '', '内容模型', 'system', '1');
INSERT INTO `kl_menu` VALUES ('170', '编辑模型', '68', '40', 'Model/edit', '1', '', '系统设置', 'system', '1');
INSERT INTO `kl_menu` VALUES ('171', '添加字段', '68', '40', 'Attribute/add', '1', '', '系统设置', 'system', '1');
INSERT INTO `kl_menu` VALUES ('172', '编辑字段', '68', '40', 'Attribute/edit', '1', '', '系统设置', 'system', '1');
INSERT INTO `kl_menu` VALUES ('173', '字段列表', '68', '40', 'Attribute/index', '1', '', '系统设置', 'system', '1');
INSERT INTO `kl_menu` VALUES ('174', '添加文章', '165', '8', 'Article/add', '1', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('175', '编辑文章', '165', '8', 'Article/edit', '1', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('176', '所有文档', '165', '8', 'Article/mydocument.', '1', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('177', '草稿箱', '165', '0', 'Article/draftbox', '1', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('178', '禁用文档', '165', '0', 'Article/examine', '1', '', '', 'system', '1');
INSERT INTO `kl_menu` VALUES ('179', '文档回收站', '165', '8', 'Article/recycle', '1', '', '', 'system', '1');

-- ----------------------------
-- Table structure for `kl_model`
-- ----------------------------
DROP TABLE IF EXISTS `kl_model`;
CREATE TABLE `kl_model` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '模型ID',
  `name` char(30) NOT NULL default '' COMMENT '模型标识',
  `title` char(30) NOT NULL default '' COMMENT '模型名称',
  `extend` int(10) unsigned NOT NULL default '0' COMMENT '继承的模型',
  `relation` varchar(30) NOT NULL default '' COMMENT '继承与被继承模型的关联字段',
  `need_pk` tinyint(1) unsigned NOT NULL default '1' COMMENT '新建表时是否需要主键字段',
  `field_sort` text NOT NULL COMMENT '表单字段排序',
  `field_group` varchar(255) NOT NULL default '1:基础' COMMENT '字段分组',
  `attribute_list` text NOT NULL COMMENT '属性列表（表的字段）',
  `template_list` varchar(100) NOT NULL default '' COMMENT '列表模板',
  `template_add` varchar(100) NOT NULL default '' COMMENT '新增模板',
  `template_edit` varchar(100) NOT NULL default '' COMMENT '编辑模板',
  `list_grid` text NOT NULL COMMENT '列表定义',
  `list_row` smallint(2) unsigned NOT NULL default '10' COMMENT '列表数据长度',
  `search_key` varchar(50) NOT NULL default '' COMMENT '默认搜索字段',
  `search_list` varchar(255) NOT NULL default '' COMMENT '高级搜索的字段',
  `create_time` int(10) unsigned NOT NULL default '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL default '0' COMMENT '更新时间',
  `status` tinyint(3) unsigned NOT NULL default '0' COMMENT '状态',
  `engine_type` varchar(25) NOT NULL default 'MyISAM' COMMENT '数据库引擎',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型表';

-- ----------------------------
-- Records of kl_model
-- ----------------------------
INSERT INTO `kl_model` VALUES ('1', 'document', '基础文档', '0', '', '1', '{\"1\":[\"2\",\"3\",\"5\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"16\",\"17\",\"19\",\"20\"]}', '1:基础', '', '', '', '', 'id:编号\r\ntitle:标题:article/index?cate_id=[category_id]&pid=[id]\r\ntype|get_document_type:类型\r\nlevel:优先级\r\nupdate_time|time_format:最后更新\r\nstatus_text:状态\r\nview:浏览\r\nid:操作:[EDIT]&cate_id=[category_id]|编辑,article/setstatus?status=-1&id=[id]|删除', '0', '', '', '1383891233', '1397061423', '1', 'MyISAM');
INSERT INTO `kl_model` VALUES ('2', 'article', '文章', '1', '', '1', '{\"1\":[\"3\",\"24\",\"5\"],\"2\":[\"2\",\"9\",\"13\",\"19\",\"10\",\"12\",\"16\",\"17\",\"26\",\"20\",\"14\",\"11\",\"25\"]}', '1:基础,2:扩展', '', '', '', '', 'id:编号\r\ntitle:标题:[EDIT]&cate_id=[category_id]\r\ncategory_id|get_cate:所属分类\r\nstatus|totext:状态\r\nview:浏览\r\nupdate_time|time_format:最后更新\r\nid:操作:[EDIT]&cate_id=[category_id]|编辑,article/setstatus?status=-1&id=[id]|删除', '0', '', '', '1383891243', '1397061436', '1', 'MyISAM');
INSERT INTO `kl_model` VALUES ('3', 'download', '下载', '1', '', '1', '{\"1\":[\"3\",\"28\",\"30\",\"32\",\"2\",\"5\",\"31\"],\"2\":[\"13\",\"10\",\"9\",\"12\",\"16\",\"17\",\"19\",\"11\",\"20\",\"14\",\"29\"]}', '1:基础,2:扩展', '', '', '', '', 'id:编号\r\ntitle:标题:[EDIT]&cate_id=[category_id]\r\ncategory_id|get_cate:所属分类\r\nupdate_time|time_format:最后更新\r\nstatus|totext:状态\r\nview:浏览\r\ndownload:下载次数\r\nid:操作:[EDIT]&cate_id=[category_id]|编辑,article/setstatus?status=-1&id=[id]|删除', '0', '', '', '1383891252', '1397061447', '1', 'MyISAM');
INSERT INTO `kl_model` VALUES ('13', 'test', 'test', '1', '', '1', '{\"1\":[\"3\",\"5\",\"10\",\"12\",\"14\",\"16\",\"17\",\"20\"],\"2\":[\"43\",\"44\",\"42\"]}', '1:基础;2:扩展', '', '', '', '', 'id:编号\r\ntitle:标题:article/index?cate_id=[category_id]&amp;pid=[id]\r\ntype|get_document_type:类型\r\nlevel:优先级\r\nupdate_time|time_format:最后更新\r\nstatus_text:状态\r\nview:浏览\r\nid:操作:[EDIT]&amp;cate_id=[category_id]|编辑,article/setstatus?status=-1&amp;id=[id]|删除', '10', '', '', '1398880106', '1398881941', '1', 'MyISAM');

-- ----------------------------
-- Table structure for `kl_picture`
-- ----------------------------
DROP TABLE IF EXISTS `kl_picture`;
CREATE TABLE `kl_picture` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '主键id自增',
  `path` varchar(255) NOT NULL default '' COMMENT '路径',
  `url` varchar(255) NOT NULL default '' COMMENT '图片链接',
  `md5` char(32) NOT NULL default '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL default '' COMMENT '文件 sha1编码',
  `status` tinyint(2) NOT NULL default '0' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL default '0' COMMENT '创建时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kl_picture
-- ----------------------------
INSERT INTO `kl_picture` VALUES ('18', '/Uploads/Picture/2014-04-25/535a0cb139127.png', '', '40cf3e1e9f8586426d4f0b728c82f55a', 'ebd4d212c6015eb1aa8ed9ded8c19c5d9abae54e', '1', '1398410416');
INSERT INTO `kl_picture` VALUES ('19', '/Uploads/Picture/2014-04-25/535a0ee1eef98.png', '', '74d587b2c95cd734c1aff05a3728e7d1', '1389a6474480beab2338c997968e1a0358b332f2', '1', '1398410977');
INSERT INTO `kl_picture` VALUES ('20', '/Uploads/Picture/2014-05-01/5361cfb759a7f.png', '', 'a7d3b8cc440aa914ddd034a4e965598e', 'd72bce6ea39a5ba1c3b53823bf13cce0a20d834c', '1', '1398919095');
