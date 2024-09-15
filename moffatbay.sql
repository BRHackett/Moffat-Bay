-- Create new, shared user
CREATE USER "admin"@"localhost" IDENTIFIED BY "pass";

-- Create database
CREATE DATABASE moffatbay;

-- Grant user privilege to the new user
GRANT ALL PRIVILEGES ON moffatbay.* TO "admin"@"localhost";

-- Switch to the new database
USE moffatbay;

-- Create 'User' table
CREATE TABLE User (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address VARCHAR(255),
    city VARCHAR(100),
    state VARCHAR(100),
    zip_code VARCHAR(20),
    country VARCHAR(100)
);

-- Create 'Login' table
CREATE TABLE Login (
    login_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    last_login DATETIME,
    login_attempts INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE
);

-- Create 'Rooms' table to hold room inventory
CREATE TABLE Rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_category VARCHAR(50) NOT NULL,  -- e.g., Standard, Deluxe, Suite
    room_type VARCHAR(50) NOT NULL,      -- e.g., Single King, Single Queen
    total_rooms INT NOT NULL,            -- Total rooms of this type
    available_rooms INT NOT NULL         -- Available rooms for booking
);

-- Create 'Reservations' table
CREATE TABLE Reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    reservation_date DATE NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status VARCHAR(50) NOT NULL,
    payment_status VARCHAR(50),
    room_id INT,  -- Foreign key to reference the Rooms table
    notes TEXT,
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES Rooms(room_id)
);

-- Insert initial room data with available rooms
INSERT INTO Rooms (room_category, room_type, total_rooms, available_rooms)
VALUES 
    ('Standard', 'Single King', 40, 40),
    ('Standard', 'Single Queen', 40, 40),
    ('Standard', 'Double Queen', 40, 40),
    ('Deluxe', 'Single King', 40, 40),
    ('Deluxe', 'Single Queen', 40, 40),
    ('Deluxe', 'Double Queen', 40, 40),
    ('Suite', '1 Room', 20, 20),
    ('Suite', '2 Room', 20, 20);

-- Create a trigger to update room availability on new reservations
DELIMITER $$

CREATE TRIGGER update_room_availability
AFTER INSERT ON Reservations
FOR EACH ROW
BEGIN
    -- Decrement available rooms for the reserved room type
    UPDATE Rooms
    SET available_rooms = available_rooms - 1
    WHERE room_id = NEW.room_id;
END; $$

DELIMITER ;

-- Create a trigger to update room availability on cancelled reservations
DELIMITER $$

CREATE TRIGGER handle_reservation_cancellation
AFTER UPDATE ON Reservations
FOR EACH ROW
BEGIN
    -- Check if the reservation status is changed to 'Cancelled'
    IF NEW.status = 'Cancelled' AND OLD.status != 'Cancelled' THEN
        -- Increment the available_rooms for the room associated with the cancelled reservation
        UPDATE Rooms
        SET available_rooms = available_rooms + 1
        WHERE room_id = NEW.room_id;
    END IF;
END $$

DELIMITER ;

-- create a trigger to ensure available rooms doesn't exceed total rooms before update
DELIMITER $$

CREATE TRIGGER prevent_exceeding_total_rooms_update
BEFORE UPDATE ON Rooms
FOR EACH ROW
BEGIN
    -- Check if the new available_rooms value would exceed total_rooms
    IF NEW.available_rooms > NEW.total_rooms THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error: available_rooms cannot exceed total_rooms.';
    END IF;
END $$

DELIMITER ;

-- create a trigger that ensures the validation also applies when new records are inserted
DELIMITER $$

CREATE TRIGGER prevent_exceeding_total_rooms_insert
BEFORE INSERT ON Rooms
FOR EACH ROW
BEGIN
    -- Check if the initial available_rooms value would exceed total_rooms
    IF NEW.available_rooms > NEW.total_rooms THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error: available_rooms cannot exceed total_rooms.';
    END IF;
END $$

DELIMITER ;


-- Insert entries into 'User' table
INSERT INTO User (first_name, last_name, email, phone, address, city, state, zip_code, country)
VALUES 
    ('John', 'Avery', 'johnavery@gmail.com', '0981234567', '123 Apple Street', 'Seattle', 'WA', '98101', 'USA'),
    ('Patricia', 'Smith', 'patriciasmith@gmail.com', '8768901234', '456 Berry Avenue', 'Portland', 'OR', '97209', 'USA'),
    ('Bobby', 'Walker', 'bobwalker@gmail.com', '5435678901', '789 West Road', 'San Francisco', 'CA', '94105', 'USA');

-- Insert entries into 'Login' table
INSERT INTO Login (user_id, username, password_hash, last_login, login_attempts)
VALUES 
    (1, 'averyjohn', SHA2('password123', 256), '2024-08-01 12:34:56', 0),
    (2, 'patsmith', SHA2('patpats123', 256), '2024-08-05 09:21:10', 1),
    (3, 'walkerbob', SHA2('bobbyb120', 256), '2024-08-10 16:45:30', 2);

-- Retrieve room_id for Standard Single King
SET @standard_single_king_id = (SELECT room_id FROM Rooms WHERE room_category = 'Standard' AND room_type = 'Single King');

-- Retrieve room_id for Standard Single Queen
SET @standard_single_queen_id = (SELECT room_id FROM Rooms WHERE room_category = 'Standard' AND room_type = 'Single Queen');

-- Retrieve room_id for Standard Double Queen
SET @standard_double_queen_id = (SELECT room_id FROM Rooms WHERE room_category = 'Standard' AND room_type = 'Double Queen');

-- Retrieve room_id for Deluxe Single King
SET @deluxe_single_king_id = (SELECT room_id FROM Rooms WHERE room_category = 'Deluxe' AND room_type = 'Single King');

-- Retrieve room_id for Deluxe Single Queen
SET @deluxe_single_queen_id = (SELECT room_id FROM Rooms WHERE room_category = 'Deluxe' AND room_type = 'Single Queen');

-- Retrieve room_id for Deluxe Double Queen
SET @deluxe_double_queen_id = (SELECT room_id FROM Rooms WHERE room_category = 'Deluxe' AND room_type = 'Double Queen');

-- Retrieve room_id for Suite 1 Room
SET @suite_1_room_id = (SELECT room_id FROM Rooms WHERE room_category = 'Suite' AND room_type = '1 Room');

-- Retrieve room_id for Suite 2 Room
SET @suite_2_room_id = (SELECT room_id FROM Rooms WHERE room_category = 'Suite' AND room_type = '2 Room');


-- Insert reservations using the pre-fetched room_id values
INSERT INTO Reservations (user_id, reservation_date, start_date, end_date, status, payment_status, room_id, notes)
VALUES 
    (1, '2024-08-15', '2024-10-20', '2024-10-25', 'Confirmed', 'Paid', @deluxe_single_king_id, 'Requesting early check-in'),
    (2, '2024-08-18', '2024-10-22', '2024-10-24', 'Pending', 'Unpaid', @standard_single_queen_id, 'Requires accommodations'),
    (3, '2024-08-20', '2024-09-25', '2024-09-30', 'Confirmed', 'Paid', @suite_1_room_id, 'Cancelled due to personal reasons');

-- Cancel the last entry
UPDATE Reservations
SET status = 'Cancelled', payment_status = 'Refunded'
WHERE reservation_id = 3;
