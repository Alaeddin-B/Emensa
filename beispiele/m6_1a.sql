use emensawerbeseite;
create table bewertung (
                           id int auto_increment primary key,
                           bemerkung varchar(800) not null,
                           sterne int not null,
                           zeitpunkt datetime not null,
                           benutzerId bigint not null,
                           gerichtId bigint not null,
                           hervorgehoben boolean default false
);


alter table bewertung
    add constraint benutzerid_constraint foreign key (benutzerId) references benutzer(id) on delete cascade;
alter table bewertung
    ADD CONSTRAINT gerichtId_constraint foreign key (gerichtId) references gericht(id) on delete cascade;


