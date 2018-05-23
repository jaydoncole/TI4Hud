CREATE DATABASE ti4hud;

USE ti4hud;

CREATE TABLE games (
    id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    code CHAR(8),
    date_created DATETIME,
    last_played DATETIME
);
