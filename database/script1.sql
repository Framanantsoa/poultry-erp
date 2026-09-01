DROP DATABASE IF EXISTS poultry_erp;
CREATE DATABASE poultry_erp;
USE poultry_erp;


CREATE TABLE business_sequence(
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    sequence_key VARCHAR(50) NOT NULL UNIQUE,
    current_value BIGINT NOT NULL DEFAULT 0
);

CREATE TABLE roles(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(25) NOT NULL,
    description TEXT,
    deleted_at TIMESTAMP
);

CREATE TABLE users(
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    birthday DATE,
    phone VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(50) UNIQUE,
    employee_id VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(250) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP
);

CREATE TABLE permissions(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    deleted_at TIMESTAMP
);

-- User-Role relationship
CREATE TABLE user_roles (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    role_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (role_id) REFERENCES roles(id),
    CONSTRAINT uk_user_role UNIQUE KEY (user_id, role_id)  -- Prevent duplicate assignments
);

-- Role-Permission relationship
CREATE TABLE role_permissions (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id),
    FOREIGN KEY (permission_id) REFERENCES permissions(id),
    CONSTRAINT uk_role_permission UNIQUE KEY (role_id, permission_id)  -- Prevent duplicate permissions
);


CREATE TABLE breeds (
    id INT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    chick_cost DECIMAL(18,2) NOT NULL DEFAULT 0, -- Unit cost
    description TEXT
);

CREATE TABLE batches (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) NOT NULL UNIQUE,
    initial_effective INT UNSIGNED NOT NULL,
    initial_age_in_weeks INT UNSIGNED NOT NULL,
    arrival_date DATE NOT NULL,
    breed_id INT NOT NULL,
    total_cost DECIMAL(18,2),  -- Automatically filled
    parent_id BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (breed_id) REFERENCES breeds(id),
    FOREIGN KEY (parent_id) REFERENCES batches(id)
);

CREATE TABLE mortalities (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(10) NOT NULL UNIQUE,
    batch_id BIGINT NOT NULL,
    date_of_death DATE NOT NULL, 
    effective INT UNSIGNED NOT NULL CHECK (effective > 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (batch_id) REFERENCES batches(id)
);

CREATE TABLE egg_layings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(10) NOT NULL UNIQUE,
    batch_id BIGINT NOT NULL,
    laying_date DATE NOT NULL, 
    effective INT UNSIGNED NOT NULL CHECK (effective > 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (batch_id) REFERENCES batches(id)
);

CREATE TABLE weight_trackings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(10) NOT NULL UNIQUE,
    tracking_date DATE NOT NULL,
    batch_id BIGINT NOT NULL,
    min_weight DECIMAL(15,2) UNSIGNED NOT NULL,
    max_weight DECIMAL(15,2) UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (batch_id) REFERENCES batches(id)
);

CREATE TABLE feeds (
    id INT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE feed_costs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    feed_id INT NOT NULL,
    start_date DATE,
    end_date DATE,
    cost_per_g DECIMAL(18,2) NOT NULL DEFAULT 0,
    FOREIGN KEY (feed_id) REFERENCES feeds(id)
);

CREATE TABLE feed_consumptions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(10) NOT NULL UNIQUE,
    batch_id BIGINT NOT NULL,
    quantity DECIMAL(15,2) NOT NULL CHECK (quantity > 0),  -- Unit: grams (g)
    week_number INT UNSIGNED NOT NULL CHECK (week_number > 0),
    feed_id INT NOT NULL,
    total_cost DECIMAL(18,2),  -- Automatically filled
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (batch_id) REFERENCES batches(id),
    FOREIGN KEY (feed_id) REFERENCES feeds(id)
);

CREATE TABLE incubations (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    incubation_date DATE NOT NULL,
    batch_id BIGINT NOT NULL,
    effective INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (batch_id) REFERENCES batches(id)
);

CREATE TABLE egg_prices (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    start_date DATE NOT NULL,
    end_date DATE,
    unit_price DECIMAL(18,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE chicken_prices (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    start_date DATE NOT NULL,
    end_date DATE,
    min_age_in_weeks INT NOT NULL,
    breed_id INT NOT NULL,
    unit_price DECIMAL(18,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (breed_id) REFERENCES breeds(id)
);

CREATE TABLE sale_types (
    id INT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE sales (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(10) NOT NULL UNIQUE,
    type_id INT NOT NULL,
    sale_date DATE NOT NULL,
    effective INT UNSIGNED NOT NULL,
    total_cost DECIMAL(18,2),  -- Automatically filled
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (type_id) REFERENCES sale_types(id)
);

CREATE TABLE logs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    action_name VARCHAR(100) NOT NULL,
    table_name VARCHAR(100) NULL,
    last_value JSON NULL,
    new_value JSON NULL,
    user_id BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
