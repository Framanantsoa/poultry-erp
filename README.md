# Poultry Farming Management System

## Overview
A comprehensive ERP system for managing poultry farm operations, including flock management, health monitoring, production tracking, operational analytics, and system administration.

---

## Features

### 📦 Module 1: Flock & Production Management
#### 🐓 Batch Management
- Create and manage poultry batches
- Assign breeds to batches
- Track batch status (active/completed)
- View batch history

#### ⚖️ Weekly Weight Tracking
- Record average weight per batch each week
- View weight growth charts

#### 🩺 Health & Mortality Tracking
- Record daily/weekly deaths
- Track mortality rates
- View survival statistics
- Maintain health records and vaccination schedules

### 📦 Module 2: Production & Inventory
#### 🥚 Egg Production
- Record daily egg production
- Calculate production rates (Hen-Day, Hen-Housed)
- View production history

#### 🍽️ Feed Management
- Record weekly feed usage
- Track feed costs
- Calculate Feed Conversion Ratio (FCR)

#### 🥚 Incubation Management
- Manage incubation batches
- Track fertility rates
- Record hatching rates
- Monitor chick production

### 📦 Module 3: Analytics & Business Intelligence
#### 📈 Real-time Dashboard
- Key metrics at a glance
- Daily egg production
- Mortality rates
- Feed consumption
- Revenue vs costs

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
- **Frontend**: Vue.js 3
- **API**: RESTful
- **Backend**: Symfony 7.4
- **Database**: MariaDB 10
- **Authentication**: JWT

---

## Module structure
```text
poultry-erp/
├── backend/
│   └── src/
│       ├── modules/
│       │   ├── flock/           # Module 1: Flock & Production
│       │   ├── production/      # Module 2: Production & Inventory
│       │   ├── analytics/       # Module 3: Analytics & BI
│       │   └── system/          # Module 4: System Admin
│       ├── shared/              # Shared components
│       └── app.py
└── frontend/
    └── src/
        ├── modules/
        │   ├── flock/
        │   ├── production/
        │   ├── analytics/
        │   └── system/
        └── shared/
```

---

## Installation

### Prerequisites
- Python 3.9+ with pip
- MariaDB 10+
- Node.js 22+

### Setup for Backend (FastAPI)
```bash
cd backend/

# Create and activate virtual environment
python -m venv venv
source venv/bin/activate  # On Windows: venv\Scripts\activate

# Install dependencies
pip install -r requirements.txt

# Rename .env.example to .env
# Update database credentials in .env

# Create database
mysql -u root -p -e "CREATE DATABASE poultry_erp"

# Run SQL scripts (script1, script2, script3)

# Start server
uvicorn app:app --reload --host 0.0.0.0 --port 8000
```
---

### Setup for Frontend (Vue.js)
```bash
cd frontend/

# Install dependencies
npm install

# Rename env to .env

# Start server
npm run start
```

---

## API Documentation
Once the server is running, access the interactive API documentation at:
- Swagger UI: ```http://localhost:8000/docs```
- ReDoc: ```http://localhost:8000/redoc```
