# CarZone - Car Rental Website

A simple car rental website built with PHP and MySQL. Users can browse cars, make bookings, and manage accounts. Admins can oversee bookings and users.

## Features
- User login and signup
- Browse and sort cars by price
- Book cars with pickup/drop details
- Admin dashboard for managing bookings and users
- Contact form for inquiries

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/carzone.git
   cd carzone
   ```

## Database Setup
1. Create a MySQL database named `carzone_db`.
2. Import `carzone_db.sql`:
   ```bash
   mysql -u root -p carzone_db < carzone_db.sql
   ```

## Configuration
Edit `db_connection.php` with your MySQL details:
```php
$host = 'localhost';
$db = 'carzone_db';
$user = 'root';  // your username
$pass = '';      // your password
```

## Running the Project

### XAMPP (Windows/Mac/Linux)
1. Install XAMPP.
2. Start Apache and MySQL.
3. Place project in `htdocs` folder.
4. Open `http://localhost/carzone`.

### WAMP (Windows)
1. Install WAMP.
2. Start services.
3. Place project in `www` folder.
4. Open `http://localhost/carzone`.

### Ubuntu
1. Install Apache, PHP, MySQL:
   ```bash
   sudo apt update
   sudo apt install apache2 php mysql-server php-mysql
   ```
2. Start services:
   ```bash
   sudo systemctl start apache2
   sudo systemctl start mysql
   ```
3. Link project to `/var/www/html`:
   ```bash
   sudo ln -s /path/to/project /var/www/html/carzone
   ```
4. Open `http://localhost/carzone`.

## Admin Access
To access admin features:
- Email: admin@gmail.com
- Password: admin@123
## More about features and screenshots are in :
   https://abhinavsunil.web.app/portfolio-details.html
## License
This project is licensed under the MIT License.
