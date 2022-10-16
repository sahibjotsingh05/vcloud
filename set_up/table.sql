/* PLEASE READ.

SUBJECT NAMES:-
	> 'lowercase' letters are to be used.
	> Names containing multiple words should be snake_cased such as 'social_science',
	> No abbrevations can be used. Eg.:- 'sci' is NOT VALID, 'science' is VALID.

=> PARENT TABLE should be created before the CHILD TABLE.

CONSTRAINT NAMES:-
SYNTAX :- tbl_name_column_name_X

	WHERE:-
		> tblName = Name of the required table. [camelCased]
		> column_name = Name of the required column. [snake_cased]
		> X = Constraint name. [Abbrevated, CAPITAL]
				FK for FOREIGN KEY, PK for PRIMARY KEY, U for UNIQUE, IX for INDEX

DATABASE NAME:- vcloud
*/

/* FOR DATABASE */

CREATE DATABASE vcloud;

/* --------------------- */

/* FOR SERVER LOGIN */

CREATE TABLE server_detail(
active_for int(255),
server_date datetime DEFAULT CURRENT_TIMESTAMP,
first_login boolean DEFAULT 0);    -- 0 means FALSE. DO NOT CHANGE IT.

/* --------------------- */

/* FOR department */

CREATE TABLE department(
name varchar(200),
id int(11),
CONSTRAINT department_name_U UNIQUE(name),    -- UNIQUE CONSTRAINT
CONSTRAINT department_id_PK PRIMARY KEY(id));    -- PRIMARY KEY CONSTRAINT

/* --------------------- */

/* FOR DIFFERENT SUBJECTS. [VIDEO RECORD]
JUST REPLACE 'mention_subject' WITH THE SUBJECT NAME */

CREATE TABLE mention_subject(
vid_id varchar(200),
vid_name varchar(200),
keyword varchar(200),
extension varchar(200),
upload_date datetime DEFAULT CURRENT_TIMESTAMP,
time_duration double(10,4) DEFAULT 0,
CONSTRAINT mention_subject_vid_id_PK PRIMARY KEY(vid_id));    -- PRIMARY CONSTRAINT

/* --------------------- */

/* FOR USERS */

CREATE TABLE user_account(
name varchar(200),
email varchar(200),
dept_id int(11),
creation datetime DEFAULT CURRENT_TIMESTAMP,
user_pass varchar(200),
hod tinyint(1) DEFAULT 0,
CONSTRAINT user_account_email_U UNIQUE(email),    -- UNIQUE CONSTRAINT
CONSTRAINT user_account_dept_id_FK FOREIGN KEY(dept_id)	-- FOREIGN KEY CONSTRAINT
REFERENCES department(id)
ON UPDATE CASCADE ON DELETE CASCADE);

/* --------------------- */

/* FOR HISTORIES OF DIFFERENT SUBJECTS. [VIDEO HISTORY]
JUST REPLACE 'mention_subject' WITH THE SUBJECT NAME */

CREATE TABLE mention_subject_history(
vid_id varchar(200),
watch_date datetime DEFAULT CURRENT_TIMESTAMP,
user_email varchar(200),
CONSTRAINT mention_subject_history_vid_id_FK FOREIGN KEY(vid_id) REFERENCES mention_subject(vid_id)
ON UPDATE CASCADE ON DELETE CASCADE,
CONSTRAINT mention_subject_history_user_email_FK FOREIGN KEY(user_email) REFERENCES user_account(email)
ON UPDATE CASCADE ON DELETE CASCADE);    -- FOREIGN KEY CONSTRAINT

/* --------------------- */

/* FOR INDEX */

CREATE INDEX tbl_name_column_name
ON table_name(
column);

/* --------------------- */
