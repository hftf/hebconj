DROP DATABASE IF EXISTS hebconj;
CREATE DATABASE hebconj;
USE hebconj;
SET NAMES "utf8";

CREATE TABLE verbs (
    verb_id     INT NOT NULL AUTO_INCREMENT,
    table_id    INT NOT NULL,
    verb_root   VARCHAR(16) NOT NULL,
    PRIMARY KEY(verb_id));
CREATE TABLE tenses (
    tense_id        INT NOT NULL AUTO_INCREMENT,
    tense_name      VARCHAR(16) NOT NULL,
    table_id_start  INT NOT NULL,
    table_id_end    INT NOT NULL,
    PRIMARY KEY(tense_id));
CREATE TABLE tables (
    table_id    INT NOT NULL AUTO_INCREMENT,
    table_rule  VARCHAR(1000) NOT NULL,
    PRIMARY KEY(table_id));

LOAD DATA LOCAL INFILE "verbs.csv" INTO TABLE verbs
FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES
(table_id, verb_root);
LOAD DATA LOCAL INFILE "tenses.csv" INTO TABLE tenses
FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES;
LOAD DATA LOCAL INFILE "tables.csv" INTO TABLE tables
FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES;