CREATE DATABASE apokalipsa;

USE DATABASE apokalipsa;

CREATE USER administrator IDENTIFIED BY 'p4ssw0rd';

GRANT ALL PRIVILEGES ON apokalipsa.* TO administrator;