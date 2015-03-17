CREATE TABLE airport (
name VARCHAR(256),
location VARCHAR(256),
designator VARCHAR(10) PRIMARY KEY
);

CREATE TABLE flight (
f_number VARCHAR(256),
duration VARCHAR(256), 
destination VARCHAR(256),
origin VARCHAR(256),
seat_capacity INT,
airline VARCHAR(65),
designator VARCHAR(10),
PRIMARY KEY (designator, f_number),
FOREIGN KEY (destination) REFERENCES airport(designator),
FOREIGN KEY (origin) REFERENCES airport(designator)
);

CREATE TABLE schedule (
arrival_time TIMESTAMP,
depart_time TIMESTAMP,
num_of_seats_avail INT,
price FLOAT,
designator VARCHAR(10),
flight_number VARCHAR(256),
FOREIGN KEY (designator, flight_number) REFERENCES flight(designator, f_number),
PRIMARY KEY (designator, flight_number, depart_time)
);

CREATE TABLE admin (
name VARCHAR(56) NOT NULL,
email VARCHAR(100) PRIMARY KEY,
password VARCHAR (100) NOT NULL
);