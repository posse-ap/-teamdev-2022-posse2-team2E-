DROP SCHEMA IF EXISTS shukatsu;
CREATE SCHEMA shukatsu;
USE shukatsu;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  agent_name VARCHAR(255) UNIQUE NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- INSERT INTO users SET email='testtest@gmail.com', password=sha1('password');

INSERT INTO users SET agent_name='kashiken', email='testtest@gmail.com', password='$2y$10$jFWlJ.8RvTWwNd1ZYv4NReC4KmMqgb804u./LDVDrz1Bb0w7h781.';
INSERT INTO users SET agent_name='kashiken', email='test@icloud.com', password='$2y$10$jFWlJ.8RvTWwNd1ZYv4NReC4KmMqgb804u./LDVDrz1Bb0w7h781.';
INSERT INTO users SET agent_name='kashiken', email='test@neko.com', password='$2y$10$jFWlJ.8RvTWwNd1ZYv4NReC4KmMqgb804u./LDVDrz1Bb0w7h781.';
INSERT INTO users SET agent_name='kashiken', email='test@nya.com', password='$2y$10$jFWlJ.8RvTWwNd1ZYv4NReC4KmMqgb804u./LDVDrz1Bb0w7h781.';
INSERT INTO users SET agent_name='kashiken', email='test@hiii.com', password='$2y$10$jFWlJ.8RvTWwNd1ZYv4NReC4KmMqgb804u./LDVDrz1Bb0w7h781.';
-- INSERT INTO users (email, password) VALUES ('testtest@gmail.com', sha1('password'));
-- INSERT INTO users (email, password) VALUES ('testtest@icloud.com', sha1('password'));
-- INSERT INTO users (email, password) VALUES ('testtest@nya.com', sha1('password'));
-- INSERT INTO users (email, password) VALUES ('testtest@hiii.com', sha1('password'));
-- VALUES 
  -- ('test@gmail.com', sha1('pass')),
  -- ('test@icloud.com', sha1('pass')),
  -- ('test@neko.com', sha1('password')),
  -- ('test@nya.com', sha1('password'));

-- 
-- INSERT INTO
--     `users` (`email`, `password`)
-- VALUES
--     ('testtest@gmail.com', 'password'),
--     ('kashiken4646@gmail.com', 'secret'),
--     ('akichan@gmail.com', 'akiraa');

DROP TABLE IF EXISTS events;
CREATE TABLE events (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO events SET title='イベント1';
INSERT INTO events SET title='イベント2';