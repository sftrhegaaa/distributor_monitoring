-- Tabel Region
CREATE TABLE regions (
    id INT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    area ENUM('West', 'East') NOT NULL
);

-- Data Region (sesuai soal)
INSERT INTO regions (id, name, area) VALUES
(3811, 'REGION I', 'West'),
(3812, 'REGION II', 'West'),
(3813, 'REGION III', 'West'),
(3814, 'REGION IV', 'West'),
(3815, 'REGION V', 'East'),
(3816, 'REGION VI', 'East'),
(3817, 'REGION VII', 'East');

-- Tabel Distributor
CREATE TABLE distributors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) NOT NULL,
    name VARCHAR(100) NOT NULL,
    region_id INT NOT NULL,
    owner VARCHAR(100),
    address VARCHAR(255),
    FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE
);

-- Tabel Territory
CREATE TABLE territories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) NOT NULL,
    name VARCHAR(100) NOT NULL,
    distributor_id INT NOT NULL,
    FOREIGN KEY (distributor_id) REFERENCES distributors(id) ON DELETE CASCADE
);
