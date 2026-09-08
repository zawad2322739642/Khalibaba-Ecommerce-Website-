# Khalibaba — Online Electronic Accessories Store

A minimal Software Engineering course project built with PHP + MySQL + HTML/CSS/JavaScript.

## Actors
1. Buyer
   - Browse products
   - View product details and price in BDT
   - Add products to cart
   - Update cart
   - Checkout with shipping address
   - View order status from dashboard

2. Seller
   - Seller dashboard
   - View number of products/orders/sales
   - See incoming orders connected to their products
   - Add products to catalog

## Setup with XAMPP
1. Copy the `Khalibaba` folder to `C:\xampp\htdocs\`.
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin.
4. Import `database/khalibaba.sql`.
5. Visit `http://localhost/Khalibaba/`.

## Demo accounts
Buyer:
- Email: buyer@khalibaba.com
- Password: 123456

Seller:
- Email: seller@khalibaba.com
- Password: 123456

## Important
For a production deployment, use HTTPS, environment variables, CSRF protection, stricter validation, proper image uploads, and a production-grade password migration. The included demo SQL uses MD5 only for the pre-seeded demo users; newly registered users use PHP password hashing.
