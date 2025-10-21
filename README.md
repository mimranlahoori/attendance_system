# Attendance System

A Laravel-based attendance management system for educational institutes to track students, classes, holidays, leave requests and daily attendance — all in one simple dashboard.

## 🚀 What is this project?

This project provides a complete backend and UI (Blade + TailwindCSS) solution for managing:

* Classes (e.g., Class 8A, Class 9C)
* Students assigned to classes
* Daily attendance for each student (present, absent, leave, late, holiday)
* Global holidays (public, weekend, special)
* Student leave requests (sick, personal, emergency, other) with admin approval/rejection
* Dashboard analytics: total classes, students, today’s attendance, pending leaves and more
* Top absent students ranking to identify attendance issues

## ✅ Features

* Multi-table data model: Classrooms, Students, Attendances, Holidays, LeaveRequests
* CRUD interfaces for all entities via Blade views, styled with TailwindCSS (dark mode ready)
* Automatically enforce: No duplicate attendance per student per date
* Leave request workflow: Student request → Admin approve/reject
* Holiday table: Define days when attendance should not be counted
* Dashboard view giving quick overview metrics and latest records
* Analytics: Top absent students list
* Responsive UI with navigation and pagination

## 📦 Tech stack

* Laravel (latest stable)
* PHP
* MySQL (or other supported database)
* TailwindCSS + Flowbite (for UI components, if used)
* Blade templates
* Laravel migrations, Eloquent models, controllers, resource routing

## 🛠️ Setup Instructions

Follow these steps to get the project running locally:

1. **Clone the repository**

   ```bash
   git clone https://github.com/mimranlahoori/attendance_system.git
   cd attendance_system
   ```

2. **Install dependencies**

   ```bash
   composer install
   npm install
   ```

3. **Copy and configure `.env`**

   ```bash
   cp .env.example .env
   ```

   Then open `.env` and set up your database credentials, e.g.:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=attendance_system
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

4. **Generate application key**

   ```bash
   php artisan key:generate
   ```

5. **Run migrations and seeders**

   ```bash
   php artisan migrate --seed
   ```

   This will create the required tables and seed some initial dummy data.

6. **Compile assets**

   ```bash
   npm run build
   ```

   (Or `npm run dev` for development mode hot reloading.)

7. **Start the local development server**

   ```bash
   php artisan serve
   ```

   Visit `http://127.0.0.1:8000` in your browser.

8. **Login / register**

   * If authentication is present, register a user or use seeded admin credentials (if provided).
   * You can now access the dashboard and modules for classrooms, students, attendance, holidays and leaves.

## 📁 Project Structure

```
app/
  Models/
    Classroom.php
    Student.php
    Attendance.php
    Holiday.php
    LeaveRequest.php
  Http/
    Controllers/
      ClassroomController.php
      StudentController.php
      AttendanceController.php
      HolidayController.php
      LeaveRequestController.php
      DashboardController.php
database/
  migrations/
  seeders/
resources/
  views/
    classrooms/
    students/
    attendances/
    holidays/
    leaves/
    dashboard.blade.php
routes/
  web.php
```

## 🔍 Usage Highlights

* Navigate to **Classes** → Add/Edit/Delete classes
* Navigate to **Students** → Create student and assign to class
* Navigate to **Attendances** → Mark attendance for a student on a certain date
* Navigate to **Holidays** → Add holiday dates (attendance will skip those)
* Navigate to **Leaves** → Submit leave requests (admin can approve/reject)
* Visit Dashboard → See metrics, latest records, top absences

## 🙌 Contributing

Feel free to fork the project and submit pull requests. Some ideas for future enhancements:

* Bulk attendance marking (by class)
* Role-based access control (Teacher, Admin, Student)
* Graphs/charts (e.g., monthly attendance trends)
* Notifications (email or SMS) when leave is approved/rejected
* Export reports to CSV/PDF

## 📄 License

This project is licensed under the MIT License.
See `LICENSE` for details.
