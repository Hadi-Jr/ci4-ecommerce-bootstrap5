create table attribute_value
(
    id           int auto_increment
        primary key,
    attribute_id int          not null,
    value        varchar(255) not null,
    constraint attribute_value_ibfk_1
        foreign key (attribute_id) references attribute_value (id)
);

create index attribute_id
    on attribute_value (attribute_id);

