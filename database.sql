creat database taghazout_surf;
use taghazout_surf;


CREATE TABLE users (
    id         INT          AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    role       ENUM('manager', 'surfer') NOT NULL DEFAULT 'surfer',
    created_at DATETIME     DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students (
    id      INT          AUTO_INCREMENT PRIMARY KEY,
    user_id INT          NOT NULL UNIQUE,
    country VARCHAR(100) NOT NULL,
    level   ENUM('Beginner', 'Intermediate', 'Advanced') NOT NULL DEFAULT 'Beginner',

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE lessons (
    id           INT          AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(150) NOT NULL,
    coach        VARCHAR(100) NOT NULL,
    scheduled_at DATETIME     NOT NULL,
    created_at   DATETIME     DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE enrollments (
    id             INT      AUTO_INCREMENT PRIMARY KEY,
    student_id     INT      NOT NULL,
    lesson_id      INT      NOT NULL,
    payment_status ENUM('Paid', 'Pending') NOT NULL DEFAULT 'Pending',
    enrolled_at    DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id)  REFERENCES lessons(id)  ON DELETE CASCADE,

    UNIQUE (student_id, lesson_id)
);

--// insert seed data 
INSERT INTO users (name, email, password, role) VALUES
('Manager Omar',   'omar@surf.ma',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'manager'),
('Surfer Yassine', 'yassine@surf.ma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'surfer'),
('Surfer Amina',   'amina@surf.ma',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'surfer'),
('Surfer Carlos',  'carlos@surf.ma',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'surfer');
-- This hashed password = password123 for all test accounts

INSERT INTO students (user_id, country, level) VALUES
(2, 'Morocco', 'Beginner'),
(3, 'Morocco', 'Intermediate'),
(4, 'Spain',   'Advanced');

INSERT INTO lessons (title, coach, scheduled_at) VALUES
('Morning Beginners',      'Coach Hassan', '2026-04-05 08:00:00'),
('Afternoon Intermediate', 'Coach Sara',   '2026-04-05 14:00:00'),
('Sunset Advanced',        'Coach Hassan', '2026-04-06 17:00:00');

INSERT INTO enrollments (student_id, lesson_id, payment_status) VALUES
(1, 1, 'Paid'),
(2, 2, 'Pending'),
(3, 3, 'Paid'),
(1, 2, 'Pending');