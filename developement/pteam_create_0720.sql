/*
SQLyog Ultimate v9.62 
MySQL - 5.0.90-community-nt : Database - pteam
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pteam` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `pteam`;

/*Table structure for table `pt_account` */

DROP TABLE IF EXISTS `pt_account`;

CREATE TABLE `pt_account` (
  `accountId` int(6) NOT NULL auto_increment COMMENT '主键',
  `username` varchar(255) collate utf8_unicode_ci default NULL COMMENT '用户名',
  `password` varchar(255) collate utf8_unicode_ci default NULL COMMENT '密码',
  `phone` varchar(32) collate utf8_unicode_ci default NULL COMMENT '手机号',
  `email` varchar(255) collate utf8_unicode_ci default NULL COMMENT '邮箱',
  `realname` varchar(32) collate utf8_unicode_ci default NULL COMMENT '真实姓名',
  PRIMARY KEY  (`accountId`),
  UNIQUE KEY `UserName_Qnique` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户表';

/*Data for the table `pt_account` */

/*Table structure for table `pt_comment` */

DROP TABLE IF EXISTS `pt_comment`;

CREATE TABLE `pt_comment` (
  `commentId` int(6) NOT NULL auto_increment COMMENT '主键',
  `accountId` int(6) default NULL COMMENT '评论者ID',
  `trendId` int(1) default NULL COMMENT '动态ID',
  PRIMARY KEY  (`commentId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='评论表';

/*Data for the table `pt_comment` */

/*Table structure for table `pt_group` */

DROP TABLE IF EXISTS `pt_group`;

CREATE TABLE `pt_group` (
  `groupId` int(6) NOT NULL auto_increment COMMENT '主键',
  `projectId` int(6) default NULL COMMENT '所属项目ID',
  `name` varchar(32) collate utf8_unicode_ci NOT NULL COMMENT '分组名称',
  `desc` text collate utf8_unicode_ci COMMENT '分组描述',
  `leaderId` int(6) default NULL COMMENT '管理组ID',
  PRIMARY KEY  (`groupId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='分组表';

/*Data for the table `pt_group` */

/*Table structure for table `pt_groupaccount` */

DROP TABLE IF EXISTS `pt_groupaccount`;

CREATE TABLE `pt_groupaccount` (
  `groupAccountId` int(6) NOT NULL auto_increment COMMENT '主键',
  `accountId` int(6) default NULL COMMENT '关联用户ID',
  `groupId` int(6) default NULL COMMENT '分组ID',
  PRIMARY KEY  (`groupAccountId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='分组用户关联表';

/*Data for the table `pt_groupaccount` */

/*Table structure for table `pt_leader` */

DROP TABLE IF EXISTS `pt_leader`;

CREATE TABLE `pt_leader` (
  `leaderId` int(6) NOT NULL auto_increment COMMENT '主键',
  `mainAccountId` int(6) default NULL COMMENT '主要负责人ID',
  `managerList` text collate utf8_unicode_ci COMMENT '管理员ID列表，用逗号分隔',
  PRIMARY KEY  (`leaderId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理组表';

/*Data for the table `pt_leader` */

/*Table structure for table `pt_memo` */

DROP TABLE IF EXISTS `pt_memo`;

CREATE TABLE `pt_memo` (
  `memoId` int(6) NOT NULL auto_increment COMMENT '主键',
  `accountId` int(6) default NULL COMMENT '所属用户ID',
  `content` text collate utf8_unicode_ci COMMENT '备忘录内容',
  `pubTime` datetime default NULL COMMENT '备忘录创建时间',
  `remindTime` datetime default NULL COMMENT '备忘录提醒时间',
  PRIMARY KEY  (`memoId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='备忘录表';

/*Data for the table `pt_memo` */

/*Table structure for table `pt_message` */

DROP TABLE IF EXISTS `pt_message`;

CREATE TABLE `pt_message` (
  `messageId` int(6) NOT NULL auto_increment COMMENT '主键',
  `fromAccountId` int(6) default NULL COMMENT '发送者ID',
  `toAccountId` int(6) default NULL COMMENT '接受者ID',
  `content` text collate utf8_unicode_ci COMMENT '消息内容',
  `pubTime` datetime default NULL COMMENT '消息发布时间',
  `readMark` int(1) default NULL COMMENT '已读标记, 1代表未读',
  PRIMARY KEY  (`messageId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='消息表';

/*Data for the table `pt_message` */

/*Table structure for table `pt_notice` */

DROP TABLE IF EXISTS `pt_notice`;

CREATE TABLE `pt_notice` (
  `noticeId` int(6) NOT NULL auto_increment COMMENT '主键',
  `type` int(1) default NULL COMMENT 'notice类型，1代表全局，2代表项目，3代表分组',
  `sourceId` int(6) default NULL COMMENT '对应目标ID，全局时为0',
  `title` varchar(255) collate utf8_unicode_ci default NULL COMMENT '公告标题',
  `content` text collate utf8_unicode_ci COMMENT '公告内容',
  `pubtime` datetime default NULL COMMENT '公告发布时间',
  PRIMARY KEY  (`noticeId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='公告表';

/*Data for the table `pt_notice` */

/*Table structure for table `pt_project` */

DROP TABLE IF EXISTS `pt_project`;

CREATE TABLE `pt_project` (
  `projectId` int(6) NOT NULL auto_increment COMMENT '主键',
  `name` varchar(255) collate utf8_unicode_ci default NULL COMMENT '项目名称',
  `desc` text collate utf8_unicode_ci COMMENT '项目描述',
  `leaderId` int(6) default NULL COMMENT '管理组ID',
  PRIMARY KEY  (`projectId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='项目表';

/*Data for the table `pt_project` */

/*Table structure for table `pt_share` */

DROP TABLE IF EXISTS `pt_share`;

CREATE TABLE `pt_share` (
  `shareId` int(6) NOT NULL auto_increment COMMENT '主键',
  `accountId` int(6) default NULL COMMENT '分享者ID',
  `comment` text collate utf8_unicode_ci COMMENT '分享感言',
  `scope` int(1) default NULL COMMENT '分享范围，0代表整个pteam，1代表某个项目，2代表某个任务，3代表某个用户组',
  `scopeTargetId` int(6) default NULL COMMENT '分享范围目标ID',
  `shareJSON` text collate utf8_unicode_ci COMMENT '分享内容JSON对象',
  `shareTime` datetime default NULL COMMENT '分享时间',
  PRIMARY KEY  (`shareId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='分享表';

/*Data for the table `pt_share` */

/*Table structure for table `pt_tag` */

DROP TABLE IF EXISTS `pt_tag`;

CREATE TABLE `pt_tag` (
  `tagId` int(6) NOT NULL auto_increment COMMENT '主键',
  `value` varchar(32) collate utf8_unicode_ci default NULL COMMENT 'tag名称',
  PRIMARY KEY  (`tagId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='标签表';

/*Data for the table `pt_tag` */

/*Table structure for table `pt_tagtotask` */

DROP TABLE IF EXISTS `pt_tagtotask`;

CREATE TABLE `pt_tagtotask` (
  `tttid` int(6) NOT NULL auto_increment COMMENT '主键',
  `tagId` int(6) default NULL COMMENT '标签ID',
  `taskId` int(6) default NULL COMMENT '任务ID',
  PRIMARY KEY  (`tttid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `pt_tagtotask` */

/*Table structure for table `pt_task` */

DROP TABLE IF EXISTS `pt_task`;

CREATE TABLE `pt_task` (
  `taskId` int(6) NOT NULL auto_increment COMMENT '主键',
  `projectId` int(6) default NULL COMMENT '任务所属项目',
  `name` varchar(255) collate utf8_unicode_ci default NULL COMMENT '任务名称',
  `desc` text collate utf8_unicode_ci COMMENT '任务描述',
  `accountId` int(6) default NULL COMMENT '任务负责人ID',
  `createId` int(6) default NULL COMMENT '任务创建者ID',
  `createTime` datetime default NULL COMMENT '任务创建时间',
  `statusId` int(6) default NULL COMMENT '任务状态ID',
  `parentTaskId` int(6) default NULL COMMENT '父任务ID，为父任务为0',
  `completeTime` datetime default NULL COMMENT '任务完成时间',
  PRIMARY KEY  (`taskId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='任务表';

/*Data for the table `pt_task` */

/*Table structure for table `pt_taskprocess` */

DROP TABLE IF EXISTS `pt_taskprocess`;

CREATE TABLE `pt_taskprocess` (
  `taskProcessId` int(6) NOT NULL auto_increment COMMENT '主键',
  `taskId` int(6) default NULL COMMENT '所属任务ID',
  `fromStatusId` int(6) default NULL COMMENT '处理前状态ID',
  `toStatusId` int(6) default NULL COMMENT '处理后状态ID',
  `remark` text collate utf8_unicode_ci COMMENT '备注',
  `processTime` datetime default NULL COMMENT '处理发生时间',
  `accountId` int(6) default NULL COMMENT '处理者ID',
  `isRead` int(1) default NULL COMMENT '已读状态，1代表未读，2代表已读',
  PRIMARY KEY  (`taskProcessId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='任务处理记录表';

/*Data for the table `pt_taskprocess` */

/*Table structure for table `pt_taskstatus` */

DROP TABLE IF EXISTS `pt_taskstatus`;

CREATE TABLE `pt_taskstatus` (
  `taskStatusId` int(6) NOT NULL auto_increment COMMENT '主键',
  `name` varchar(255) collate utf8_unicode_ci default NULL COMMENT '状态名称',
  `desc` text collate utf8_unicode_ci COMMENT '状态描述',
  PRIMARY KEY  (`taskStatusId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='任务状态表';

/*Data for the table `pt_taskstatus` */

/*Table structure for table `pt_trend` */

DROP TABLE IF EXISTS `pt_trend`;

CREATE TABLE `pt_trend` (
  `trendId` int(6) NOT NULL auto_increment COMMENT '主键',
  `produceTime` datetime default NULL COMMENT '发生时间',
  `accountId` int(6) default NULL COMMENT '动态当事人ID',
  `scope` int(1) default NULL COMMENT '动态范围，0代表整个pteam，1代表某个项目，2代表某个任务，3代表某个用户组',
  `scopeTargetId` int(6) default NULL COMMENT '动态范围目标ID',
  `trendJSON` text collate utf8_unicode_ci COMMENT '动态内容JSON对象',
  PRIMARY KEY  (`trendId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='动态表';

/*Data for the table `pt_trend` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
