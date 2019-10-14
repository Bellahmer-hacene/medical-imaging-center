-- ============================================================
--   Nom de la base   :  imagerie          
--   Nom de SGBD      :  MySQL Version 5.5.8  
--   Date de création :  10/08/2013  08:26  
-- ============================================================

USE imagerie;

-- ============================================================
--   Table : rdv                                             
-- ============================================================
CREATE TABLE IF NOT EXISTS rdv(
    id        INT(10)       NOT NULL AUTO_INCREMENT,
    nom            VARCHAR(100)  DEFAULT NULL,
    prenom           VARCHAR(100)  DEFAULT NULL,
    telephone           int(100)   DEFAULT NULL,
    email                varchar(100),
    date_n               date,
    nature               varchar(100),
    examen               varchar(100),
    dat                 date,
    heure                time,
    valide               int(11) DEFAULT 0,

    PRIMARY KEY(id)
);

-- ============================================================
--   Table : admin                                             
-- ============================================================
CREATE TABLE IF NOT EXISTS admin(
    code_admin      int(10)   NOT NULL AUTO_INCREMENT,
    login            VARCHAR(100)  DEFAULT NULL,
    passwor              VARCHAR(100)  DEFAULT NULL,
  
    PRIMARY KEY(code_admin)
);

insert into admin(login,passwor) values ('secretaire','$1$gB0.po0.$kj7aUcnTPC3n5IYRZW7.6/');