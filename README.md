# Public Service Request System (Mini eCitizen-style)

A beginner-friendly PHP and MySQL web application developed for local testing with XAMPP. Citizens can submit public service requests and track their progress, while administrators can review requests and update their status.

## Features

- Citizen registration and login
- Public service request submission with server-side validation
- Unique request reference numbers
- Request status tracking
- Administrator login with hashed passwords
- Admin dashboard with request statistics
- Request search and status updates
- Prepared SQL statements and HTML output escaping
- Session security settings
- Responsive user interface

## Technologies Used

- PHP
- HTML
- CSS
- MySQL/MariaDB
- PDO
- Apache through XAMPP
- phpMyAdmin

## Requirements

- XAMPP for Windows
- A web browser
- The project source files
- The project's `schema.sql` database file

## Installation and Setup

1. Install XAMPP if it is not already installed.
2. Copy the project folder into `C:\xampp\htdocs\`.
3. Start Apache and MySQL from the XAMPP Control Panel.
4. Open `http://localhost/phpmyadmin/`.
5. Create or select the database named `public_service_requests`.
6. Import the project's `schema.sql` file using phpMyAdmin's **Import** feature.
7. Configure the database connection in `config.php`. Use the database account configured for this application; do not assume the MySQL username or password is the default.
8. Confirm that the database account has the permissions required by the application.
9. Open the project homepage in your browser.

If the project is located at `C:\xampp\htdocs\public_service_request_system\public_service_request_system\`, open:

`http://localhost/public_service_request_system/public_service_request_system/`

If your folder structure is different, adjust the URL accordingly.

## Administrator Access

Use the administrator account already created for this local project.

Open the administrator login page:

`http://localhost/public_service_request_system/public_service_request_system/admin/login.php`

Keep administrator credentials private. Do not publish passwords or database credentials.

## Testing the System

1. Register or sign in as a citizen.
2. Submit a test public service request.
3. Save the generated request reference number.
4. Open the tracking page and look up the request.
5. Sign in to the administrator area.
6. Find the submitted request on the dashboard.
7. Change its status from **Pending** to **In Progress**.
8. Confirm that the updated status appears on the tracking page.
9. Change a test request to **Resolved**.
10. Check that the dashboard statistics update correctly.

## Database Security

The application uses a dedicated database account named `psr_app` instead of relying on the MySQL root account. Its permissions should be limited to the operations required by the application.

Keep database credentials private. Do not commit passwords or other secrets to a public repository.

## Limitations and Future Improvements

This project is an educational prototype and is not a production-ready government service.

Possible future improvements include:

- Stronger server-side rate limiting
- Automated tests
- Audit logging for administrator actions
- Privacy notices and data-retention controls
- HTTPS and reviewed deployment settings
- More robust protection for public request tracking
- Improved administrator account management
- Better validation and error handling

Do not use real or sensitive citizen data in an unprotected development environment. A request reference number alone should not expose personal or sensitive information.

## Project Summary

The Public Service Request System demonstrates how PHP and MySQL can be used to build a simple web application for submitting, managing, tracking, and resolving public service requests.
