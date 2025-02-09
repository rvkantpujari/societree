# Socie🌴ree

SocieTree is a Laravel-based housing management system built with FilamentPHP. It helps users manage daily activities in a society or house, including registration, notices, maintenance collection, and more. The project follows a multi-tenancy approach, allowing administrators to manage multiple societies efficiently.

## Features

-   Multi-tenancy support with super admin control
-   User registration and profile management
-   Maintenance fee collection and tracking
-   Notices and announcements management
-   Role-based access control

## Installation

To install and set up the project on your local system, follow these steps:

### Prerequisites

Make sure you have the following installed:

-   PHP 8.1 or later
-   Composer
-   Node.js and npm
-   MySQL or PostgreSQL database
-   Laravel 10 or later

### Steps to Install

1. Clone the Repository

```
git clone https://github.com/rvkantpujari/societree.git
cd societree
```

2. Install Dependencies

```
composer install
npm install && npm run dev
```

3. Set Up Environment Variables
   Copy the .env.example file and rename it to .env.

```
cp .env.example .env
```

Update the .env file with your database credentials and other required configurations.

4. Generate Application Key

```
php artisan key:generate
```

5. Run Database Migrations and Seeders

```
php artisan migrate --seed
```

6. Set Up Storage Link

```
php artisan storage:link
```

7. Run the Application

```
php artisan serve
```

The application will be available at http://127.0.0.1:8000/.

## Contributing

**We welcome contributions!**

### To contribute:

1. Fork the repository.
2. Create a new branch: git checkout -b feature-name.
3. Commit your changes: git commit -m 'Add new feature'.
4. Push to the branch: git push origin feature-name.
5. Create a pull request.

### Contact

For any issues or feature requests, please open an issue on GitHub or contact the maintainer.
