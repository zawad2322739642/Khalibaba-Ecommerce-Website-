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
5. Import `database/catalog_seed.sql` to add 10 approved demo sellers and 100 pictured products.
6. Visit `http://localhost/Khalibaba/`.

## Demo accounts
Buyer:
- Email: buyer@khalibaba.com
- Password: 123456

Seller:
- Email: seller@khalibaba.com
- Password: 123456

Administrator:
- Email: admin@khalibaba.com
- Password: 123456
- Admin ID: KHB-0003

## SRS workflows added
- Admin approval and suspension of sellers, listing moderation, marketplace commission settings, support/return handling, and content-report review.
- Buyer support tickets, delivered-order return requests, and product-report submission.
- Catalog filtering by category, brand, price, availability, and technical text; sorting; and up-to-three-product comparison including specifications and warranty.

## AI-assisted catalog search

The prototype uses a transparent rule-based AI-inspired assistant, not a third-party API. It accepts natural-language shopping, support, policy, and order-status queries; expands common accessory synonyms; ranks only approved products from approved sellers using name, category, brand, description, and specifications; recognizes budget and availability preferences; and returns ranked product cards or contextual answers. Low-confidence requests include a direct standard catalog-search fallback. The assistant is read-only and cannot change products, inventory, payments, or orders.

## Important
For a production deployment, use HTTPS, environment variables, CSRF protection, stricter validation, proper image uploads, and a production-grade password migration. The included demo SQL uses MD5 only for the pre-seeded demo users; newly registered users use PHP password hashing.
