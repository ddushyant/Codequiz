SET storage_engine=InnoDB;


DROP SCHEMA IF EXISTS codequiz;
CREATE SCHEMA codequiz;
USE codequiz;


CREATE TABLE codequizuser (
    id              INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    username        VARCHAR(100) NOT NULL DEFAULT "",
    account_type    ENUM('student','instructor') NOT NULL DEFAULT 'student',
    password        BINARY(60) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY `unique_username` (username)
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
    title           VARCHAR(1000) NOT NULL,
    spec            TEXT NOT NULL,
    subject         INTEGER UNSIGNED NOT NULL,
    qtype           ENUM('open','multiple','true-false','coding') NOT NULL,

    PRIMARY KEY (id),
    KEY idx_fk_subject (subject),

    CONSTRAINT      `fk_subject` FOREIGN KEY (subject) REFERENCES subject(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);

-- answers come in key<->value pairs
-- such as A -> foo
--         B -> bar
--
-- in the case of open-ended
-- leave key empty and just fill the answer_value
CREATE TABLE answer (
    id              INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    correct         BOOLEAN NOT NULL DEFAULT FALSE,
    question        INTEGER UNSIGNED NOT NULL,
    answer_key      ENUM('A','B','C','D') DEFAULT NULL,
    answer_value    TEXT NOT NULL,

    PRIMARY KEY (id),
    KEY idx_fk_question (question),

    CONSTRAINT  `fk_question` FOREIGN KEY (question) REFERENCES question(id)
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);


CREATE TABLE exam (
   id                      INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
   exam_title              VARCHAR(200) NOT NULL,
   exam_date               DATETIME NOT NULL,
   duration_minutes        INTEGER NOT NULL DEFAULT 30,

   PRIMARY KEY (id)

);


-- relationship table for question <-> exam
CREATE TABLE examquestion (
    question        INTEGER UNSIGNED NOT NULL,
    exam            INTEGER UNSIGNED NOT NULL,

    PRIMARY KEY     (question,exam)

);
