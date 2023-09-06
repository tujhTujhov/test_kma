CREATE DATABASE IF NOT EXISTS test_kma;

USE test_kma;

CREATE TABLE urls (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      url VARCHAR(255) NOT NULL,
                      created_time INT NOT NULL,
                      content_length INT NOT NULL
);