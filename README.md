# TUKIR – Student Management System

A web-based student management system developed using PHP and MySQL. The application provides an administrator interface to manage student records through a simple and user-friendly dashboard.

## Features

- **Admin Authentication** – Login and logout functionality.
- **View Student Data** – Display student records in a dashboard.
- **Add Student** – Register new student information.
- **Edit Student** – Update existing student records.
- **Delete Student** – Delete student records with a confirmation dialog.
- **Print Student Data** – Generate a print-friendly student data page.
- **Input Validation** – Validate user input before storing it in the database.
- **Database Integration** – Store and retrieve student information using MySQL.

## Tech Stack

- **Backend:** PHP
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript
- **Database Connection:** MySQLi

## Project Structure

```text
tukir-student-management-system/
│
├── database/
│   └── schema.sql
│
├── .gitignore
├── config.example.php
├── login06931.php
├── validasi06931.php
├── homeadmin06931.php
├── tambahdata06931.php
├── edit_mhs06931.php
├── hapus06931.php
├── cetak_mahasiswa06931.php
└── logout06931.php
```

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/nalendra-wp/tukir-student-management-system.git
```

### 2. Move the Project

Place the project folder inside your local web server directory, such as `htdocs` when using XAMPP.

### 3. Create the Database

Import `database/schema.sql` into MySQL using phpMyAdmin or another MySQL client.

### 4. Configure the Database Connection

Create a copy of `config.example.php` and rename it to:

```text
config06931.php
```

Update the database credentials according to your local MySQL configuration.

### 5. Configure Administrator Account

Create an administrator account in the `admin06931` table.

The password should be stored using PHP's `password_hash()` function. Legacy MD5 password hashes are also supported for compatibility with the original database.

### 6. Run the Application

Start Apache and MySQL, then open:

```text
http://localhost/tukir-student-management-system/login06931.php
```

## Database

The application uses two main tables:

- `admin06931` – Stores administrator account information.
- `mahasiswa06931` – Stores student records, including NIM, name, gender, address, email, city, and GPA (IPK).

## Security Considerations

- Prepared statements are used for database operations.
- User input is validated before processing.
- Output is escaped to reduce the risk of cross-site scripting (XSS).
- Session-based authentication protects administrator pages.
- CSRF tokens are used for protected operations.
- Database credentials are excluded from version control.

## Project Purpose

This project was developed as an academic web development project to implement fundamental concepts of PHP programming, MySQL database management, CRUD operations, and web application security.

## Author

**Nalendra Whisnu Pinilih**

- GitHub: [@nalendra-wp](https://github.com/nalendra-wp)
