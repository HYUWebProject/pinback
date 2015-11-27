drop table if exists sugang;
drop table if exists subject_prof;
drop table if exists lecture;
drop table if exists feedback;
drop table if exists question;
drop table if exists answer;
drop table if exists report;
drop table if exists likeit;
drop table if exists lecturenote;
drop table if exists user;
drop table if exists subject;

create table user (
	id	int(10)	primary key,
	name	varchar(10) not null,
	password	varchar(50) not null,
	level	int(1) not null,
	point	int(5) not null
	);

create table subject (
	subjectcode	int(4)	primary key,
	subject 	varchar(20) not null
	);

create table sugang (
	studentid	int(10)	not null,
	sugangcode	int(4)	not null,
	foreign key (studentid) references user(id),
	foreign key (sugangcode) references subject(subjectcode)
);

create table subject_prof (
	profid	int(10)	not null,
	subjectcode	int(4) not null,
	foreign key (profid) references user(id),
	foreign key (subjectcode) references subject(subjectcode)
	);

create table lecture (
	subjectcode	int(4) not null,
	lecturecode	int(4)	primary key auto_increment,
	foreign key (subjectcode) references subject(subjectcode)
	);

create table feedback (
	subjectcode	int(4)	not null,
	studentid	int(10)	not null,
	content	text	not null,
	readflag	int(1)	not null,
	lecturecode	int(4) not null,
	foreign key (subjectcode) references subject(subjectcode),
	foreign key (studentid) references user(id),
	foreign key (lecturecode) references lecture(lecturecode)
	);

create table question (
	no 	int(5)	primary key auto_increment,
	title 	varchar(50)	not null,
	content	text	not null,
	writtenTime	datetime	not null,
	writerid	int(10)	not null,
	positionX	int(4)	not null,
	positionY	int(4)	not null,
	foreign key (writerid) references user(id)
	);

create table answer (
	questionNo	int(5) not null,
	no 	int(5)	primary key auto_increment,
	content	text	not null,
	writerid	int(10)	not null,
	likeit	int(3)	not null,
	report	int(1)	not null,
	foreign key (questionNo) references question(no),
	foreign key (writerid) references user(id)
	);

create table report (
	studentid	int(10)	not null,
	no 	int(5) not null,
	type	int(1)	not null,
	foreign key (studentid) references user(id)
);

create table likeit (
	studentid	int(10)	not null,
	no 	int(5)	not null,
	type	int(1)	not null,
	foreign	key (studentid) references user(id)
	);

create table lecturenote (
	imagepath	varchar(50) not null,
	lecturecode	int(4)	not null,
	page	int(3) not null,
	subjectcode	int(4)	not null,
	foreign key (lecturecode) references lecture(lecturecode),
	foreign key (subjectcode) references subject(subjectcode)
	);