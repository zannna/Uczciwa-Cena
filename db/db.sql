create table user_details
(
    id serial
        primary key,
    name varchar(100) not null,
    surname varchar(100) not null,
    place varchar(250) not null,
    phone_number integer not null
);
create table users
(
    id serial
        primary key,
    email varchar(250) not null,
    password varchar(255) not null,
    id_user_details integer not null
        constraint users_user_details_id_fk
            references user_details
            on update cascade on delete cascade,
    role varchar(25) default USER not null
);
create table advertisement
(
    id          serial
        primary key
        unique,
    name        varchar(200),
    place       varchar(300),
    description varchar(2000),
    picture1    varchar(250),
    picture2    varchar(250),
    picture3    varchar(250),
    picture4    varchar(250),
    id_owner    integer not null
        constraint advertisement_users_id_fk
            references users
            on update cascade
);

create table comments
(
    content varchar(750),
    ad_id integer not null
        constraint comments_advertisement_id_fk
            references advertisement
            on update cascade on delete cascade,
    user_id integer not null
        constraint comments_users_id_fk
            references users
            on update cascade,
    adding_date timestamp not null,
    comment_id serial
        primary key
        unique
);
create table liked
(
    id_user integer not null
        constraint liked_users_id_fk
            references users
            on update cascade,
    id_ad integer not null
        constraint liked_advertisement_id_fk
            references advertisement
            on update cascade on delete cascade
);
CREATE OR REPLACE FUNCTION getUserLiked(
    id_user INTEGER)
    RETURNS TABLE(id integer, picture1 character varying) AS $$
BEGIN
RETURN QUERY SELECT advertisement.id,
                        advertisement.picture1
                 FROM advertisement INNER JOIN liked
                                               ON advertisement.id =
                                                  liked.id_ad where liked.id_user=:id_user;
END; $$
LANGUAGE 'plpgsql';
INSERT INTO public.comments (content, ad_id, user_id, adding_date, comment_id) VALUES
    ('badziewie', 45, 83, '2023-01-22 13:58:50.911468', DEFAULT);
INSERT INTO public.user_details (id, name, surname, place, phone_number) VALUES (DEFAULT,
                                                                                 'Ewa', 'Nowak', 'Lublin', 888888888);
INSERT INTO public.users (id, email, password, id_user_details, role) VALUES (DEFAULT,
                                                                              'nowak@gmail.com', '$2y$10$DWef5jY6geTRbJXJof..cOACry/qCuUUelrMA9Jg3m0u9U2MIv6bS', 1,
                                                                              'user');
INSERT INTO public.user_details (id, name, surname, place, phone_number) VALUES (DEFAULT,
                                                                                 'Mateusz', 'Kowalski', 'Lublin', 333333333);
INSERT INTO public.users (id, email, password, id_user_details, role) VALUES (DEFAULT,
                                                                              'nowak@gmail.com', '$2y$10$DWef5jY6geTRbJXJof..cOACry/qCuUUelrMA9Jg3m0u9U2MIv6bS', 2,
                                                                              'user');
INSERT INTO public.advertisement (id, name, place, description, picture1, picture2, picture3,
                                  picture4, id_owner) VALUES (DEFAULT, 'foka', 'Lublin', 'Mało używana', 'foka.jpg', null, null, null, 1);
INSERT INTO public.advertisement (id, name, place, description, picture1, picture2, picture3,
                                  picture4, id_owner) VALUES (DEFAULT, 'szafa', 'Lublin', 'Aktualnie rozmontowana', 'szafa.jpg', null,
                                                              null, null, 1);
INSERT INTO public.advertisement (id, name, place, description, picture1, picture2, picture3,
                                  picture4, id_owner) VALUES (DEFAULT, 'wózek', 'Lublin', 'bardzo fajny. Odbiór w okolicach dworca',
                                                              'wózek.jpg', null, null, null, 2);
INSERT INTO public.comments (content, ad_id, user_id, adding_date, comment_id) VALUES
    ('Wezmę', 1, 2, '2023-01-22 15:58:50.911468', DEFAULT);
INSERT INTO public.comments (content, ad_id, user_id, adding_date, comment_id) VALUES ('Możesz
podać dokładne wymiary?', 2, 2, '2023-01-22 17:58:50.911468', DEFAULT);
INSERT INTO public.liked (id_user, id_ad) VALUES (2, 1);
INSERT INTO public.liked (id_user, id_ad) VALUES (2, 2);
INSERT INTO public.liked (id_user, id_ad) VALUES (1, 3);