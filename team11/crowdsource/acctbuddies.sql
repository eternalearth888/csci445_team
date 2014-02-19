use team11;

drop table if exists comments;
drop table if exists progress;
drop table if exists profile;
drop table if exists mentors;
drop table if exists goal;
drop table if exists goal_title;
drop table if exists client;
drop table if exists image;
drop table if exists login_attempts;

create table client (
		id integer AUTO_INCREMENT primary key,
		username char(20) NOT NULL,
		password char(20) NOT NULL,
		salt char(128) NOT NULL);

create table login_attempts (
		user_id integer NOT NULL,
		time varchar(30) NOT NULL);

create table image (
		id integer AUTO_INCREMENT primary key,
		img_path char(200));

create table profile (
		id integer AUTO_INCREMENT,
		last_name char(50),
		first_name char(50),
		user_id integer,
		image_id integer,
		foreign key (image_id) references image(id),
		primary key(id),
		foreign key (user_id) references client(id));

create table goal_title (
		id integer AUTO_INCREMENT primary key,
		tag char(100),
		title char(100));

create table goal (
		id integer AUTO_INCREMENT primary key,
		why text,
		how text,
		frequency integer,
		start_date date,
		status boolean,
		last_update timestamp,
		intended_end_date date,
		user_id integer,
		goal_title_id integer,
		foreign key (user_id) references client(id),
		foreign key (goal_title_id) references goal_title(id)); 

create table progress (
		id integer AUTO_INCREMENT primary key,
		status_text text,
		status_update timestamp,
		goal_id integer,
		foreign key (goal_id) references goal(id));

create table comments (
		id integer AUTO_INCREMENT primary key,
		note text,
		note_update timestamp,
		buddy text,
		goal_id integer,
		foreign key (goal_id) references goal(id));

create table mentors (
		id integer AUTO_INCREMENT primary key,
		mentor integer,
		goal_id integer,
		foreign key(mentor) references client(id),
		foreign key(goal_id) references goal(id));

INSERT INTO image (img_path) VALUES ('upload/default_person.jpg');

