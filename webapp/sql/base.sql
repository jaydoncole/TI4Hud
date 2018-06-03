CREATE DATABASE ti4hud;

USE ti4hud;

CREATE TABLE games (
    game_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    code CHAR(8),
    date_created DATETIME,
    last_played DATETIME,
    created_by CHAR(16)
);

CREATE TABLE objectives (
    objective_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    stage TINYINT NOT NULL,
    title VARCHAR(32),
    text VARCHAR(256)
);

CREATE TABLE game_objectives (
    game_objective_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    game_id INT UNSIGNED NOT NULL,
    objective_id INT UNSIGNED NOT NULL
);

CREATE TABLE factions (
    faction_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(32),
    icon CHAR(16)
);

CREATE TABLE game_factions(
    game_faction_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    game_id INT UNSIGNED NOT NULL,
    faction_id INT UNSIGNED NOT NULL,
    score INT UNSIGNED NOT NULL
);

INSERT INTO objectives (stage, title, text) VALUES
(1, "Corner the Market", "Control 4 planets that each have the same planet trait"),
(1, "Develop Weaponry", "Own 2 unit upgrade technologies"),
(1, "Diversify Research", "Own 2 technologies in each of 2 colors"),
(1, "Erect a Monument", "Spend 8 resources"),
(1, "Expand Borders", "Control 6 planets in non-home systems"),
(1, "Found Research Outposts", "Control 3 planets that have technology specialties"),
(1, "Intimidate the Council", "Have 1+ ships in two systems that are adjacent to Mecatol Rex"),
(1, "Lead From the Front", "Spend a total of 3 tokens from your tactic and/or strategy pool"),
(1, "Negotiate Trade Routes", "Spend 5 Trade Goods "),
(1, "Sway the Council", "Spend 8 influence"),
(2, "Centralize Galactic Trade", "Spend 10 trade goods"),
(2, "Conquer the Weak", "Control 1 planet that is in another player's home system"),
(2, "Form Galactic Brain Trust", "Control 5 planets that have technology specialties"),
(2, "Found a Golden Age", "Spend 16 resources"),
(2, "Galvanize the People", "Spend a total of 6 tokens from your tactic and/or strategy pools"),
(2, "Manipulate Galactic Law", "Spend 16 influence"),
(2, "Master of Sciences", "Own 2 technologies in each of 4 colors."),
(2, "Revolutionize Warfare", "Own 3 unit upgrade technologies"),
(2, "Subdue the Galaxy", "Control 11 planets in non-home systems"),
(2, "Unify the Colonies", "Control 6 planets that each have the same planet trait");

INSERT INTO factions (name, icon) VALUES
("The Yssaril Tribs", "yssaril.svg"),
("The Clan of Saar", "saar.svg"),
("Universities of Jol-Nar", "jol-nar.svg"),
("The Nekro Virus", "necro.svg"),
("The Xxcha Kingdom", "xxcha.svg"),
("The Arborec", "arborec.svg"),
("The Embers of Muaat", "muaat.svg"),
("The Winnu", "winnu.svg"),
("The Ghosts of Creuss", "creuss.svg"),
("Sardakk N'Orr", "sardakk_norr.svg"),
("The Mentak Coalition", "mentac.svg"),
("The Barony of Letnev", "letnev.svg"),
("Tye Yin Brotherhood", "yin.svg"),
("The Emirates of Hacan", "hacan.svg"),
("The Naalu Collective", "naalu.svg"),
("The Lizix Mindnet", "lizix.svg"),
("The Federation of Sol", "sol.svg");

CREATE TABLE scored_objectives (
    scored_objective_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    game_id INT UNSIGNED NOT NULL,
    faction_id INT UNSIGNED NOT NULL,
    objective_id INT UNSIGNED NOT NULL
);

