CREATE DATABASE "apokalipsa";
\c apokalipsa;

CREATE TABLE IF NOT EXISTS humans (
    HumanID SERIAL PRIMARY KEY,
    HumanFullName VARCHAR(64) NOT NULL,
    HumanHP INT
);

-- data insert
INSERT INTO humans (HumanFullName, HumanHP) VALUES ('John Doe', 100);
INSERT INTO humans (HumanFullName, HumanHP) VALUES ('David Smith', 100);

CREATE TABLE IF NOT EXISTS zombies (
    ZombieID SERIAL PRIMARY KEY,
    ZombieFullName VARCHAR(64) NOT NULL,
    ZombieHP INT
);

INSERT INTO zombies (ZombieFullName, ZombieHP) VALUES ('Michael Miller', 100);
INSERT INTO zombies (ZombieFullName, ZombieHP) VALUES ('Daniel Wilson', 100);

CREATE TABLE IF NOT EXISTS resources (
    ResourceID SERIAL PRIMARY KEY,
    Nutritions INT,
    DMG INT,
    UsesLeft INT
);

INSERT INTO resources (Nutritions, DMG, UsesLeft) VALUES (12, 0, 1);
INSERT INTO resources (Nutritions, DMG, UsesLeft) VALUES (0, 18, 20);