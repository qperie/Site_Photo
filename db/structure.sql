drop table if exists COMPTE;
drop table if exists IMAGE;
drop table if exists TEXTE;
drop table if exists COMMENTAIRE;

create table IMAGE
(
    img_id integer not null primary key auto_increment, 
    img_titre varchar(100) not null,
    img_galerie varchar(100) not null,
    img_description varchar(2000) not null,
    img_adresse varchar(150)
) engine = innodb character set utf8 collate utf8_unicode_ci;

create table COMPTE
(
    compte_id integer not null primary key auto_increment,
    compte_login varchar(50) not null,
    compte_mdp varchar(88) not null,
    compte_mail varchar(100),
    compte_statu varchar(10) not null
) engine = innodb character set utf8 collate utf8_unicode_ci;

create table TEXTE
(
    txt_id integer not null primary key,
    txt_titre varchar(100) not null,
    txt_texte varchar(100000) not null
) engine = innodb character set utf8 collate utf8_unicode_ci;

create table COMMENTAIRE
(
    com_id integer not null primary key auto_increment,
    img_id integer not null,
    compte_login varchar(50) not null,
    com_texte varchar(2000) not null
) engine = innodb character set utf8 collate utf8_unicode_ci;