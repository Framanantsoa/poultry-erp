CREATE TABLE breeds (
	breed_id INT PRIMARY KEY,
	breed_name VARCHAR(50) NOT NULL,
	description TEXT
);
								   
CREATE TABLE batches (
	batch_id BIGINT AUTO_INCREMENT PRIMARY KEY,
	batch_code VARCHAR(10) NOT NULL UNIQUE,
	initial_effective INT UNSIGNED NOT NULL,
	initial_age_in_weeks INT UNSIGNED NOT NULL,
	arrival_date DATE NOT NULL,
	breed_id INT NOT NULL,
	total_cost DECIMAL(18,2),  -- Automatically filled
	parent_id BIGINT,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	deleted_at TIMESTAMP,
	FOREIGN KEY (breed_id) REFERENCES breeds(breed_id),
	FOREIGN KEY (parent_id) REFERENCES batches(batch_id)
);
								   
CREATE TABLE mortalities (
	mortality_id BIGINT PRIMARY KEY AUTO_INCREMENT,
	mortality_code VARCHAR(10) NOT NULL UNIQUE,
	batch_id BIGINT NOT NULL,
	date_of_death DATE NOT NULL, 
	effective INT UNSIGNED NOT NULL CHECK (effective > 0),
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (batch_id) REFERENCES batches(batch_id)
);
								   
CREATE TABLE egg_layings (
	laying_id BIGINT PRIMARY KEY AUTO_INCREMENT,
	laying_code VARCHAR(10) NOT NULL UNIQUE,
	batch_id BIGINT NOT NULL,
	laying_date DATE NOT NULL, 
	effective INT UNSIGNED NOT NULL CHECK (effective > 0),
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (batch_id) REFERENCES batches(batch_id)
);
								   
CREATE TABLE weight_trackings (
	tracking_id BIGINT PRIMARY KEY AUTO_INCREMENT,
	tracking_code VARCHAR(10) NOT NULL UNIQUE,
	tracking_date DATE NOT NULL,
	batch_id BIGINT NOT NULL,
	min_weight DECIMAL(15,2) UNSIGNED NOT NULL,
	max_weight DECIMAL(15,2) UNSIGNED NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (batch_id) REFERENCES batches(batch_id)
);
								   
CREATE TABLE feeds (
	feed_id INT PRIMARY KEY,
	feed_name VARCHAR(50) NOT NULL,
	description TEXT
);
								   
CREATE TABLE feed_costs (
	cost_id BIGINT PRIMARY KEY AUTO_INCREMENT,
	feed_id INT NOT NULL,
	start_date DATE,
	end_date DATE,
	cost_per_g DECIMAL(18,2) NOT NULL DEFAULT 0,
	FOREIGN KEY (feed_id) REFERENCES feeds(feed_id)
);
								   
CREATE TABLE feed_consumptions (
	consumption_id BIGINT PRIMARY KEY AUTO_INCREMENT,
	consumption_code VARCHAR(10) NOT NULL UNIQUE,
	batch_id BIGINT NOT NULL,
	quantity DECIMAL(15,2) NOT NULL CHECK (quantity > 0),  -- Unit: grams (g)
	week_number INT UNSIGNED NOT NULL CHECK (week_number > 0),
	feed_id INT NOT NULL,
	total_cost DECIMAL(18,2),  -- Automatically filled
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (batch_id) REFERENCES batches(batch_id),
	FOREIGN KEY (feed_id) REFERENCES feeds(feed_id)
);
								   
CREATE TABLE incubations (
	incubation_id BIGINT PRIMARY KEY AUTO_INCREMENT,
	incubation_date DATE NOT NULL,
	batch_id BIGINT NOT NULL,
	effective INT UNSIGNED NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (batch_id) REFERENCES batches(batch_id)
);
								   
CREATE TABLE egg_prices (
	price_id BIGINT PRIMARY KEY AUTO_INCREMENT,
	start_date DATE NOT NULL,
	end_date DATE,
	unit_price DECIMAL(18,2) NOT NULL DEFAULT 0,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
								   
CREATE TABLE chicken_prices (
	price_id BIGINT PRIMARY KEY AUTO_INCREMENT,
	start_date DATE NOT NULL,
	end_date DATE,
	min_age_in_weeks INT NOT NULL,
	breed_id INT NOT NULL,
	unit_price DECIMAL(18,2) NOT NULL DEFAULT 0,
	FOREIGN KEY (breed_id) REFERENCES breeds(breed_id),
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
								   
CREATE TABLE sale_types (
	sale_type_id INT PRIMARY KEY,
	sale_type_name VARCHAR(50) NOT NULL
);
								   
CREATE TABLE sales (
	sale_id BIGINT PRIMARY KEY AUTO_INCREMENT,
	sale_code VARCHAR(10) NOT NULL UNIQUE,
	sale_type_id INT NOT NULL,
	sale_date DATE NOT NULL,
	effective INT UNSIGNED NOT NULL,
	total_cost DECIMAL(18,2),  -- Automatically filled
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (sale_type_id) REFERENCES sale_types(sale_type_id)
);
