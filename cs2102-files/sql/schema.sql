CREATE TABLE airport (
name VARCHAR(256) NOT NULL UNIQUE,
location VARCHAR(256) NOT NULL,
designator VARCHAR(10) PRIMARY KEY
);

CREATE TABLE flight (
f_number VARCHAR(256) PRIMARY KEY,
duration VARCHAR(256),
destination VARCHAR(10) REFERENCES airport(designator),
origin VARCHAR(10) REFERENCES airport(designator),
seat_capacity INT CHECK(seat_capacity > 0)
);

CREATE TABLE schedule (
arrival_time TIMESTAMP NOT NULL,
depart_time TIMESTAMP,
num_of_seats_avail INT NOT NULL,
price FLOAT NOT NULL,
flight_number VARCHAR(256) REFERENCES flight(f_number),
PRIMARY KEY (flight_number, depart_time),
CHECK (depart_time < arrival_time)
);

CREATE TABLE booking (
id INT PRIMARY KEY,
c_person VARCHAR (256) NOT NULL,
c_number INT NOT NULL,
c_email VARCHAR(256) UNIQUE,
flight_number VARCHAR(256),
depart_time TIMESTAMP,
FOREIGN KEY (flight_number, depart_time) REFERENCES schedule(flight_number, depart_time)
);

CREATE TABLE passenger (
passport_number VARCHAR(256) PRIMARY KEY,
type VARCHAR(8) DEFAULT 'Adult',
title VARCHAR(20),
first_name VARCHAR (64)NOT NULL,
last_name VARCHAR (64) NOT NULL
);

CREATE TABLE booking_passenger(
booking_id INT REFERENCES booking(id),
passenger VARCHAR(256) REFERENCES passenger(passport_number),
PRIMARY KEY (booking_id, passenger)
);

CREATE TABLE admin (
name VARCHAR(56) NOT NULL,
email VARCHAR(100) PRIMARY KEY,
password VARCHAR (100) NOT NULL
);