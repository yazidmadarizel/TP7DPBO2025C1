CREATE DATABASE db_fitness;
USE db_fitness;

CREATE TABLE equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    status ENUM('Available', 'Under Maintenance', 'Out of Order') DEFAULT 'Available',
    purchase_date DATE NOT NULL,
    last_maintenance DATE
);

CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(15),
    membership_type ENUM('Basic', 'Standard', 'Premium') DEFAULT 'Basic',
    join_date DATE NOT NULL,
    expiry_date DATE NOT NULL
);

CREATE TABLE trainers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(15),
    specialization VARCHAR(100) NOT NULL
);

CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    trainer_id INT NOT NULL,
    session_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    status ENUM('Scheduled', 'Completed', 'Cancelled') DEFAULT 'Scheduled',
    notes TEXT,
    FOREIGN KEY (member_id) REFERENCES members(id),
    FOREIGN KEY (trainer_id) REFERENCES trainers(id)
);

-- Insert sample data
INSERT INTO equipment (name, category, status, purchase_date, last_maintenance) VALUES
('Treadmill #1', 'Cardio', 'Available', '2024-01-10', '2024-03-15'),
('Bench Press #1', 'Strength', 'Available', '2023-11-05', '2024-02-20'),
('Elliptical #1', 'Cardio', 'Under Maintenance', '2023-08-15', '2024-04-01');

INSERT INTO members (name, email, phone, membership_type, join_date, expiry_date) VALUES
('John Smith', 'john@example.com', '555-123-4567', 'Premium', '2023-10-01', '2024-10-01'),
('Sarah Johnson', 'sarah@example.com', '555-234-5678', 'Standard', '2024-01-15', '2025-01-15');

INSERT INTO trainers (name, email, phone, specialization) VALUES
('Mike Wilson', 'mike@example.com', '555-345-6789', 'Strength Training'),
('Lisa Brown', 'lisa@example.com', '555-456-7890', 'Cardio & HIIT');

INSERT INTO sessions (member_id, trainer_id, session_date, start_time, end_time, status, notes) VALUES
(1, 1, '2024-04-15', '10:00:00', '11:00:00', 'Completed', 'Strength training session focused on upper body.'),
(2, 2, '2024-04-17', '15:30:00', '16:30:00', 'Scheduled', 'Cardio and endurance training planned.');
