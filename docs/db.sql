create table registrations
(
    id int auto_increment,
    name varchar(100) not null,
    email varchar(100) not null,
    registration_number char(11) not null,
    birth_date date not null,
    created_at DATETIME not null,
    constraint table_name_pk
        primary key (id)
);
