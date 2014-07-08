SET storage_engine=InnoDB;


DROP SCHEMA IF EXISTS codequiz;
CREATE SCHEMA codequiz;
USE codequiz;


CREATE TABLE codequizuser (
    id              INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    name            VARCHAR(100) NOT NULL DEFAULT "",
    email           VARCHAR(100) NOT NULL,
    account_type    ENUM('instructor','student') DEFAULT 'student',

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
    language    INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,

    PRIMARY KEY (id)
    CONSTRAINT  `fk_language` FOREIGN KEY (language) REFERENCES language(id)
);


CREATE TABLE question (
    id              INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    spec            TEXT NOT NULL,
    author          INTEGER UNSIGNED NOT NULL,
    subject         INTEGER UNSIGNED NOT NULL,

    PRIMARY KEY (id),
    CONSTRAINT      `fk_author`  FOREIGN KEY (author) REFERENCES codequizuser(id),
    CONSTRAINT      `fk_subject` FOREIGN KEY (subject) REFERENCES subject(title),
);


CREATE TABLE answer (
    id          INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    correct     BOOLEAN NOT NULL DEFAULT FALSE,
    question    INTEGER UNSIGNED NOT NULL,

    PRIMARY KEY (id),
    CONSTRAINT  `fk_question` FOREIGN KEY (answer) REFERENCES question(id)
);


CREATE TABLE exam (
    id                      INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    exam_date               DATETIME NOT NULL,
    duration_minutes        INTEGER NOT NULL DEFAULT 30,
    administrator           INTEGER UNSIGNED NOT NULL,

    PRIMARY KEY (id),
    CONSTRAINT              `fk_admin` FOREIGN KEY (administrator) REFERENCES codequizuser(id)
);


-- relationship table for question <-> exam
CREATE TABLE examquestion (
    question        INTEGER UNSIGNED NOT NULL,
    exam            INTEGER UNSIGNED NOT NULL,

    PRIMARY KEY     (question,exam),
    CONSTRAINT      `fk_question` FOREIGN KEY (question) REFERENCES question(id),
    CONSTRAINT      `fk_exam` FOREIGN KEY (exam) REFERENCES exam(id)
);
