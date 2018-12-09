
 /* NAME OF THE DATABASE IS commentsection with these 3 tables */

CREATE TABLE comments(
   cid int(11) not null AUTO_INCREMENT PRIMARY KEY,
   username varchar(128) not null,
   date datetime not null,
   message TEXT not null 
); /*stores question*/

CREATE TABLE reply(
   rid int(11) not null AUTO_INCREMENT PRIMARY KEY,
   cid int(11) not null,
   username varchar(128) not null,
   date datetime not null,
   rmessage TEXT not null 
);/*stores Answers*/

CREATE TABLE users(
   id int(11) not null AUTO_INCREMENT PRIMARY KEY,
   username varchar(128) not null,
   email varchar(128) not null,
   password varchar(128) not null,
   status int(11) not null 
); /*stores user details*/