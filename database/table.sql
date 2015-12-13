drop table if exists answer;
drop table if exists takesteaches;
drop table if exists question;
drop table if exists feedback;
drop table if exists lecture;
drop table if exists course;
drop table if exists user;

create table user (
	id int(10) not null primary key,
	name varchar(10) not null,
	password varchar(60) not null,
	level int(1) not null,
	`point` int(5) default 0
	);

create table course (
	course_id	varchar(4)	primary key,
	title 	varchar(30) not null
	);

create table takesteaches (
	id	int(10),
	course_id	varchar(4),
	foreign key (id) references user(id) on delete cascade,
	foreign key (course_id) references course(course_id) on delete cascade,
	primary key (id, course_id)
	);

create table lecture (
	course_id	varchar(4),
	lecture_id	int(4) not null,
	foreign key (course_id) references course(course_id) on delete cascade,
	primary key (course_id, lecture_id)
	);

create table feedback (
	feedback_no int(4) not null auto_increment,
	written_id int(10),
	course_id varchar(4),
	lecture_id int(4),
	content_text text,
	written_date date not null,
	confirm_flag smallint not null default 0,
	div_no smallint not null,
	foreign key (written_id) references user (id) on delete cascade,
	foreign key (course_id, lecture_id) references lecture (course_id, lecture_id) on delete cascade,
	primary key (feedback_no, course_id, lecture_id)
	);

create table question (
	question_id int(4) not null auto_increment,
	course_id varchar(4) not null,
	lecture_id int(4) not null,
	asked_id int(10) not null,
	written_date date not null,
	content_text text,
	pos_x int(5),
	pos_y int(5),
	foreign key (asked_id) references user(id) on delete cascade,
	foreign key (course_id, lecture_id) references lecture (course_id, lecture_id) on delete cascade,
	primary key (question_id, course_id, lecture_id)
	);

create table answer (
	answer_id int(4) not null auto_increment,
	question_id int(4),
	answered_id int(10),
	written_date date not null,
	content_text text,
	`like` int(3) default 0,
	`report` int(3) default 0,
	foreign key (answered_id) references user(id) on delete cascade,
	foreign key (question_id) references question(question_id) on delete cascade,
	primary key (answer_id, question_id)
	);

create table user_answer (
	userid	int(10)	not null,
	answered_id	int(10),
	foreign key (userid) references user(id) on delete cascade,
	foreign key (answered_id) references answer(answered_id) on delete cascade
	);
