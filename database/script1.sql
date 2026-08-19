-- CREATE DATABASE poultry_erp;

CREATE TABLE business_sequence(
    sequence_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    sequence_key VARCHAR(50) NOT NULL UNIQUE,
    current_value BIGINT NOT NULL DEFAULT 0
);

CREATE TABLE roles(
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(25) NOT NULL,
    description TEXT
);

CREATE TABLE users(
    user_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    birthday DATE,
    phone VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(50) UNIQUE,
    employee_id VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(250) NOT NULL
);

CREATE TABLE permissions(
    permission_id INT AUTO_INCREMENT PRIMARY KEY,
    permission_name VARCHAR(100) NOT NULL,
    description TEXT
);

-- User-Role relationship
CREATE TABLE user_roles (
    user_role_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    role_id INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    assigned_by BIGINT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(user_id) ON DELETE CASCADE,
    CONSTRAINT uk_user_role UNIQUE KEY (user_id, role_id)  -- Prevent duplicate assignments
);

-- Role-Permission relationship
CREATE TABLE role_permissions (
    role_permission_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    assigned_by BIGINT,
    FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(permission_id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(user_id) ON DELETE CASCADE,
    CONSTRAINT uk_role_permission UNIQUE KEY (role_id, permission_id)  -- Prevent duplicate permissions
);

-- Denormalization
CREATE TABLE user_permissions (
    user_permission_id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    permission_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(permission_id) ON DELETE CASCADE,
    CONSTRAINT uk_user_permission UNIQUE KEY (user_id, permission_id)
);

