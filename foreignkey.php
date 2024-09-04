create table subject(
subject_id int(10)  not null auto_increment primary key,
subject_name varchar(50) not null,
class_id int(10) not null,
foreign key(class_id) references class(class_id)

);