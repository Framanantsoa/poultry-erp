# Poultry Farming Management System

## Overview
Internal system for managing poultry farm operations, including flock management, health monitoring, production tracking, and operational analytics.

## Features

### 🔐 Authentication & Authorization
- Secure JWT-based login
- Role-based access control (Admin, Farm Manager, Worker)
- User permissions management

### 🐓 Batch Management
- Create and manage poultry batches
- Assign breeds to batches
- Track batch status (active/completed)
- View batch history

### ⚖️ Weekly Weight Tracking
- Record average weight per batch each week
- Track minimum and maximum weight
- View weight growth charts

### 🥚 Egg Production
- Record daily egg production
- Track egg quality (Extra, A, B, broken)
- Calculate production rates
- View production history

### 🍽️ Feed Consumption
- Record weekly feed usage
- Track feed costs
- Calculate feed conversion ratio (FCR)

### 🥚 Incubation Management
- Manage incubation batches
- Track fertility rates
- Record hatching rates
- Monitor chick production

### 📊 Mortality Tracking
- Record daily/weekly deaths
- Track mortality rates
- View survival statistics

### 📈 Analytics & Reports
- Dashboard with key metrics
- Filter statistics by date range
- View total livestock count
- Track egg production trends
- Monitor costs and revenue
- Export reports

### 🔮 Predictions
- Predict future egg production
- Estimate feed consumption
- Forecast batch performance
- Identify trends from historical data

---

## Tech Stack
- **Frontend**: Vue.js 3
- **API**: RESTful
- **Backend**: Symfony 7.4
- **Database**: MariaDB 10

## Installation

### Prerequisites
- PHP 8.4+
- Composer
- MariaDB 10+
- Node.js 22+

### Setup for Symfony
```bash
cd backend/

# Install dependencies
composer install

# Rename env to .env
# Update database credentials in .env

# Create database
php bin/console doctrine:database:create

# Generate JWT keys
php bin/console lexik:jwt:generate-keypair

# Start server
php -S localhost:8000 -t public/
```

### Setup for Vue.js
```bash
cd frontend/

# Install dependencies
npm install

# Rename env to .env

# Start server
npm run start
```
