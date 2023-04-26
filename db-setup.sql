DROP TABLE IF EXISTS Bulk_items;
DROP TABLE IF EXISTS driver_schedule;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS Drivers;
DROP TABLE IF EXISTS Sessions;
DROP TABLE IF EXISTS Clients;
CREATE TABLE Clients
(
  client_id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  name varchar(255),
  surname varchar(255),
  email varchar(255),
  phone_number varchar(255),
  street varchar(255),
  house varchar(255),
  postcode int(5),
  PRIMARY KEY (client_id),
  UNIQUE KEY username_unique (username)
) ENGINE=InnoDB;

CREATE TABLE Sessions
(
  session_id int(11) NOT NULL AUTO_INCREMENT,
  token varchar(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  client_id int(11) NOT NULL,
  ip varchar(255) NOT NULL,
  UNIQUE KEY token_unique (token),
  PRIMARY KEY (session_id),
  FOREIGN KEY (client_id) REFERENCES Clients(client_id)
) ENGINE=InnoDB;

CREATE TABLE Drivers
(
  driver_id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  surname varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  phone_number varchar(255) NOT NULL,
  PRIMARY KEY (driver_id)
) ENGINE=InnoDB;

CREATE TABLE Orders
(
  order_id int(11) NOT NULL AUTO_INCREMENT,
  date DATE NOT NULL,
  time_slot varchar(255) NOT NULL,
  status VARCHAR(255) NOT NULL DEFAULT 'Ongoing',
  order_type varchar(255) NOT NULL,
  price float(11, 2) NOT NULL,
  comment varchar(255),
  street varchar(255) NOT NULL,
  house varchar(255) NOT NULL,
  postcode int(5) NOT NULL,
  driver_id int(11) NOT NULL,
  client_id int(11) NOT NULL,
  PRIMARY KEY (order_id),
  FOREIGN KEY (driver_id) REFERENCES Drivers(driver_id),
  FOREIGN KEY (client_id) REFERENCES Clients(client_id)
) ENGINE=InnoDB;

CREATE TABLE Bulk_items
(
  bulk_items_id int(11) NOT NULL AUTO_INCREMENT,
  number_of_items int(11) NOT NULL,
  total_weight varchar(255) NOT NULL,
  order_id int(11) NOT NULL,
  PRIMARY KEY (bulk_items_id),
  FOREIGN KEY (order_id) REFERENCES Orders(order_id)
) ENGINE=InnoDB;

INSERT INTO Drivers (name, surname, email, phone_number)
VALUES ("Sarah", "Johnson", "sarah@gmail.com", "+37289382939");
INSERT INTO Drivers (name, surname, email, phone_number)
VALUES ("David", "Peterson", "david@gmail.com", "+37289382939");
INSERT INTO Drivers (name, surname, email, phone_number)
VALUES ("Diego", "Brown", "diego@gmail.com", "+37289382939");
INSERT INTO Drivers (name, surname, email, phone_number)
VALUES ("Mary", "Wolf", "mary@gmail.com", "+37289382939");

CREATE TABLE driver_schedule (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date DATE NOT NULL,
  time_slot VARCHAR(255) NOT NULL,
  driver_id INT,
  order_id INT,
  FOREIGN KEY (driver_id) REFERENCES Drivers(driver_id),
  FOREIGN KEY (order_id) REFERENCES Orders(order_id)
);

INSERT INTO driver_schedule (date, time_slot, driver_id)
SELECT date, time_slot, driver_id
FROM (
  SELECT DATE('2023-04-25') + INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS date
  FROM (
    SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
    SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
    SELECT 8 UNION ALL SELECT 9
  ) AS a
  CROSS JOIN (
    SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
    SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
    SELECT 8 UNION ALL SELECT 9
  ) AS b
  CROSS JOIN (
    SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
    SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL
    SELECT 8 UNION ALL SELECT 9
  ) AS c
) AS date_range
CROSS JOIN (
  SELECT '10:00' AS time_slot UNION ALL SELECT '11:00' UNION ALL SELECT '12:00' UNION ALL SELECT '13:00' UNION ALL SELECT '14:00'
) AS time_slots
CROSS JOIN (
  SELECT 1 AS driver_id UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
) AS drivers
WHERE date <= DATE('2024-04-25');
