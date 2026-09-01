# Poultry Farming Management System

## Overview
A comprehensive ERP system for managing poultry farm operations, including flock management, health monitoring, production tracking, operational analytics, and system administration.

---

## Features

### 🔐 Security
- Role-based access control (Admin, Farm Manager, Worker)
- User permissions management
- Audit logs


### 🐓 Batch Management
- Create and manage poultry batches
- Assign breeds to batches
- Track batch status (active/completed)
- View batch history

#### ⚖️ Weekly Weight Tracking
- Record average weight per batch each week
- Track minimum and maximum weight

#### 🩺 Health & Mortality Tracking
- Record daily/weekly deaths
- Track mortality rates
- View survival statistics
- Maintain health records and vaccination schedules

### 📦 Module 2: Production & Inventory
#### 🥚 Egg Production
- Record daily egg production
- Calculate production rates
- View production history

#### 🍽️ Feed Management
- Record weekly feed usage
- Track feed costs
- Calculate Feed Conversion Ratio (FCR)

#### 🥚 Incubation Management
- Manage incubation batches
- Track fertility rates
- Record hatching rates

### 📊 Mortality Tracking
- Record daily deaths

### 🐓 Egg & Chicken sales
- Record daily egg sales
- Record daily chicken sales

#### 📊 Reports
- Production reports (daily/weekly/monthly)
- Financial reports
- Batch performance comparison
- Export capabilities (PDF, Excel, CSV)

#### 🔮 Predictions
- Predict future egg production
- Estimate feed consumption
- Forecast batch performance
- Identify trends from historical data

### 📦 Module 4: System Administration
#### 🔐 Authentication & Authorization
- Secure JWT-based login
- Role-based access control (Admin, Farm Manager, Worker, Viewer)
- Granular user permissions management

#### 👥 User & Role Management
- Create, update, delete users
- Assign and manage roles
- Activity logging and audit trails

#### ⚙️ System Settings
- General configuration
- Notification setup
- Data backup
- System health monitoring

---

## Tech Stack
- **Frontend**: Vue.js
- **Backend**: Laravel 12 + Inertia
- **Database**: MariaDB 10
