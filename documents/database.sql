CREATE DATABASE IF NOT EXISTS way2;

USE way2;

CREATE TABLE IF NOT EXISTS LegacyImport(
    id INT NOT NULL AUTO_INCREMENT,
    imported BOOLEAN NOT NULL DEFAULT 0,
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Branch(
    id INT NOT NULL AUTO_INCREMENT,
    description VARCHAR(255) NOT NULL,
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS City(
    id INT NOT NULL AUTO_INCREMENT,
    description VARCHAR(255) NOT NULL,
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS State(
    id INT NOT NULL AUTO_INCREMENT,
    description VARCHAR(255) NOT NULL,
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Enterprise(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    contact VARCHAR(255) NOT NULL,
    Dealership BOOLEAN DEFAULT 0,
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    City INT,
    State INT,
    Branch INT,
    PRIMARY KEY (id),
    CONSTRAINT FK_EnterpriseCity FOREIGN KEY (City) REFERENCES City(id),
    CONSTRAINT FK_EnterpriseState FOREIGN KEY (State) REFERENCES State(id),
    CONSTRAINT FK_EnterpriseBranch FOREIGN KEY (Branch) REFERENCES Branch(id)
);

ALTER TABLE LegacyImport ADD INDEX (id);
ALTER TABLE Branch ADD INDEX (id);
ALTER TABLE City ADD INDEX (id);
ALTER TABLE State ADD INDEX (id);
ALTER TABLE Enterprise ADD INDEX (id);
