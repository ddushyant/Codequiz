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
    id      TINYINT UNSIGNED NOT NULL AUTO_INCREMENT, 
    name    VARCHAR(100) NOT NULL,

    PRIMARY KEY (id)
);


CREATE TABLE subject (
    id          INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL,

    PRIMARY KEY (id)
);


-- when a question is deleted, so should be any exam referencing
-- and and answer referencing
CREATE TABLE question (
    id              INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    title           VARCHAR(1000) NOT NULL,
    spec            TEXT NOT NULL,
    language        TINYINT UNSIGNED NOT NULL,
    subject         INTEGER UNSIGNED NOT NULL,
    qtype           ENUM('open','multiple','true-false','fill') NOT NULL,

    PRIMARY KEY (id),
    KEY idx_fk_subject (subject),
    KEY idx_fk_language (language),

    CONSTRAINT      `fk_subject` FOREIGN KEY (subject) REFERENCES subject(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,

    CONSTRAINT      `fk_language` FOREIGN KEY (language) REFERENCES language(id) 
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
    answer_key      TEXT NOT NULL,
    answer_value    TEXT NOT NULL,

    PRIMARY KEY (id),
    KEY idx_fk_question (question),

    CONSTRAINT  `fk_question` FOREIGN KEY (question) REFERENCES question(id)
        ON DELETE CASCADE 
        ON UPDATE CASCADE
);


CREATE TABLE exam (
   id                      INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
   title                   VARCHAR(200) NOT NULL,
   instructor               INTEGER UNSIGNED NOT NULL,

   PRIMARY KEY (id),
   KEY idx_fk_instructor (instructor),

   CONSTRAINT `fk_instructor` FOREIGN KEY (instructor) REFERENCES codequizuser(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE

);


-- relationship table for question <-> exam
CREATE TABLE examquestion (
    exam            INTEGER UNSIGNED NOT NULL,
    question        INTEGER UNSIGNED NOT NULL,
    weight          INTEGER UNSIGNED NOT NULL,

    PRIMARY KEY     (exam,question),

    CONSTRAINT `fk_exam` FOREIGN KEY (exam) REFERENCES exam(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT `fk_question_examquestion` FOREIGN KEY (question) REFERENCES question(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE

);
