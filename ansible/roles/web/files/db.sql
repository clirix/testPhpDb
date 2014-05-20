CREATE TABLE IF NOT EXISTS user(
  id integer NOT NULL AUTO_INCREMENT,
  first_name char(40),
  last_name char (40),
  email char (60),
  PRIMARY KEY (id)
);