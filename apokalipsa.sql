-- stworz baze apokalipsa
CREATE DATABASE "apokalipsa";

-- uzyj bazy apokalipsa
\c apokalipsa;

-- stworz tabele zombies jezeli nie istnieje
CREATE TABLE IF NOT EXISTS zombies (
    ZombieAmount SERIAL PRIMARY KEY
);

-- wprowadzenie danych do tabeli zombies
INSERT INTO zombies (ZombieAmount) VALUES (100);

-- stworz tabele resources jezeli nie istnieje
CREATE TABLE IF NOT EXISTS resources (
    FoodAmount INT,
    WeaponsAmount INT,
    MedicalSuppliesAmount INT
);

-- wprowadzenie danych do tabeli resources
INSERT INTO resources (FoodAmount, WeaponsAmount, MedicalSuppliesAmount) VALUES (600, 1000, 2000);

-- stworz tabele humans jezeli nie istnieje
CREATE TABLE IF NOT EXISTS humans (
    HumanAmount SERIAL PRIMARY KEY,
    HumanHP INT,
    HumanFood INT,
    HumanDef INT
);

-- wprowadzenie danych do tabeli humans
INSERT INTO humans (HumanAmount, HumanHP, HumanFood, HumanDef) VALUES (100, 100, 80, 25);
