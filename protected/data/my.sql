drop table siteadmins;
drop table sitemessages;
create table siteadmins(
	id	 int primary key auto_increment,
	username varchar(40) NOT NULL,
       	password varchar(60) NOT NULL,
       	email varchar(40)    NOT NULL,
	UNIQUE(username)
);

create table sitemessages(
	id int primary key auto_increment,
       	name varchar(40) collate utf8_general_ci NOT NULL,
       	email varchar(40) collate utf8_general_ci NOT NULL,
       	subject varchar(60) collate utf8_general_ci NOT NULL,
       	message varchar(900) collate utf8_general_ci NOT NULL,
       	postedtime TIMESTAMP DEFAULT NOW(),
       	unread BOOL DEFAULT TRUE
);

drop table livechat_guests_left;
create table livechat_guests_left(
	cname	varchar(30) NOT NULL UNIQUE
);

drop table livechat_guests;
create table livechat_guests(
	cname	varchar(30) NOT NULL UNIQUE
);

drop table livechat_taken;
create table livechat_taken(
	cname	varchar(30) collate utf8_general_ci NOT NULL,
	aname	varchar(30) collate utf8_general_ci NOT NULL
);

drop table livechat_clientinbox;
create table livechat_clientinbox(
	id	int primary key auto_increment,
	cname	varchar(30) collate utf8_general_ci NOT NULL,
	aname	varchar(30) collate utf8_general_ci NOT NULL,
	msg	varchar(300) collate utf8_general_ci NOT NULL
);

drop table livechat_admininbox;
create table livechat_admininbox(
	id	int primary key auto_increment,
	aname	varchar(30) collate utf8_general_ci NOT NULL,
	cname	varchar(30) collate utf8_general_ci NOT NULL,
	msg	varchar(300) collate utf8_general_ci NOT NULL
);
