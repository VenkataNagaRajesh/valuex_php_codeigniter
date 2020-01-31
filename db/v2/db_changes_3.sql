truncate VX_usertype;

alter table VX_usertype drop column create_username;
alter table VX_usertype drop column create_usertype;

insert into VX_usertype set usertype='Valuex',create_date='2016-06-24 07:12:49',modify_date='2016-06-24 07:12:49',create_userID=1;
insert into VX_usertype set usertype='Client',create_date='2016-06-24 07:12:49',modify_date='2016-06-24 07:12:49',create_userID=1;

alter table VX_user add column usertypeID tinyint(1) NOT NULL after roleID;
