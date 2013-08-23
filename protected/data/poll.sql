drop table sitepoll_polls;
drop table sitepoll_options;
drop table sitepoll_votes;

create table sitepoll_polls (
	id 		int primary key auto_increment,
	subject 	varchar(60) not null,
	unique(subject)
);

create table sitepoll_options (
	id 		int primary key auto_increment,
	poll_id 	int not null,
	title 		varchar(60) not null,
	unique(poll_id,title)
);

create table sitepoll_votes (
	poll_id 	int not null,
	option_id 	int not null
);

insert into sitepoll_polls(subject) values('sitepoll1.subject');

insert into sitepoll_options(poll_id, title) values(1, 'sitepoll1.option1');
insert into sitepoll_options(poll_id, title) values(1, 'sitepoll1.option2');
insert into sitepoll_options(poll_id, title) values(1, 'sitepoll1.option3');
