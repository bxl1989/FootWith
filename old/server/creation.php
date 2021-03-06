﻿
<?php
header('content-type;text/html;charset=utf-8');
//连接本地服务器
$link = mysql_connect('localhost','root','');
if(!$link)
	die('Can\'t connect mysql!').mysql_errno().mysql_error();
	
//修正编码
mysql_query('SET NAMES UTF8');	
//新建数据库 banlv
mysql_query('CREATE DATABASE IF NOT EXISTS banlv DEFAULT CHARACTER SET utf8',$link) 
	or die("Failed to create banlv").mysql_errno().mysql_error();
//选择数据库
mysql_select_db('banlv',$link) 
	or die("Cant't choose a database").mysql_errno().mysql_error();	
	
//建立user trip trip_interested trip_jointed 

//user
mysql_query('SET NAMES UTF8');	
mysql_query("CREATE TABLE IF NOT EXISTS user(ID varchar(20),
			 PASSWORD varchar(20),SEX ENUM('女','男') ,PRIMARY KEY(ID))DEFAULT CHARSET=utf8",$link)
	or die("Failed to create user").mysql_errno().mysql_error();
	
//trip
mysql_query('SET NAMES UTF8');
mysql_query("CREATE TABLE IF NOT EXISTS trip(Status ENUM('false','true') DEFAULT 'false',
			 Trip_Id INT  AUTO_INCREMENT,ID varchar(20) ,Time_Start INT,Time_End INT,
			 Plan varchar(20) ,Message varchar(20) ,Record_Time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			 PRIMARY KEY(Trip_Id),FOREIGN KEY(ID) REFERENCES user(ID) ON UPDATE CASCADE)DEFAULT CHARSET=utf8",$link)
	or die("Failed to create trip").mysql_errno().mysql_error();

	
//trip_interested 
mysql_query('SET NAMES UTF8');	
mysql_query('CREATE TABLE IF NOT EXISTS trip_interested(Trip_Id INT,ID varchar(20) ,
			 PRIMARY KEY(Trip_Id,ID),FOREIGN KEY(Trip_Id) REFERENCES trip(Trip_Id) 
			 ON UPDATE CASCADE ,FOREIGN KEY(ID) REFERENCES user(ID) ON UPDATE CASCADE)DEFAULT CHARSET=utf8',
			 $link)
	or die("Failed to create trip_interested").mysql_errno().mysql_error();
	
	
//trip_joint
mysql_query('SET NAMES UTF8');	
mysql_query('CREATE TABLE IF NOT EXISTS trip_joint(Trip_Id INT,ID varchar(20),
			 PRIMARY KEY(Trip_Id,ID),FOREIGN KEY(Trip_Id) REFERENCES trip(Trip_Id) 
			 ON UPDATE CASCADE ,FOREIGN KEY(ID) REFERENCES user(ID) ON UPDATE CASCADE)DEFAULT CHARSET=utf8',
			 $link)
	or die("Failed to create trip_joint").mysql_errno().mysql_error();

//消息类

//对话列表conversation
mysql_query('SET NAMES UTF8');	
mysql_query("CREATE TABLE IF NOT EXISTS conversation(
			 Con_Id INT AUTO_INCREMENT PRIMARY KEY,Sender varchar(20) NOT NULL ,
			 Reciever varchar(20) DEFAULT NULL ,Message varchar(100) NOT NULL,
			 Next_Pointer INT DEFAULT 0,
			 Record_Time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			 FOREIGN KEY(Sender) REFERENCES user(ID) ON UPDATE CASCADE,
			 FOREIGN KEY(Reciever) REFERENCES user(ID) ON UPDATE CASCADE
			 )DEFAULT CHARSET=utf8",$link)
	or die("Failed to create conversation").mysql_errno().mysql_error();

//客户ID列表 customer
mysql_query('SET NAMES UTF8');	
mysql_query("CREATE TABLE IF NOT EXISTS customer(
			 Customer_Id INT AUTO_INCREMENT PRIMARY KEY,Sender varchar(20) ,Reciever varchar(20) ,
			 First_Pointer INT DEFAULT 0,Last_Pointer INT DEFAULT 0,Record_Time TIMESTAMP 
			 NOT NULL DEFAULT CURRENT_TIMESTAMP,
			 FOREIGN KEY(Sender) REFERENCES user(ID) ON UPDATE CASCADE,
			 FOREIGN KEY(Reciever) REFERENCES user(ID) ON UPDATE CASCADE
			 )DEFAULT CHARSET=utf8",$link)
	or die("Failed to create customer").mysql_errno().mysql_error();
/*	
//在客户ID列表建立Sender 和  Reciever 的索引
//修正编码
mysql_query('SET NAMES UTF8');	
mysql_query("ALTER TABLE customer ADD INDEX cus_S_R(Sender,Reciever)",$link)
	or die("Failed to create customer's INDEX").mysql_errno().mysql_error();	

//在对话列表建立Sender 和  Reciever 的索引
//修正编码
mysql_query('SET NAMES UTF8');	
mysql_query("ALTER TABLE conversation ADD INDEX con_S_R(Sender,Reciever)",$link)
	or die("Failed to create conversation's Index").mysql_errno().mysql_error();	
	
*/	
	
//系统信息表 sys_info
mysql_query('SET NAMES UTF8');	
mysql_query("CREATE TABLE IF NOT EXISTS Sys_Info(
			 Sys_Info_Id INT AUTO_INCREMENT PRIMARY KEY,Message varchar(100) NOT NULL ,
			 Type INT,Users_Id varchar(100),Trip_Id INT , First_Pointer INT DEFAULT 0,
			 Last_Pointer INT DEFAULT 0,Record_Time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			 FOREIGN KEY(Trip_Id) REFERENCES trip(Trip_Id)
			 )DEFAULT CHARSET=utf8",$link)
	or die("Failed to create Sys_Info").mysql_errno().mysql_error();	
	
//个人消息表 communication
mysql_query('SET NAMES UTF8');	
mysql_query("CREATE TABLE IF NOT EXISTS communication(
			 Com_Id INT AUTO_INCREMENT PRIMARY KEY,Message varchar(100) ,
			 Type INT,ID varchar(20) NOT NULL,Trip_Id INT ,Record_Time TIMESTAMP NOT NULL 
			 DEFAULT CURRENT_TIMESTAMP,	FOREIGN KEY(ID) REFERENCES user(ID) ON UPDATE CASCADE,
			 FOREIGN KEY(Trip_Id) REFERENCES trip(Trip_Id)			 
			 )DEFAULT CHARSET=utf8",$link)
	or die("Failed to create communication").mysql_errno().mysql_error();		
	
	
?>