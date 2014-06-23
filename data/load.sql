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
    table_rule  VARCHAR(1000) NOT NULL,
    PRIMARY KEY(table_id)) CHARSET utf8;

LOAD DATA LOCAL INFILE "verbs.csv" INTO TABLE verbs CHARSET utf8
FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES
(table_id, verb_root);
LOAD DATA LOCAL INFILE "tenses.csv" INTO TABLE tenses CHARSET utf8
FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES;
LOAD DATA LOCAL INFILE "tables.csv" INTO TABLE tables CHARSET utf8
FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES
(table_id,
    @pas_s1m, @pas_s1f, @pas_s2m, @pas_s2f, @pas_s3m, @pas_s3f, @pas_p1m, @pas_p1f, @pas_p2m, @pas_p2f, @pas_p3m, @pas_p3f,
    @pre_s1,            @pre_s2m, @pre_s2f, @pre_s3m, @pre_s3f, @pre_p1,            @pre_p2m, @pre_p2f, @pre_p3m, @pre_p3f,
    @fut_s1,            @fut_s2m, @fut_s2f, @fut_s3m, @fut_s3f, @fut_p1,            @fut_p2m, @fut_p2f, @fut_p3m, @fut_p3f,
                        @imp_s2m, @imp_s2f,                                         @imp_p2m, @imp_p2f,
    @inf
) SET table_rule = CONCAT_WS(',',
    CONCAT(@pas_s1m, '<br />', @pas_s1f),
                        @pas_s2m, @pas_s2f, @pas_s3m, @pas_s3f, CONCAT(@pas_p1m, '<br />', @pas_p1f),
                                                                                    @pas_p2m, @pas_p2f, @pas_p3m, @pas_p3f,
    @pre_s1,            @pre_s2m, @pre_s2f, @pre_s3m, @pre_s3f, @pre_p1,            @pre_p2m, @pre_p2f, @pre_p3m, @pre_p3f,
    @fut_s1,            @fut_s2m, @fut_s2f, @fut_s3m, @fut_s3f, @fut_p1,            @fut_p2m, @fut_p2f, @fut_p3m, @fut_p3f,
    '',                 @imp_s2m, @imp_s2f, '',       '',       '',                 @imp_p2m, @imp_p2f, '',       '',
    @inf
);
