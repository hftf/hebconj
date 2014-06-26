USE hebconj;
SET NAMES "utf8";

DROP TABLE IF EXISTS verbs;
DROP TABLE IF EXISTS tenses;
DROP TABLE IF EXISTS tables;

CREATE TABLE verbs (
    verb_id     INT NOT NULL AUTO_INCREMENT,
    table_id    INT NOT NULL,
    verb_root   VARCHAR(16) NOT NULL,
    PRIMARY KEY(verb_id)) CHARSET utf8;
CREATE TABLE tenses (
    tense_id        INT NOT NULL AUTO_INCREMENT,
    tense_name      VARCHAR(16) NOT NULL,
    table_id_start  INT NOT NULL,
    table_id_end    INT NOT NULL,
    PRIMARY KEY(tense_id)) CHARSET utf8;
CREATE TABLE tables (
    table_id    INT NOT NULL AUTO_INCREMENT,
    pre_sm      VARCHAR(50) NOT NULL,
    pre_sf      VARCHAR(50) NOT NULL,
    pre_pm      VARCHAR(50) NOT NULL,
    pre_pf      VARCHAR(50) NOT NULL,
    pas_s1      VARCHAR(50) NOT NULL,
    pas_s2m     VARCHAR(50) NOT NULL,
    pas_s2f     VARCHAR(50) NOT NULL,
    pas_s3m     VARCHAR(50) NOT NULL,
    pas_s3f     VARCHAR(50) NOT NULL,
    pas_p1      VARCHAR(50) NOT NULL,
    pas_p2m     VARCHAR(50) NOT NULL,
    pas_p2f     VARCHAR(50) NOT NULL,
    pas_p3m     VARCHAR(50) NOT NULL,
    pas_p3f     VARCHAR(50) NOT NULL,
    fut_s1      VARCHAR(50) NOT NULL,
    fut_s2m     VARCHAR(50) NOT NULL,
    fut_s2f     VARCHAR(50) NOT NULL,
    fut_s3m     VARCHAR(50) NOT NULL,
    fut_s3f     VARCHAR(50) NOT NULL,
    fut_p1      VARCHAR(50) NOT NULL,
    fut_p2m     VARCHAR(50) NOT NULL,
    fut_p2f     VARCHAR(50) NOT NULL,
    fut_p3m     VARCHAR(50) NOT NULL,
    fut_p3f     VARCHAR(50) NOT NULL,
    imp_s2m     VARCHAR(50) NOT NULL,
    imp_s2f     VARCHAR(50) NOT NULL,
    imp_p2m     VARCHAR(50) NOT NULL,
    imp_p2f     VARCHAR(50) NOT NULL,
    inf         VARCHAR(50) NOT NULL,
    _comment    VARCHAR(1000) NOT NULL,
    table_rule  VARCHAR(1000) NOT NULL,
    PRIMARY KEY(table_id)) CHARSET utf8;

LOAD DATA LOCAL INFILE "verbs.csv" INTO TABLE verbs CHARSET utf8
FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES
(table_id, verb_root);
LOAD DATA LOCAL INFILE "tenses.csv" INTO TABLE tenses CHARSET utf8
FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES;
LOAD DATA LOCAL INFILE "tables.csv" INTO TABLE tables CHARSET utf8
FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES
SET table_rule = CONCAT_WS(',',
    CONCAT(pre_sm, '<br />', pre_sf),
                      pre_sm,  pre_sf,  pre_sm,  pre_sf,  CONCAT(pre_pm, '<br />', pre_pf),
                                                                            pre_pm,  pre_pf,  pre_pm,  pre_pf,
    pas_s1,           pas_s2m, pas_s2f, pas_s3m, pas_s3f, pas_p1,           pas_p2m, pas_p2f, pas_p3m, pas_p3f,
    fut_s1,           fut_s2m, fut_s2f, fut_s3m, fut_s3f, fut_p1,           fut_p2m, fut_p2f, fut_p3m, fut_p3f,
    '',               imp_s2m, imp_s2f, '',      '',       '',              imp_p2m, imp_p2f, '',      '',
    inf
);
