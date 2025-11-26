# Youth Organization BD

A comprehensive web-based management system for youth organizations in Bangladesh, built with Laravel framework. This platform facilitates organization management, member tracking, activity planning, and communication between various stakeholders including students, parents, doctors, and administrators.

## 🌐 Live Application

**Live URL:** [https://youthorganizationbd.org](https://youthorganizationbd.org)

## ✨ Features

- **Multi-role User Management** - Admin, Organization, Directorate, Students, Parents, and Doctors
- **Organization Management** - Complete CRUD operations for organizations
- **Activity Tracking** - Track meetings, members, plans, and objectives
- **Payment Integration** - Multiple payment gateways (PayPal, Stripe, Paystack, bKash, Nagad, and more)
- **OTP Verification** - Secure OTP-based authentication system
- **Firebase Notifications** - Real-time push notifications
- **Social Authentication** - Login with Google, Facebook, Apple, and more
- **File Management** - Document upload and management system
- **API Support** - RESTful APIs for mobile applications
- **Multi-language Support** - Internationalization ready
- **Excel Export/Import** - Data management with Excel
- **PDF Generation** - Dynamic PDF report generation
- **QR Code Generation** - QR code support for various features
- **SMS Integration** - Twilio SMS service integration
- **Email Notifications** - Comprehensive email notification system

## 🛠️ Tech Stack

### Backend
- **PHP** ^8.0.2
- **Laravel** ^9.2
- **Laravel Sanctum** - API authentication
- **Laravel Socialite** - Social authentication
- **Spatie Laravel Permission** - Role and permission management

### Frontend
- **Bootstrap** ^4.0.0
- **Vue.js** ^2.5.7
- **jQuery** ^3.2
- **Laravel Mix** - Asset compilation

### Database & Storage
- **MySQL/MariaDB**
- **Redis** (Predis) - Caching and sessions
- **AWS S3** - Cloud storage support

### Third-party Services
- **Firebase** - Push notifications
- **Twilio** - SMS services
- **Multiple Payment Gateways** - PayPal, Stripe, Paystack, bKash, Nagad, SSLCommerz, etc.

### Additional Packages
- **Intervention Image** - Image manipulation
- **Maatwebsite Excel** - Excel import/export
- **mPDF** - PDF generation
- **Simple QR Code** - QR code generation
- **Guzzle HTTP** - HTTP client

## 📋 Requirements

- PHP >= 8.0.2
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Redis (optional, for caching)
- Web server (Apache/Nginx)

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/mesbah-meju/youthorganizationbd.git
   cd youth-organization
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   - Update `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed database (optional)**
   ```bash
   php artisan db:seed
   ```

8. **Compile assets**
   ```bash
   npm run dev
   # or for production
   npm run production
   ```

9. **Set storage link**
   ```bash
   php artisan storage:link
   ```

10. **Set permissions**
    ```bash
    chmod -R 775 storage bootstrap/cache
    ```

## ⚙️ Configuration

### Environment Variables

Key environment variables to configure:

- `APP_NAME` - Application name
- `APP_ENV` - Environment (local, production)
- `APP_DEBUG` - Debug mode
- `APP_URL` - Application URL
- `DB_*` - Database configuration
- `MAIL_*` - Email configuration
- `FIREBASE_*` - Firebase credentials
- `TWILIO_*` - Twilio SMS credentials
- Payment gateway credentials (PayPal, Stripe, etc.)

### Payment Gateways

Configure your preferred payment gateway in the `.env` file. Supported gateways include:
- PayPal
- Stripe
- Paystack
- bKash
- Nagad
- SSLCommerz
- And many more...

## 📱 API Endpoints

The application provides RESTful APIs for:
- **Student API** (`/api/student/*`)
- **Parent API** (`/api/parent/*`)
- **Doctor API** (`/api/doctor/*`)
- **General API** (`/api/*`)

API documentation can be accessed after installation.

## 🧪 Testing

```bash
php artisan test
```

## 📦 Project Structure

```
youth-organization/
├── app/
│   ├── Console/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Mail/
│   ├── Models/
│   ├── Notifications/
│   └── Services/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── js/
│   ├── lang/
│   └── views/
├── routes/
└── storage/
```

## 🔒 Security

- CSRF protection enabled
- SQL injection prevention (Eloquent ORM)
- XSS protection
- Password hashing (bcrypt)
- API token authentication
- Role-based access control

## 📄 License

This project is licensed under the MIT License.

## 👨‍💻 Developed By

### 4axiz IT Ltd

**Website:** [https://fouraxiz.com](https://fouraxiz.com)

### 👨‍💻 Fullstack Developer

**Mesbah Uddin**

📧 **Email:** [uddin.mesbaah@gmail.com](mailto:uddin.mesbaah@gmail.com)

🌐 **Website:** [mesbahuddin.info](https://mesbahuddin.info)

💼 **LinkedIn:** [mesbah-uddin-meju](https://linkedin.com/in/mesbah-uddin-meju)

🐙 **GitHub:** [mesbah-meju](https://github.com/mesbah-meju)

## 🤝 Contributing

Contributions, issues, and feature requests are welcome! Feel free to check the [issues page](https://github.com/mesbah-meju/youthorganizationbd/issues).

## 📞 Support

For support, email uddin.mesbaah@gmail.com or visit [https://youthorganizationbd.org](https://youthorganizationbd.org).

---

⭐ If you like this project, give it a star on GitHub!
