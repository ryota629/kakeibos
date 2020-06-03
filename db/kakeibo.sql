
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE kakeibo1. users(
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp()
);


CREATE TABLE kakeibo1. records(
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  date date NOT NULL,
  user_id int NOT NULL,
  category int(11) NOT NULL REFERENCES category(category_id),
  type int(11) NOT NULL,
  amount int(11) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT '0000-00-00 00:00:00'
);


CREATE TABLE kakeibo1. category(
  category_id int(11) NOT NULL PRIMARY KEY,
  name VARCHAR(32)
);












