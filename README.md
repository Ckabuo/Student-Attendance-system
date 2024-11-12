
# Student Attendance Management System

## Overview

The Student Attendance Management System is a web-based application designed to manage and track student attendance. It allows users to record attendance, generate reports, and analyze attendance patterns over specific periods.

## Features

- Record student attendance
- View attendance records by date range
- Generate attendance reports
- User authentication and session management
- Responsive design for various devices

## Technologies Used

- **Frontend:** HTML, CSS, JavaScript, Bootstrap
- **Backend:** PHP
- **Database:** MySQL
- **Server:** WampServer

## Prerequisites

- WampServer installed on your machine
- PHP 7.0 or higher
- MySQL 5.7 or higher

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/Ckabuo/Student-Attendance-system.git
   ```

2. **Navigate to the project directory:**

   ```bash
   cd Student-Attendance-system
   ```

3. **Import the database:**

   - Open phpMyAdmin in your browser (`http://localhost/phpmyadmin`).
   - Create a new database named `attendance`.
   - Import the `database.sql` file located in the project directory into the `attendance` database.

4. **Configure the database connection:**

   - Open `config1.php` in the project directory.
   - Update the database configuration settings with your MySQL credentials.

     ```php
     $host = 'localhost';
     $dbname = 'attendance';
     $username = 'root';
     $password = '';
     ```

5. **Start WampServer:**

   - Open WampServer and start the Apache and MySQL services.

6. **Access the application:**

   - Open your browser and navigate to `http://localhost/Student-Attendance-Management-System/index.php`.

## Usage

1. **Login:**

   - Use the provided credentials to log in to the system.

2. **Record Attendance:**

   - Navigate to the attendance recording page and select the subject, date, and mark attendance for students.

3. **Generate Reports:**

   - Go to the reports section, select the subject and date range, and view the attendance report.

## Troubleshooting

- Ensure that WampServer is running and both Apache and MySQL services are started.
- Verify that the database configuration in `config1.php` is correct.
- Check the browser console for any errors and resolve them accordingly.

## Contributions

Contributions are welcome! Feel free to open an issue or submit a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
