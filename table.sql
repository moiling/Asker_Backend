-- ------------------------------------
-- Source Database    : asker
-- Target Server Type : MYSQL
-- File Encoding      : UTF-8

-- Date               : 2016-05-30
-- ------------------------------------
DROP DATABASE IF EXISTS asker;
CREATE DATABASE asker
  DEFAULT CHARSET utf8
  COLLATE utf8_general_ci;

USE asker;

-- ------------------------------------
-- Table structure for users
-- ------------------------------------
DROP TABLE IF EXISTS user;
CREATE TABLE user (
  id        INTEGER                    NOT NULL AUTO_INCREMENT,
  accountId VARCHAR(20)                NOT NULL,
  -- 注册时间 --
  date      TIMESTAMP                  NOT NULL DEFAULT CURRENT_TIMESTAMP,
  type      ENUM('student', 'teacher') NOT NULL,
  password  VARCHAR(20)                NOT NULL,
  nickName  VARCHAR(15),
  sex       ENUM('male', 'female'),
  tel       VARCHAR(11),
  email     VARCHAR(30),

  PRIMARY KEY (id)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for student
-- ------------------------------------
DROP TABLE IF EXISTS student;
CREATE TABLE student (
  id      INTEGER NOT NULL AUTO_INCREMENT,
  userId  INTEGER NOT NULL,
  -- 入学年份 --
  year    INT(4),
  college VARCHAR(20),
  academy VARCHAR(20),
  major   VARCHAR(20),

  PRIMARY KEY (id),
  FOREIGN KEY (userId) REFERENCES user (id)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for teacher
-- ------------------------------------
DROP TABLE IF EXISTS teacher;
CREATE TABLE teacher (
  id             INTEGER NOT NULL AUTO_INCREMENT,
  userId         INTEGER NOT NULL,
  college        VARCHAR(20),
  academy        VARCHAR(20),
  realName       VARCHAR(10),
  -- 是否认证 --
  authentication BOOL DEFAULT FALSE,

  PRIMARY KEY (id),
  FOREIGN KEY (userId) REFERENCES user (id)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for book
-- ------------------------------------
DROP TABLE IF EXISTS book;
CREATE TABLE book (
  id         INTEGER NOT NULL AUTO_INCREMENT,
  name       VARCHAR(20),
  vesion     VARCHAR(10),
  writer     VARCHAR(30),
  publishing VARCHAR(20),

  PRIMARY KEY (id)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for bookInfo
-- ------------------------------------
DROP TABLE IF EXISTS bookInfo;
CREATE TABLE bookInfo (
  id             INTEGER NOT NULL AUTO_INCREMENT,
  bookId         INTEGER,
  chapter        INTEGER,
  questionNumber VARCHAR(10),

  PRIMARY KEY (id),
  FOREIGN KEY (bookId) REFERENCES book (id)
    ON DELETE SET NULL
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for questionContent
-- ------------------------------------
DROP TABLE IF EXISTS questionContent;
CREATE TABLE questionContent (
  id         INTEGER NOT NULL AUTO_INCREMENT,
  bookInfoId INTEGER,
  content    VARCHAR(1000),

  PRIMARY KEY (id),
  FOREIGN KEY (bookInfoId) REFERENCES bookInfo (id)
    ON DELETE SET NULL
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for question
-- ------------------------------------
DROP TABLE IF EXISTS question;
CREATE TABLE question (
  id           INTEGER      NOT NULL AUTO_INCREMENT,
  authorId     INTEGER      NOT NULL,
  contentId    INTEGER      NOT NULL,
  title        VARCHAR(255) NOT NULL,
  -- 提问时间 --
  date         TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  -- 最后更新时间 --
  recent       TIMESTAMP    NOT NULL,
  -- 提问类型(学科等) --
  type         VARCHAR(20),
  answerCount  INTEGER      NOT NULL DEFAULT 0,
  bestAnswerId INTEGER,
  starCount    INTEGER      NOT NULL DEFAULT 0,

  PRIMARY KEY (id),
  FOREIGN KEY (authorId) REFERENCES student (id)
    ON DELETE CASCADE,
  FOREIGN KEY (contentId) REFERENCES questionContent (id)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- MySQL高版本不允许使用多个CURRENT_TIMESTAMP, 故用Trigger更新时间
DROP TRIGGER IF EXISTS updateQuestionTrigger;
CREATE TRIGGER updateQuestionTrigger BEFORE UPDATE ON question
FOR EACH ROW SET NEW.recent = NOW();

-- ------------------------------------
-- Table structure for answerContent
-- ------------------------------------
DROP TABLE IF EXISTS answerContent;
CREATE TABLE answerContent (
  id      INTEGER NOT NULL AUTO_INCREMENT,
  content VARCHAR(1000),

  PRIMARY KEY (id)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for answer
-- ------------------------------------
DROP TABLE IF EXISTS answer;
CREATE TABLE answer (
  id            INTEGER   NOT NULL AUTO_INCREMENT,
  questionId    INTEGER   NOT NULL,
  authorId      INTEGER   NOT NULL,
  contentId     INTEGER   NOT NULL,
  likeNumber    INTEGER   NOT NULL DEFAULT 0,
  dislikeNumber INTEGER   NOT NULL DEFAULT 0,
  date          TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (id),
  FOREIGN KEY (questionId) REFERENCES question (id)
    ON DELETE CASCADE,
  FOREIGN KEY (authorId) REFERENCES user (id)
    ON DELETE CASCADE,
  FOREIGN KEY (contentId) REFERENCES answerContent (id)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for questionPic
-- ------------------------------------
DROP TABLE IF EXISTS questionPic;
CREATE TABLE questionPic (
  id        INTEGER NOT NULL AUTO_INCREMENT,
  contentId INTEGER NOT NULL,
  pic       VARCHAR(255),

  PRIMARY KEY (id),
  FOREIGN KEY (contentId) REFERENCES questionContent (id)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for answerPic
-- ------------------------------------
DROP TABLE IF EXISTS answerPic;
CREATE TABLE answerPic (
  id        INTEGER NOT NULL AUTO_INCREMENT,
  contentId INTEGER NOT NULL,
  pic       VARCHAR(255),

  PRIMARY KEY (id),
  FOREIGN KEY (contentId) REFERENCES answerContent (id)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for ask
-- ------------------------------------
DROP TABLE IF EXISTS ask;
CREATE TABLE ask (
  id         INTEGER NOT NULL AUTO_INCREMENT,
  teacherId  INTEGER NOT NULL,
  questionId INTEGER NOT NULL,
  isChecked  BOOL,
  isAnswered BOOL,

  PRIMARY KEY (id),
  FOREIGN KEY (teacherId) REFERENCES teacher (id)
    ON DELETE CASCADE,
  FOREIGN KEY (questionId) REFERENCES question (id)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for starQuestion
-- ------------------------------------
DROP TABLE IF EXISTS starQuestion;
CREATE TABLE starQuestion (
  id         INTEGER NOT NULL AUTO_INCREMENT,
  studentId  INTEGER NOT NULL,
  questionId INTEGER NOT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (studentId) REFERENCES student (id)
    ON DELETE CASCADE,
  FOREIGN KEY (questionId) REFERENCES question (id)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for likeAnswer
-- ------------------------------------
DROP TABLE IF EXISTS likeAnswer;
CREATE TABLE likeAnswer (
  id        INTEGER NOT NULL AUTO_INCREMENT,
  studentId INTEGER NOT NULL,
  answerId  INTEGER NOT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (studentId) REFERENCES student (id)
    ON DELETE CASCADE,
  FOREIGN KEY (answerId) REFERENCES answer (id)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Table structure for dislikeAnswer
-- ------------------------------------
DROP TABLE IF EXISTS dislikeAnswer;
CREATE TABLE dislikeAnswer (
  id        INTEGER NOT NULL AUTO_INCREMENT,
  studentId INTEGER NOT NULL,
  answerId  INTEGER NOT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (studentId) REFERENCES student (id)
    ON DELETE CASCADE,
  FOREIGN KEY (answerId) REFERENCES answer (id)
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 0
  DEFAULT CHARSET = utf8;

-- ----------------------------
-- Table structure for token
-- ----------------------------
DROP TABLE IF EXISTS token;
CREATE TABLE token (
  token  VARCHAR(64) DEFAULT NULL,
  userId INTEGER NOT NULL,

  FOREIGN KEY (userId) REFERENCES user (id)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- ------------------------------------
-- Add foreign key
-- ------------------------------------
ALTER TABLE question ADD CONSTRAINT bestAnswerId
FOREIGN KEY question(bestAnswerId) REFERENCES answer (id)
  ON DELETE SET NULL;