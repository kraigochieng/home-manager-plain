USE home_manager;
CREATE DATABASE home_manager;
-- Dropping Constraints
ALTER TABLE home DROP CONSTRAINT home_pk;
ALTER TABLE room DROP PRIMARY KEY;
ALTER TABLE item DROP PRIMARY KEY;

ALTER TABLE room DROP FOREIGN KEY room_fk_home;
ALTER TABLE item DROP FOREIGN KEY item_fk_room;

-- Dropping Tables
DROP TABLE IF EXISTS home;
DROP TABLE IF EXISTS room;
DROP TABLE IF EXISTS item;

CREATE TABLE home (
	id INT NOT NULL AUTO_INCREMENT,
    name TINYTEXT,
    
    CONSTRAINT home_pk PRIMARY KEY(id)
);

CREATE TABLE room (
	id INT NOT NULL AUTO_INCREMENT,
    home_id INT,
    name TINYTEXT,
    
    CONSTRAINT room_pk PRIMARY KEY(id),
    CONSTRAINT room_fk_home FOREIGN KEY(home_id) REFERENCES home(id)
);

CREATE TABLE item (
	id INT NOT NULL AUTO_INCREMENT,
    room_id INT,
    name TINYTEXT,
    unit_price DECIMAL(20,2),
    quantity INT,
    
    CONSTRAINT item_pk PRIMARY KEY(id),
    CONSTRAINT item_fk_room FOREIGN KEY(room_id) REFERENCES room(id)
);
