-- username: xeniokun
-- password: Try1ngFaster_

DROP TABLE IF EXISTS Client;
CREATE TABLE Client
(
  client_id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  name varchar(255),
  surname varchar(255),
  email varchar(255),
  phone_number varchar(255),
  PRIMARY KEY (client_id)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Drivers;
CREATE TABLE Drivers
(
  driver_id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  surname varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  phone_number varchar(255) NOT NULL,
  PRIMARY KEY (driver_id)
) ENGINE=InnoDB;

INSERT INTO Drivers (name, surname, email, phone_number)
VALUES ("Sarah", "Johnson", "sarah@gmail.com", "+37289382939");
INSERT INTO Drivers (name, surname, email, phone_number)
VALUES ("David", "Peterson", "david@gmail.com", "+37289382939");
INSERT INTO Drivers (name, surname, email, phone_number)
VALUES ("Diego", "Brown", "diego@gmail.com", "+37289382939");
INSERT INTO Drivers (name, surname, email, phone_number)
VALUES ("Mary", "Wolf", "mary@gmail.com", "+37289382939");

DROP TABLE IF EXISTS Orders;
CREATE TABLE Orders
(
  order_id int(11) NOT NULL AUTO_INCREMENT,
  date DATE NOT NULL,
  time_slot varchar(255) NOT NULL,
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
  FOREIGN KEY (client_id) REFERENCES Client(client_id)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Bulk_items;
CREATE TABLE Bulk_items
(
  number_of_items int(11) NOT NULL,
  total_weight int(11) NOT NULL,
  order_id int(11) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES Orders(order_id)
) ENGINE=InnoDB;