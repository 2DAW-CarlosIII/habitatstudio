# 🏠 Habitat - Modern Boarding House Finder

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

**Habitat** is a modern, responsive web application designed to simplify the process of finding and booking boarding houses (*Casa*). Built with **Laravel 10** and **Tailwind CSS**, this project focuses on delivering a premium user experience through interactive UI design and robust functionality.

This project serves as a Full-Stack Web Development Portfolio.

---

## ✨ Key Features

### 🎨 Premium UI/UX Design
* **Glassmorphism Aesthetic:** Modern, translucent design elements for cards and navigation.
* **Interactive Golden Cursor:** Custom magnetic cursor with dynamic ripple effects (Desktop only).
* **Custom Scrollbar:** Styled scrollbar to match the application's theme.
* **Smooth Scrolling:** Enhanced navigation experience between sections.

### 📱 Fully Responsive (Mobile First)
* **Adaptive Navigation:** Desktop navbar automatically transforms into a touch-friendly Hamburger Menu on mobile devices.
* **Responsive Layout:** Grid systems that adapt perfectly to Desktop, Tablet, and Mobile screens.

### 🛠️ Core Functionalities
* **🔍 Smart Listing:** Browse detailed casa listings with images, pricing, and facilities.
* **🗺️ Map Integration:** Embedded Google Maps for accurate location tracking.
* **💬 WhatsApp Booking:** "Direct Rent" button integrated with WhatsApp API for instant communication with owners.
* **⭐ Rating System:** Visual star valoracion system for each property.

---

## 📸 Screenshots

*(You can upload your screenshots to the `public/screenshots` folder later and link them here)*

| Desktop View | Mobile View |
|:---:|:---:|
| ![Desktop](public/screenshots/Desktop.png) | ![Mobile](public/screenshots/Mobile.png) |
| ![Desktop](public/screenshots/Desktop2.png) | ![Mobile](public/screenshots/Mobile2.png) |
---

## 🚀 Tech Stack

* **Framework:** [Laravel 10](https://laravel.com/)
* **Styling:** [Tailwind CSS](https://tailwindcss.com/)
* **Database:** MySQL
* **Icons:** FontAwesome 6 Free
* **Typography:** Poppins (Google Fonts)
* **Server Environment:** Apache (XAMPP)

---

## 🛠️ Installation Guide

Follow these exact steps to run the project locally on your machine.

### 📋 Prerequisites (Syarat Wajib)
Make sure you have these installed on your computer:
1.  **XAMPP** (for PHP & MySQL)
2.  **Composer** (PHP Dependency Manager)
3.  **Node.js & NPM** (for compiling Tailwind CSS)
4.  **Git** (optional, for cloning)

### ⚙️ Step-by-Step Installation

1.  **Clone the Repository**
    Open your terminal/command prompt and run:
    ```bash
    git clone https://github.com/AdhityaDaffaR/habitat-laravel-tailwind.git
    cd habitat-laravel-tailwind
    ```

2.  **Install Backend & Frontend Dependencies**
    Download all required libraries:
    ```bash
    composer install
    npm install
    ```

3.  **Database Configuration (IMPORTANT!)**
    * Open **XAMPP Control Panel** and click **Start** for **Apache** and **MySQL**.
    * Open your browser and go to `http://localhost/phpmyadmin`.
    * Click **New** (sidebar), type **`habitat`** as the database name, and click **Create**.

4.  **Environment Setup**
    * In your project folder, duplicate the `.env.example` file and rename it to `.env`.
    * Open the `.env` file and verify these settings match:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=habitat
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Generate App Key & Migrate Database**
    This will fill the database with the required tables and dummy data.
    ```bash
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```

6.  **Compile Assets (CSS/JS)**
    Build the Tailwind CSS styles:
    ```bash
    npm run build
    ```

7.  **Run the Server**
    Start the Laravel development server:
    ```bash
    php artisan serve
    ```

8.  **🎉 Ready to Use!**
    Open your browser and visit: `http://127.0.0.1:8000`

---

*Made with ❤️ in Sumedang, Indonesia.*
