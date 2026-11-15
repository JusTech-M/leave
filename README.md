# Leave Management System

A web application for managing staff leave requests in an organisation. Staff apply for leave online, and each request moves through a multi-level approval chain until it is approved or rejected. Approval letters are generated automatically as PDFs, and everyone involved is notified by email.

## Features

- **Online leave applications** for Casual Leave and Annual Leave, with start and end dates, working days, reason and contact details.
- **Relieving officer step:** the staff member names a colleague to cover their duties, and that colleague can accept or decline.
- **Multi-level approval workflow:** requests move from the unit head to the admin and then the director, with a note or recommendation recorded at each stage.
- **Role-based dashboards** for staff, unit heads, programme coordinators, admin, deputy director, director and technical officers, each showing only what that role needs.
- **Automatic PDF letters** for approved leave and leave extensions.
- **Email notifications** at each stage of the process.
- **User management:** technical officers can add, edit, search and delete staff accounts, and bulk-import staff from Excel or CSV files.
- **Secure login** with password reset.

## Tech Stack

- **Backend:** PHP (structured into model, view and controller files)
- **Database:** MySQL
- **Frontend:** HTML, CSS and JavaScript
- **Libraries (via Composer):**
  - PHPMailer for email
  - TCPDF and Dompdf for PDF letters
  - PhpSpreadsheet for Excel and CSV import

## Approval Flow

```
Staff applies → Relieving officer accepts → Unit Head → Admin → Director → Approved (PDF letter sent)
```

A request can be rejected at any stage, and the staff member is notified.

## Getting Started

### Requirements

- PHP 8 or later
- MySQL or MariaDB
- Composer
- A local server such as XAMPP, WAMP or Laragon

### Installation

1. Clone the repository into your server's web folder (for example `htdocs` in XAMPP):
   ```bash
   git clone https://github.com/JusTech-M/leave.git
   ```
2. Install the dependencies:
   ```bash
   composer install
   ```
3. Create a database named `leave_management` and import `database.sql` into it, for example through phpMyAdmin.
4. Check the database settings in `config/db.php` and update them if your MySQL username or password is different.
5. Open the app in your browser:
   ```
   http://localhost/leave
   ```

### Email on localhost

When the app runs on `localhost`, emails are not sent. Their content is written to a log file instead (`config/email_log.txt`), so you can test the full workflow without an email server.

## Sample Data

All names, email addresses, letters and records in this repository are **sample test data** created for development. They do not belong to real people.

## Author

**Oni Damilare Joseph**
Software Engineer
[LinkedIn](https://www.linkedin.com/in/damilare-oni-399a34291) · damilareoni2@gmail.com
