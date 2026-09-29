# 🛒 CI4 Bootstrap Store

A modern and responsive e-commerce template built with **PHP CodeIgniter 4** and **Bootstrap 5**, featuring reusable components and a clean UI for online stores.

![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?logo=php&logoColor=white)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-EF4223?logo=codeigniter&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green)

## 📸 Some Screenshots

<table>
  <tr>
    <td width="50%"><img src="https://github.com/user-attachments/assets/675d436e-403b-402f-8b0a-3dcf3e4fb0e9" alt="Home page"></td>
    <td width="50%"><img src="https://github.com/user-attachments/assets/aac345b9-ac34-45de-9569-20ae2b92c3ef" alt="Products page"></td>
  </tr>
  <tr>
    <td width="50%"><img src="https://github.com/user-attachments/assets/77aa956c-6d4c-472a-8a34-f4916602d84d" alt="Product details"></td>
    <td width="50%"><img src="https://github.com/user-attachments/assets/4aa2b048-114a-4439-a065-ef88a488c994" alt="Shopping cart"></td>
  </tr>
  <tr>
    <td width="50%"><img src="https://github.com/user-attachments/assets/78e5bcd9-f1c0-4bf4-8227-b5f513f3f58b" alt="Checkout"></td>
    <td width="50%"><img src="https://github.com/user-attachments/assets/0f7b8720-ac22-4f16-adfe-aed8e70332c7" alt="Screenshot 6"></td>
  </tr>
  <tr>
    <td width="50%"><img src="https://github.com/user-attachments/assets/b32003b6-5f92-4d98-bd97-bb30d55daff4" alt="Screenshot 7"></td>
    <td width="50%"><img src="https://github.com/user-attachments/assets/a4f69362-49cf-461b-a256-2629daa29b52" alt="Screenshot 8"></td>
  </tr>
</table>

<table align="center">
  <tr>
    <td><img src="https://github.com/user-attachments/assets/21f12a10-e61f-4eb5-a481-eafe2fa28f28" alt="Mobile view" width="250"></td>
  </tr>
</table>

## ✨ Features

- **Responsive design**: looks great on desktop, tablet, and mobile
- **Reusable components**: header, footer, product card, navigation, and more.
- **Clean, modern UI**: styled with Bootstrap 5
- **Product listing & details pages**
- **Shopping cart & checkout layout**
- **MVC structure**: easy to extend and customize
- **Admin View**: Edit, delete, add products/categories etc...

## 🧰 Tech Stack

| Layer      | Technology                                 |
|------------|------------------------------------------- |
| Backend    | PHP 8.2+, CodeIgniter 4                    |
| Frontend   | Bootstrap 5, HTML5, CSS3, JS & jQuery      |
| Database   | MySQL                                      |

## 🚀 Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/Hadi-Jr/ci4-ecommerce-bootstrap5.git
   cd ci4-bootstrap-shop
   ```

2. **Install dependencies**

   ```bash
   composer install
   ```

3. **Set up the environment file**

   ```bash
   cp env .env
   ```

   Then open `.env` and configure your settings:

   ```ini
   CI_ENVIRONMENT = development

   app.baseURL = 'http://localhost:8080/'

   database.default.hostname = localhost
   database.default.database = your_database
   database.default.username = your_username
   database.default.password = your_password
   database.default.DBDriver = MySQLi
   ```

4. **Import the database**
  1. Open **phpMyAdmin** (or any MySQL dashboard) and create a new database, for example `ecommerce_db`.
  2. In the project folder, go to the `database` directory and open the `.sql` file.
  3. Copy all of its content.
  4. In phpMyAdmin, select your new database, open the **SQL** tab, paste the content, and click **Go**.
   
  This creates all the tables and adds the sample data. Make sure the database name matches the one in your `.env` file.

5. **Start the development server**

   ```bash
   php spark serve
   ```

   Visit **http://localhost:8080** in your browser.

## 🔐 Login

After importing the database, you can log in with:

**Admin**
- **Email:** `admin@mail.com`
- **Password:** `adminadmin`

**User**
- **Email:** `jake@gmail.com`
- **Password:** `jakejake`

> ⚠️ These are demo credentials.

## 📄 License

MIT License

Copyright (c) 2026 Your Name

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
