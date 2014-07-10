SET storage_engine=InnoDB;


DROP SCHEMA IF EXISTS codequiz;
CREATE SCHEMA codequiz;
USE codequiz;


CREATE TABLE codequizuser (
    id              INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    username        VARCHAR(100) NOT NULL DEFAULT "",
    account_type    ENUM('student','instructor') NOT NULL,

    PRIMARY KEY (id)
);


CREATE TABLE language (
    id      INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
    name    VARCHAR(100) NOT NULL,

    PRIMARY KEY (id)
);


CREATE TABLE subject (
    id          INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    title       VARCHAR(100) NOT NULL,
    language    INTEGER UNSIGNED NOT NULL, 

    PRIMARY KEY (id),
    KEY idx_fk_language (language),

    CONSTRAINT  `fk_language` FOREIGN KEY (language) REFERENCES language(id)
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);


-- when a question is deleted, so should be any exam referencing
-- and and answer referencing
CREATE TABLE question (
    id              INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    spec            TEXT NOT NULL,
    author          INTEGER UNSIGNED NOT NULL,
    subject         INTEGER UNSIGNED NOT NULL,
    qtype           ENUM('open','multiple'),

    PRIMARY KEY (id),
    KEY idx_fk_author (author),
    KEY idx_fk_subject (subject),

    CONSTRAINT      `fk_author`  FOREIGN KEY (author) REFERENCES codequizuser(id)
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    CONSTRAINT      `fk_subject` FOREIGN KEY (subject) REFERENCES subject(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);


CREATE TABLE answer (
    id          INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    correct     BOOLEAN NOT NULL DEFAULT FALSE,
    question    INTEGER UNSIGNED NOT NULL,
    body        TEXT NOT NULL,

    PRIMARY KEY (id),
    KEY idx_fk_question (question),

    CONSTRAINT  `fk_question` FOREIGN KEY (question) REFERENCES question(id)
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);


CREATE TABLE exam (
   id                      INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
   exam_date               DATETIME NOT NULL,
   duration_minutes        INTEGER NOT NULL DEFAULT 30,
   administrator           INTEGER UNSIGNED NOT NULL,

   PRIMARY KEY (id),
   KEY idx_fk_admin (administrator),

   CONSTRAINT              `fk_admin` FOREIGN KEY (administrator) REFERENCES codequizuser(id)
       ON DELETE CASCADE
       ON UPDATE CASCADE
);


-- relationship table for question <-> exam
CREATE TABLE examquestion (
    question        INTEGER UNSIGNED NOT NULL,
    exam            INTEGER UNSIGNED NOT NULL,

    PRIMARY KEY     (question,exam)

);
