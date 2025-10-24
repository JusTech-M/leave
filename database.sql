INSERT INTO units (unit_name) VALUES
('ICT Unit'),
('Finance Unit'),
('HR Unit');


===================================== Database table ================================================

CREATE DATABASE leave_management;
USE leave_management;

-- Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    surname VARCHAR(100) NOT NULL,
    othername VARCHAR(100) NOT NULL,
    ref_no VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('staff','program_coordinator','head','admin','director') NOT NULL DEFAULT 'staff',
    unit_id INT NULL,
    level ENUM('snr', 'jnr_5&6', 'jnr_1-4', 'admin', 'director') NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE SET NULL
);

-- Units
CREATE TABLE units (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unit_name VARCHAR(100) NOT NULL
);

-- Leave Applications
CREATE TABLE leave_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    leave_type ENUM('Casual Leave','Annual Leave') NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    working_days INT NOT NULL,
    reason TEXT NOT NULL,
    relieving_officer VARCHAR(100) NOT NULL,
    relieving_officer_email VARCHAR(100) NOT NULL,
    relieving_officer_status ENUM('Pending','Accepted','Declined') DEFAULT 'Pending',
    relieving_officer_note TEXT NULL,

    -- Annual leave extra fields
    employee_email VARCHAR(100) NULL,
    contact_address VARCHAR(255) NULL,
    contact_phone VARCHAR(50) NULL,
    outstanding_assignment TEXT NULL,
    resumption_date DATE NULL,

    -- Approval workflow
    status ENUM('Pending Head Approval','Pending Admin Approval','Pending Director Approval','Approved','Rejected') DEFAULT 'Pending Head Approval',
    hod_recommendation TEXT NULL,
    admin_note TEXT NULL,
    director_note TEXT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);




ALTER TABLE users MODIFY role ENUM("staff", "progam_coordinator", "head", "admin", "deputy_director", "director");

ALTER TABLE recall 
ADD COLUMN hod_recommendation TEXT DEFAULT NULL;



