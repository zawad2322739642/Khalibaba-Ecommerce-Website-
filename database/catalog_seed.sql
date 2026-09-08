-- Khalibaba expanded demo catalog
-- Import after database/khalibaba.sql. It is safe to import more than once.
-- Demo password for every seller below: 123456

INSERT IGNORE INTO users (name,email,password,role,seller_status) VALUES
('Aarong Tech Supplies','seller01@khalibaba.com',MD5('123456'),'seller','Approved'),
('Byte Bazaar','seller02@khalibaba.com',MD5('123456'),'seller','Approved'),
('Circuit Corner','seller03@khalibaba.com',MD5('123456'),'seller','Approved'),
('Digital Dock','seller04@khalibaba.com',MD5('123456'),'seller','Approved'),
('Electro Mart BD','seller05@khalibaba.com',MD5('123456'),'seller','Approved'),
('Future Gadgets','seller06@khalibaba.com',MD5('123456'),'seller','Approved'),
('Gizmo Grid','seller07@khalibaba.com',MD5('123456'),'seller','Approved'),
('Hardware Haven','seller08@khalibaba.com',MD5('123456'),'seller','Approved'),
('Innovation Hub','seller09@khalibaba.com',MD5('123456'),'seller','Approved'),
('Junction Electronics','seller10@khalibaba.com',MD5('123456'),'seller','Approved');

-- Aarong Tech Supplies: 10 products
INSERT INTO products (seller_id,name,category,brand,description,specifications,warranty,price,stock,image,status)
SELECT u.id, v.name, v.category, v.brand, v.description, v.specifications, v.warranty, v.price, v.stock, v.image, 'Approved'
FROM users u
CROSS JOIN (
SELECT '20W USB-C Mini Charger' AS name, 'Chargers' AS category, 'VoltEdge' AS brand, '20W USB-C Mini Charger from VoltEdge, selected for everyday electronics use.' AS description, 'Category: Chargers; Model: 01-01; Ready stock' AS specifications, '6 months' AS warranty, 450.00 AS price, 8 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT '30W Dual Port Charger' AS name, 'Chargers' AS category, 'VoltEdge' AS brand, '30W Dual Port Charger from VoltEdge, selected for everyday electronics use.' AS description, 'Category: Chargers; Model: 01-02; Ready stock' AS specifications, '6 months' AS warranty, 540.00 AS price, 13 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT '45W Travel Charger' AS name, 'Chargers' AS category, 'VoltEdge' AS brand, '45W Travel Charger from VoltEdge, selected for everyday electronics use.' AS description, 'Category: Chargers; Model: 01-03; Ready stock' AS specifications, '6 months' AS warranty, 630.00 AS price, 18 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT '65W GaN Desktop Charger' AS name, 'Chargers' AS category, 'VoltEdge' AS brand, '65W GaN Desktop Charger from VoltEdge, selected for everyday electronics use.' AS description, 'Category: Chargers; Model: 01-04; Ready stock' AS specifications, '6 months' AS warranty, 720.00 AS price, 23 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT '100W USB-C Power Adapter' AS name, 'Chargers' AS category, 'VoltEdge' AS brand, '100W USB-C Power Adapter from VoltEdge, selected for everyday electronics use.' AS description, 'Category: Chargers; Model: 01-05; Ready stock' AS specifications, '6 months' AS warranty, 810.00 AS price, 28 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT 'Magnetic Wireless Charging Pad' AS name, 'Chargers' AS category, 'VoltEdge' AS brand, 'Magnetic Wireless Charging Pad from VoltEdge, selected for everyday electronics use.' AS description, 'Category: Chargers; Model: 01-06; Ready stock' AS specifications, '6 months' AS warranty, 900.00 AS price, 33 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT '15W Foldable Wireless Stand' AS name, 'Chargers' AS category, 'VoltEdge' AS brand, '15W Foldable Wireless Stand from VoltEdge, selected for everyday electronics use.' AS description, 'Category: Chargers; Model: 01-07; Ready stock' AS specifications, '6 months' AS warranty, 990.00 AS price, 38 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT 'Car Charger USB-C PD' AS name, 'Chargers' AS category, 'VoltEdge' AS brand, 'Car Charger USB-C PD from VoltEdge, selected for everyday electronics use.' AS description, 'Category: Chargers; Model: 01-08; Ready stock' AS specifications, '6 months' AS warranty, 1080.00 AS price, 43 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT '4 Port USB Charging Station' AS name, 'Chargers' AS category, 'VoltEdge' AS brand, '4 Port USB Charging Station from VoltEdge, selected for everyday electronics use.' AS description, 'Category: Chargers; Model: 01-09; Ready stock' AS specifications, '6 months' AS warranty, 1170.00 AS price, 11 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT 'Power Delivery Wall Charger' AS name, 'Chargers' AS category, 'VoltEdge' AS brand, 'Power Delivery Wall Charger from VoltEdge, selected for everyday electronics use.' AS description, 'Category: Chargers; Model: 01-10; Ready stock' AS specifications, '6 months' AS warranty, 1260.00 AS price, 16 AS stock, 'products/catalog-charger.png' AS image
) v
LEFT JOIN products existing ON existing.seller_id=u.id AND existing.name=v.name
WHERE u.email='seller01@khalibaba.com' AND existing.id IS NULL;

-- Byte Bazaar: 10 products
INSERT INTO products (seller_id,name,category,brand,description,specifications,warranty,price,stock,image,status)
SELECT u.id, v.name, v.category, v.brand, v.description, v.specifications, v.warranty, v.price, v.stock, v.image, 'Approved'
FROM users u
CROSS JOIN (
SELECT 'USB-C to USB-C Cable 1m' AS name, 'Cables' AS category, 'LinkPro' AS brand, 'USB-C to USB-C Cable 1m from LinkPro, selected for everyday electronics use.' AS description, 'Category: Cables; Model: 02-01; Ready stock' AS specifications, '6 months' AS warranty, 625.00 AS price, 15 AS stock, 'usb-c.svg' AS image
UNION ALL
SELECT 'USB-C to Lightning Cable' AS name, 'Cables' AS category, 'LinkPro' AS brand, 'USB-C to Lightning Cable from LinkPro, selected for everyday electronics use.' AS description, 'Category: Cables; Model: 02-02; Ready stock' AS specifications, '6 months' AS warranty, 715.00 AS price, 20 AS stock, 'usb-c.svg' AS image
UNION ALL
SELECT 'Braided USB-C Cable 2m' AS name, 'Cables' AS category, 'LinkPro' AS brand, 'Braided USB-C Cable 2m from LinkPro, selected for everyday electronics use.' AS description, 'Category: Cables; Model: 02-03; Ready stock' AS specifications, '6 months' AS warranty, 805.00 AS price, 25 AS stock, 'usb-c.svg' AS image
UNION ALL
SELECT 'USB-A to USB-C Cable' AS name, 'Cables' AS category, 'LinkPro' AS brand, 'USB-A to USB-C Cable from LinkPro, selected for everyday electronics use.' AS description, 'Category: Cables; Model: 02-04; Ready stock' AS specifications, '6 months' AS warranty, 895.00 AS price, 30 AS stock, 'usb-c.svg' AS image
UNION ALL
SELECT 'Right Angle USB-C Cable' AS name, 'Cables' AS category, 'LinkPro' AS brand, 'Right Angle USB-C Cable from LinkPro, selected for everyday electronics use.' AS description, 'Category: Cables; Model: 02-05; Ready stock' AS specifications, '6 months' AS warranty, 985.00 AS price, 35 AS stock, 'usb-c.svg' AS image
UNION ALL
SELECT 'USB-C Extension Cable' AS name, 'Cables' AS category, 'LinkPro' AS brand, 'USB-C Extension Cable from LinkPro, selected for everyday electronics use.' AS description, 'Category: Cables; Model: 02-06; Ready stock' AS specifications, '6 months' AS warranty, 1075.00 AS price, 40 AS stock, 'usb-c.svg' AS image
UNION ALL
SELECT 'USB-C to Micro USB Cable' AS name, 'Cables' AS category, 'LinkPro' AS brand, 'USB-C to Micro USB Cable from LinkPro, selected for everyday electronics use.' AS description, 'Category: Cables; Model: 02-07; Ready stock' AS specifications, '6 months' AS warranty, 1165.00 AS price, 8 AS stock, 'usb-c.svg' AS image
UNION ALL
SELECT 'Nylon Fast Charge Cable' AS name, 'Cables' AS category, 'LinkPro' AS brand, 'Nylon Fast Charge Cable from LinkPro, selected for everyday electronics use.' AS description, 'Category: Cables; Model: 02-08; Ready stock' AS specifications, '6 months' AS warranty, 1255.00 AS price, 13 AS stock, 'usb-c.svg' AS image
UNION ALL
SELECT 'USB-C Data Transfer Cable' AS name, 'Cables' AS category, 'LinkPro' AS brand, 'USB-C Data Transfer Cable from LinkPro, selected for everyday electronics use.' AS description, 'Category: Cables; Model: 02-09; Ready stock' AS specifications, '6 months' AS warranty, 1345.00 AS price, 18 AS stock, 'usb-c.svg' AS image
UNION ALL
SELECT 'Magnetic USB-C Charging Cable' AS name, 'Cables' AS category, 'LinkPro' AS brand, 'Magnetic USB-C Charging Cable from LinkPro, selected for everyday electronics use.' AS description, 'Category: Cables; Model: 02-10; Ready stock' AS specifications, '6 months' AS warranty, 1435.00 AS price, 23 AS stock, 'usb-c.svg' AS image
) v
LEFT JOIN products existing ON existing.seller_id=u.id AND existing.name=v.name
WHERE u.email='seller02@khalibaba.com' AND existing.id IS NULL;

-- Circuit Corner: 10 products
INSERT INTO products (seller_id,name,category,brand,description,specifications,warranty,price,stock,image,status)
SELECT u.id, v.name, v.category, v.brand, v.description, v.specifications, v.warranty, v.price, v.stock, v.image, 'Approved'
FROM users u
CROSS JOIN (
SELECT 'True Wireless Earbuds' AS name, 'Audio' AS category, 'SoundNest' AS brand, 'True Wireless Earbuds from SoundNest, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 03-01; Ready stock' AS specifications, '6 months' AS warranty, 800.00 AS price, 22 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Wired In-Ear Earphones' AS name, 'Audio' AS category, 'SoundNest' AS brand, 'Wired In-Ear Earphones from SoundNest, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 03-02; Ready stock' AS specifications, '6 months' AS warranty, 890.00 AS price, 27 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Bluetooth Neckband' AS name, 'Audio' AS category, 'SoundNest' AS brand, 'Bluetooth Neckband from SoundNest, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 03-03; Ready stock' AS specifications, '6 months' AS warranty, 980.00 AS price, 32 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'USB-C Wired Earbuds' AS name, 'Audio' AS category, 'SoundNest' AS brand, 'USB-C Wired Earbuds from SoundNest, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 03-04; Ready stock' AS specifications, '6 months' AS warranty, 1070.00 AS price, 37 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Compact Bluetooth Speaker' AS name, 'Audio' AS category, 'SoundNest' AS brand, 'Compact Bluetooth Speaker from SoundNest, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 03-05; Ready stock' AS specifications, '6 months' AS warranty, 1160.00 AS price, 42 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Noise Isolating Earbuds' AS name, 'Audio' AS category, 'SoundNest' AS brand, 'Noise Isolating Earbuds from SoundNest, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 03-06; Ready stock' AS specifications, '6 months' AS warranty, 1250.00 AS price, 10 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Sports Wireless Earphones' AS name, 'Audio' AS category, 'SoundNest' AS brand, 'Sports Wireless Earphones from SoundNest, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 03-07; Ready stock' AS specifications, '6 months' AS warranty, 1340.00 AS price, 15 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Mini Desktop Speaker' AS name, 'Audio' AS category, 'SoundNest' AS brand, 'Mini Desktop Speaker from SoundNest, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 03-08; Ready stock' AS specifications, '6 months' AS warranty, 1430.00 AS price, 20 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Gaming Earbuds with Mic' AS name, 'Audio' AS category, 'SoundNest' AS brand, 'Gaming Earbuds with Mic from SoundNest, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 03-09; Ready stock' AS specifications, '6 months' AS warranty, 1520.00 AS price, 25 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Portable Clip Speaker' AS name, 'Audio' AS category, 'SoundNest' AS brand, 'Portable Clip Speaker from SoundNest, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 03-10; Ready stock' AS specifications, '6 months' AS warranty, 1610.00 AS price, 30 AS stock, 'earbuds.svg' AS image
) v
LEFT JOIN products existing ON existing.seller_id=u.id AND existing.name=v.name
WHERE u.email='seller03@khalibaba.com' AND existing.id IS NULL;

-- Digital Dock: 10 products
INSERT INTO products (seller_id,name,category,brand,description,specifications,warranty,price,stock,image,status)
SELECT u.id, v.name, v.category, v.brand, v.description, v.specifications, v.warranty, v.price, v.stock, v.image, 'Approved'
FROM users u
CROSS JOIN (
SELECT 'Silent Wireless Mouse' AS name, 'Computer Accessories' AS category, 'ClickWave' AS brand, 'Silent Wireless Mouse from ClickWave, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 04-01; Ready stock' AS specifications, '6 months' AS warranty, 975.00 AS price, 29 AS stock, 'mouse.svg' AS image
UNION ALL
SELECT 'Ergonomic USB Mouse' AS name, 'Computer Accessories' AS category, 'ClickWave' AS brand, 'Ergonomic USB Mouse from ClickWave, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 04-02; Ready stock' AS specifications, '6 months' AS warranty, 1065.00 AS price, 34 AS stock, 'mouse.svg' AS image
UNION ALL
SELECT 'Bluetooth Travel Mouse' AS name, 'Computer Accessories' AS category, 'ClickWave' AS brand, 'Bluetooth Travel Mouse from ClickWave, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 04-03; Ready stock' AS specifications, '6 months' AS warranty, 1155.00 AS price, 39 AS stock, 'mouse.svg' AS image
UNION ALL
SELECT 'Rechargeable Wireless Mouse' AS name, 'Computer Accessories' AS category, 'ClickWave' AS brand, 'Rechargeable Wireless Mouse from ClickWave, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 04-04; Ready stock' AS specifications, '6 months' AS warranty, 1245.00 AS price, 44 AS stock, 'mouse.svg' AS image
UNION ALL
SELECT 'Compact Keyboard Mouse Set' AS name, 'Computer Accessories' AS category, 'ClickWave' AS brand, 'Compact Keyboard Mouse Set from ClickWave, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 04-05; Ready stock' AS specifications, '6 months' AS warranty, 1335.00 AS price, 12 AS stock, 'mouse.svg' AS image
UNION ALL
SELECT 'Vertical Ergonomic Mouse' AS name, 'Computer Accessories' AS category, 'ClickWave' AS brand, 'Vertical Ergonomic Mouse from ClickWave, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 04-06; Ready stock' AS specifications, '6 months' AS warranty, 1425.00 AS price, 17 AS stock, 'mouse.svg' AS image
UNION ALL
SELECT 'Gaming Mouse Pad' AS name, 'Computer Accessories' AS category, 'ClickWave' AS brand, 'Gaming Mouse Pad from ClickWave, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 04-07; Ready stock' AS specifications, '6 months' AS warranty, 1515.00 AS price, 22 AS stock, 'mouse.svg' AS image
UNION ALL
SELECT 'USB Numeric Keypad' AS name, 'Computer Accessories' AS category, 'ClickWave' AS brand, 'USB Numeric Keypad from ClickWave, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 04-08; Ready stock' AS specifications, '6 months' AS warranty, 1605.00 AS price, 27 AS stock, 'mouse.svg' AS image
UNION ALL
SELECT 'Laptop Webcam Cover' AS name, 'Computer Accessories' AS category, 'ClickWave' AS brand, 'Laptop Webcam Cover from ClickWave, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 04-09; Ready stock' AS specifications, '6 months' AS warranty, 1695.00 AS price, 32 AS stock, 'mouse.svg' AS image
UNION ALL
SELECT 'Wireless Presenter Remote' AS name, 'Computer Accessories' AS category, 'ClickWave' AS brand, 'Wireless Presenter Remote from ClickWave, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 04-10; Ready stock' AS specifications, '6 months' AS warranty, 1785.00 AS price, 37 AS stock, 'mouse.svg' AS image
) v
LEFT JOIN products existing ON existing.seller_id=u.id AND existing.name=v.name
WHERE u.email='seller04@khalibaba.com' AND existing.id IS NULL;

-- Electro Mart BD: 10 products
INSERT INTO products (seller_id,name,category,brand,description,specifications,warranty,price,stock,image,status)
SELECT u.id, v.name, v.category, v.brand, v.description, v.specifications, v.warranty, v.price, v.stock, v.image, 'Approved'
FROM users u
CROSS JOIN (
SELECT 'USB-C 4 Port Hub' AS name, 'Adapters' AS category, 'PortBridge' AS brand, 'USB-C 4 Port Hub from PortBridge, selected for everyday electronics use.' AS description, 'Category: Adapters; Model: 05-01; Ready stock' AS specifications, '6 months' AS warranty, 1150.00 AS price, 36 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'USB-C HDMI Adapter' AS name, 'Adapters' AS category, 'PortBridge' AS brand, 'USB-C HDMI Adapter from PortBridge, selected for everyday electronics use.' AS description, 'Category: Adapters; Model: 05-02; Ready stock' AS specifications, '6 months' AS warranty, 1240.00 AS price, 41 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'USB-C Ethernet Adapter' AS name, 'Adapters' AS category, 'PortBridge' AS brand, 'USB-C Ethernet Adapter from PortBridge, selected for everyday electronics use.' AS description, 'Category: Adapters; Model: 05-03; Ready stock' AS specifications, '6 months' AS warranty, 1330.00 AS price, 9 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'USB-A to USB-C Adapter' AS name, 'Adapters' AS category, 'PortBridge' AS brand, 'USB-A to USB-C Adapter from PortBridge, selected for everyday electronics use.' AS description, 'Category: Adapters; Model: 05-04; Ready stock' AS specifications, '6 months' AS warranty, 1420.00 AS price, 14 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'Multiport Laptop Hub' AS name, 'Adapters' AS category, 'PortBridge' AS brand, 'Multiport Laptop Hub from PortBridge, selected for everyday electronics use.' AS description, 'Category: Adapters; Model: 05-05; Ready stock' AS specifications, '6 months' AS warranty, 1510.00 AS price, 19 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'USB 3.0 Extension Hub' AS name, 'Adapters' AS category, 'PortBridge' AS brand, 'USB 3.0 Extension Hub from PortBridge, selected for everyday electronics use.' AS description, 'Category: Adapters; Model: 05-06; Ready stock' AS specifications, '6 months' AS warranty, 1600.00 AS price, 24 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'SD Card Reader Adapter' AS name, 'Adapters' AS category, 'PortBridge' AS brand, 'SD Card Reader Adapter from PortBridge, selected for everyday electronics use.' AS description, 'Category: Adapters; Model: 05-07; Ready stock' AS specifications, '6 months' AS warranty, 1690.00 AS price, 29 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'USB-C VGA Adapter' AS name, 'Adapters' AS category, 'PortBridge' AS brand, 'USB-C VGA Adapter from PortBridge, selected for everyday electronics use.' AS description, 'Category: Adapters; Model: 05-08; Ready stock' AS specifications, '6 months' AS warranty, 1780.00 AS price, 34 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'HDMI to USB-C Capture Adapter' AS name, 'Adapters' AS category, 'PortBridge' AS brand, 'HDMI to USB-C Capture Adapter from PortBridge, selected for everyday electronics use.' AS description, 'Category: Adapters; Model: 05-09; Ready stock' AS specifications, '6 months' AS warranty, 1870.00 AS price, 39 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'USB-C Audio Adapter' AS name, 'Adapters' AS category, 'PortBridge' AS brand, 'USB-C Audio Adapter from PortBridge, selected for everyday electronics use.' AS description, 'Category: Adapters; Model: 05-10; Ready stock' AS specifications, '6 months' AS warranty, 1960.00 AS price, 44 AS stock, 'hub.svg' AS image
) v
LEFT JOIN products existing ON existing.seller_id=u.id AND existing.name=v.name
WHERE u.email='seller05@khalibaba.com' AND existing.id IS NULL;

-- Future Gadgets: 10 products
INSERT INTO products (seller_id,name,category,brand,description,specifications,warranty,price,stock,image,status)
SELECT u.id, v.name, v.category, v.brand, v.description, v.specifications, v.warranty, v.price, v.stock, v.image, 'Approved'
FROM users u
CROSS JOIN (
SELECT 'Aluminum Laptop Stand' AS name, 'Computer Accessories' AS category, 'DeskCraft' AS brand, 'Aluminum Laptop Stand from DeskCraft, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 06-01; Ready stock' AS specifications, '6 months' AS warranty, 1325.00 AS price, 43 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Adjustable Phone Stand' AS name, 'Computer Accessories' AS category, 'DeskCraft' AS brand, 'Adjustable Phone Stand from DeskCraft, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 06-02; Ready stock' AS specifications, '6 months' AS warranty, 1415.00 AS price, 11 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Foldable Tablet Stand' AS name, 'Computer Accessories' AS category, 'DeskCraft' AS brand, 'Foldable Tablet Stand from DeskCraft, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 06-03; Ready stock' AS specifications, '6 months' AS warranty, 1505.00 AS price, 16 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Monitor Riser Stand' AS name, 'Computer Accessories' AS category, 'DeskCraft' AS brand, 'Monitor Riser Stand from DeskCraft, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 06-04; Ready stock' AS specifications, '6 months' AS warranty, 1595.00 AS price, 21 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Laptop Cooling Stand' AS name, 'Computer Accessories' AS category, 'DeskCraft' AS brand, 'Laptop Cooling Stand from DeskCraft, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 06-05; Ready stock' AS specifications, '6 months' AS warranty, 1685.00 AS price, 26 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Desktop Headphone Stand' AS name, 'Computer Accessories' AS category, 'DeskCraft' AS brand, 'Desktop Headphone Stand from DeskCraft, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 06-06; Ready stock' AS specifications, '6 months' AS warranty, 1775.00 AS price, 31 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Cable Management Box' AS name, 'Computer Accessories' AS category, 'DeskCraft' AS brand, 'Cable Management Box from DeskCraft, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 06-07; Ready stock' AS specifications, '6 months' AS warranty, 1865.00 AS price, 36 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Under Desk Cable Tray' AS name, 'Computer Accessories' AS category, 'DeskCraft' AS brand, 'Under Desk Cable Tray from DeskCraft, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 06-08; Ready stock' AS specifications, '6 months' AS warranty, 1955.00 AS price, 41 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Keyboard Wrist Rest' AS name, 'Computer Accessories' AS category, 'DeskCraft' AS brand, 'Keyboard Wrist Rest from DeskCraft, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 06-09; Ready stock' AS specifications, '6 months' AS warranty, 2045.00 AS price, 9 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Portable Laptop Riser' AS name, 'Computer Accessories' AS category, 'DeskCraft' AS brand, 'Portable Laptop Riser from DeskCraft, selected for everyday electronics use.' AS description, 'Category: Computer Accessories; Model: 06-10; Ready stock' AS specifications, '6 months' AS warranty, 2135.00 AS price, 14 AS stock, 'stand.svg' AS image
) v
LEFT JOIN products existing ON existing.seller_id=u.id AND existing.name=v.name
WHERE u.email='seller06@khalibaba.com' AND existing.id IS NULL;

-- Gizmo Grid: 10 products
INSERT INTO products (seller_id,name,category,brand,description,specifications,warranty,price,stock,image,status)
SELECT u.id, v.name, v.category, v.brand, v.description, v.specifications, v.warranty, v.price, v.stock, v.image, 'Approved'
FROM users u
CROSS JOIN (
SELECT '10000mAh Slim Power Bank' AS name, 'Power Banks' AS category, 'ChargeCore' AS brand, '10000mAh Slim Power Bank from ChargeCore, selected for everyday electronics use.' AS description, 'Category: Power Banks; Model: 07-01; Ready stock' AS specifications, '6 months' AS warranty, 1500.00 AS price, 13 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT '20000mAh Fast Charge Power Bank' AS name, 'Power Banks' AS category, 'ChargeCore' AS brand, '20000mAh Fast Charge Power Bank from ChargeCore, selected for everyday electronics use.' AS description, 'Category: Power Banks; Model: 07-02; Ready stock' AS specifications, '6 months' AS warranty, 1590.00 AS price, 18 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT 'Magnetic Power Bank' AS name, 'Power Banks' AS category, 'ChargeCore' AS brand, 'Magnetic Power Bank from ChargeCore, selected for everyday electronics use.' AS description, 'Category: Power Banks; Model: 07-03; Ready stock' AS specifications, '6 months' AS warranty, 1680.00 AS price, 23 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT 'Pocket Power Bank 5000mAh' AS name, 'Power Banks' AS category, 'ChargeCore' AS brand, 'Pocket Power Bank 5000mAh from ChargeCore, selected for everyday electronics use.' AS description, 'Category: Power Banks; Model: 07-04; Ready stock' AS specifications, '6 months' AS warranty, 1770.00 AS price, 28 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT 'Solar Backup Power Bank' AS name, 'Power Banks' AS category, 'ChargeCore' AS brand, 'Solar Backup Power Bank from ChargeCore, selected for everyday electronics use.' AS description, 'Category: Power Banks; Model: 07-05; Ready stock' AS specifications, '6 months' AS warranty, 1860.00 AS price, 33 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT 'USB-C PD Power Bank' AS name, 'Power Banks' AS category, 'ChargeCore' AS brand, 'USB-C PD Power Bank from ChargeCore, selected for everyday electronics use.' AS description, 'Category: Power Banks; Model: 07-06; Ready stock' AS specifications, '6 months' AS warranty, 1950.00 AS price, 38 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT 'Dual Output Power Bank' AS name, 'Power Banks' AS category, 'ChargeCore' AS brand, 'Dual Output Power Bank from ChargeCore, selected for everyday electronics use.' AS description, 'Category: Power Banks; Model: 07-07; Ready stock' AS specifications, '6 months' AS warranty, 2040.00 AS price, 43 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT 'Digital Display Power Bank' AS name, 'Power Banks' AS category, 'ChargeCore' AS brand, 'Digital Display Power Bank from ChargeCore, selected for everyday electronics use.' AS description, 'Category: Power Banks; Model: 07-08; Ready stock' AS specifications, '6 months' AS warranty, 2130.00 AS price, 11 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT 'Travel Power Bank Case' AS name, 'Power Banks' AS category, 'ChargeCore' AS brand, 'Travel Power Bank Case from ChargeCore, selected for everyday electronics use.' AS description, 'Category: Power Banks; Model: 07-09; Ready stock' AS specifications, '6 months' AS warranty, 2220.00 AS price, 16 AS stock, 'products/catalog-charger.png' AS image
UNION ALL
SELECT 'Mini Emergency Charger' AS name, 'Power Banks' AS category, 'ChargeCore' AS brand, 'Mini Emergency Charger from ChargeCore, selected for everyday electronics use.' AS description, 'Category: Power Banks; Model: 07-10; Ready stock' AS specifications, '6 months' AS warranty, 2310.00 AS price, 21 AS stock, 'products/catalog-charger.png' AS image
) v
LEFT JOIN products existing ON existing.seller_id=u.id AND existing.name=v.name
WHERE u.email='seller07@khalibaba.com' AND existing.id IS NULL;

-- Hardware Haven: 10 products
INSERT INTO products (seller_id,name,category,brand,description,specifications,warranty,price,stock,image,status)
SELECT u.id, v.name, v.category, v.brand, v.description, v.specifications, v.warranty, v.price, v.stock, v.image, 'Approved'
FROM users u
CROSS JOIN (
SELECT 'Over Ear Bluetooth Headphones' AS name, 'Audio' AS category, 'EchoLine' AS brand, 'Over Ear Bluetooth Headphones from EchoLine, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 08-01; Ready stock' AS specifications, '6 months' AS warranty, 1675.00 AS price, 20 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'On Ear Foldable Headphones' AS name, 'Audio' AS category, 'EchoLine' AS brand, 'On Ear Foldable Headphones from EchoLine, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 08-02; Ready stock' AS specifications, '6 months' AS warranty, 1765.00 AS price, 25 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'USB Headset with Microphone' AS name, 'Audio' AS category, 'EchoLine' AS brand, 'USB Headset with Microphone from EchoLine, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 08-03; Ready stock' AS specifications, '6 months' AS warranty, 1855.00 AS price, 30 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Gaming Headset' AS name, 'Audio' AS category, 'EchoLine' AS brand, 'Gaming Headset from EchoLine, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 08-04; Ready stock' AS specifications, '6 months' AS warranty, 1945.00 AS price, 35 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Sleep Earbuds' AS name, 'Audio' AS category, 'EchoLine' AS brand, 'Sleep Earbuds from EchoLine, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 08-05; Ready stock' AS specifications, '6 months' AS warranty, 2035.00 AS price, 40 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Open Ear Wireless Headphones' AS name, 'Audio' AS category, 'EchoLine' AS brand, 'Open Ear Wireless Headphones from EchoLine, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 08-06; Ready stock' AS specifications, '6 months' AS warranty, 2125.00 AS price, 8 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Kids Volume Safe Headphones' AS name, 'Audio' AS category, 'EchoLine' AS brand, 'Kids Volume Safe Headphones from EchoLine, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 08-07; Ready stock' AS specifications, '6 months' AS warranty, 2215.00 AS price, 13 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Studio Monitor Headphones' AS name, 'Audio' AS category, 'EchoLine' AS brand, 'Studio Monitor Headphones from EchoLine, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 08-08; Ready stock' AS specifications, '6 months' AS warranty, 2305.00 AS price, 18 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Noise Reduction Headset' AS name, 'Audio' AS category, 'EchoLine' AS brand, 'Noise Reduction Headset from EchoLine, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 08-09; Ready stock' AS specifications, '6 months' AS warranty, 2395.00 AS price, 23 AS stock, 'earbuds.svg' AS image
UNION ALL
SELECT 'Bluetooth Receiver Adapter' AS name, 'Audio' AS category, 'EchoLine' AS brand, 'Bluetooth Receiver Adapter from EchoLine, selected for everyday electronics use.' AS description, 'Category: Audio; Model: 08-10; Ready stock' AS specifications, '6 months' AS warranty, 2485.00 AS price, 28 AS stock, 'earbuds.svg' AS image
) v
LEFT JOIN products existing ON existing.seller_id=u.id AND existing.name=v.name
WHERE u.email='seller08@khalibaba.com' AND existing.id IS NULL;

-- Innovation Hub: 10 products
INSERT INTO products (seller_id,name,category,brand,description,specifications,warranty,price,stock,image,status)
SELECT u.id, v.name, v.category, v.brand, v.description, v.specifications, v.warranty, v.price, v.stock, v.image, 'Approved'
FROM users u
CROSS JOIN (
SELECT '64GB USB 3 Flash Drive' AS name, 'Storage' AS category, 'DataSprint' AS brand, '64GB USB 3 Flash Drive from DataSprint, selected for everyday electronics use.' AS description, 'Category: Storage; Model: 09-01; Ready stock' AS specifications, '12 months' AS warranty, 1850.00 AS price, 27 AS stock, 'hub.svg' AS image
UNION ALL
SELECT '128GB USB-C Flash Drive' AS name, 'Storage' AS category, 'DataSprint' AS brand, '128GB USB-C Flash Drive from DataSprint, selected for everyday electronics use.' AS description, 'Category: Storage; Model: 09-02; Ready stock' AS specifications, '12 months' AS warranty, 1940.00 AS price, 32 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'Portable SSD Enclosure' AS name, 'Storage' AS category, 'DataSprint' AS brand, 'Portable SSD Enclosure from DataSprint, selected for everyday electronics use.' AS description, 'Category: Storage; Model: 09-03; Ready stock' AS specifications, '12 months' AS warranty, 2030.00 AS price, 37 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'MicroSD Card Reader' AS name, 'Storage' AS category, 'DataSprint' AS brand, 'MicroSD Card Reader from DataSprint, selected for everyday electronics use.' AS description, 'Category: Storage; Model: 09-04; Ready stock' AS specifications, '12 months' AS warranty, 2120.00 AS price, 42 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'Dual Connector Flash Drive' AS name, 'Storage' AS category, 'DataSprint' AS brand, 'Dual Connector Flash Drive from DataSprint, selected for everyday electronics use.' AS description, 'Category: Storage; Model: 09-05; Ready stock' AS specifications, '12 months' AS warranty, 2210.00 AS price, 10 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'External Hard Drive Case' AS name, 'Storage' AS category, 'DataSprint' AS brand, 'External Hard Drive Case from DataSprint, selected for everyday electronics use.' AS description, 'Category: Storage; Model: 09-06; Ready stock' AS specifications, '12 months' AS warranty, 2300.00 AS price, 15 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'USB-C NVMe Enclosure' AS name, 'Storage' AS category, 'DataSprint' AS brand, 'USB-C NVMe Enclosure from DataSprint, selected for everyday electronics use.' AS description, 'Category: Storage; Model: 09-07; Ready stock' AS specifications, '12 months' AS warranty, 2390.00 AS price, 20 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'Memory Card Storage Case' AS name, 'Storage' AS category, 'DataSprint' AS brand, 'Memory Card Storage Case from DataSprint, selected for everyday electronics use.' AS description, 'Category: Storage; Model: 09-08; Ready stock' AS specifications, '12 months' AS warranty, 2480.00 AS price, 25 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'USB Backup Drive 32GB' AS name, 'Storage' AS category, 'DataSprint' AS brand, 'USB Backup Drive 32GB from DataSprint, selected for everyday electronics use.' AS description, 'Category: Storage; Model: 09-09; Ready stock' AS specifications, '12 months' AS warranty, 2570.00 AS price, 30 AS stock, 'hub.svg' AS image
UNION ALL
SELECT 'Type-C OTG Storage Adapter' AS name, 'Storage' AS category, 'DataSprint' AS brand, 'Type-C OTG Storage Adapter from DataSprint, selected for everyday electronics use.' AS description, 'Category: Storage; Model: 09-10; Ready stock' AS specifications, '12 months' AS warranty, 2660.00 AS price, 35 AS stock, 'hub.svg' AS image
) v
LEFT JOIN products existing ON existing.seller_id=u.id AND existing.name=v.name
WHERE u.email='seller09@khalibaba.com' AND existing.id IS NULL;

-- Junction Electronics: 10 products
INSERT INTO products (seller_id,name,category,brand,description,specifications,warranty,price,stock,image,status)
SELECT u.id, v.name, v.category, v.brand, v.description, v.specifications, v.warranty, v.price, v.stock, v.image, 'Approved'
FROM users u
CROSS JOIN (
SELECT 'Tempered Glass Screen Protector' AS name, 'Mobile Accessories' AS category, 'MobileMint' AS brand, 'Tempered Glass Screen Protector from MobileMint, selected for everyday electronics use.' AS description, 'Category: Mobile Accessories; Model: 10-01; Ready stock' AS specifications, '6 months' AS warranty, 2025.00 AS price, 34 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Shockproof Phone Case' AS name, 'Mobile Accessories' AS category, 'MobileMint' AS brand, 'Shockproof Phone Case from MobileMint, selected for everyday electronics use.' AS description, 'Category: Mobile Accessories; Model: 10-02; Ready stock' AS specifications, '6 months' AS warranty, 2115.00 AS price, 39 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Magnetic Phone Ring Holder' AS name, 'Mobile Accessories' AS category, 'MobileMint' AS brand, 'Magnetic Phone Ring Holder from MobileMint, selected for everyday electronics use.' AS description, 'Category: Mobile Accessories; Model: 10-03; Ready stock' AS specifications, '6 months' AS warranty, 2205.00 AS price, 44 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Dashboard Phone Mount' AS name, 'Mobile Accessories' AS category, 'MobileMint' AS brand, 'Dashboard Phone Mount from MobileMint, selected for everyday electronics use.' AS description, 'Category: Mobile Accessories; Model: 10-04; Ready stock' AS specifications, '6 months' AS warranty, 2295.00 AS price, 12 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Bike Phone Holder' AS name, 'Mobile Accessories' AS category, 'MobileMint' AS brand, 'Bike Phone Holder from MobileMint, selected for everyday electronics use.' AS description, 'Category: Mobile Accessories; Model: 10-05; Ready stock' AS specifications, '6 months' AS warranty, 2385.00 AS price, 17 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Selfie Tripod Stand' AS name, 'Mobile Accessories' AS category, 'MobileMint' AS brand, 'Selfie Tripod Stand from MobileMint, selected for everyday electronics use.' AS description, 'Category: Mobile Accessories; Model: 10-06; Ready stock' AS specifications, '6 months' AS warranty, 2475.00 AS price, 22 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Clip On Ring Light' AS name, 'Mobile Accessories' AS category, 'MobileMint' AS brand, 'Clip On Ring Light from MobileMint, selected for everyday electronics use.' AS description, 'Category: Mobile Accessories; Model: 10-07; Ready stock' AS specifications, '6 months' AS warranty, 2565.00 AS price, 27 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'SIM Card Storage Case' AS name, 'Mobile Accessories' AS category, 'MobileMint' AS brand, 'SIM Card Storage Case from MobileMint, selected for everyday electronics use.' AS description, 'Category: Mobile Accessories; Model: 10-08; Ready stock' AS specifications, '6 months' AS warranty, 2655.00 AS price, 32 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Phone Cleaning Kit' AS name, 'Mobile Accessories' AS category, 'MobileMint' AS brand, 'Phone Cleaning Kit from MobileMint, selected for everyday electronics use.' AS description, 'Category: Mobile Accessories; Model: 10-09; Ready stock' AS specifications, '6 months' AS warranty, 2745.00 AS price, 37 AS stock, 'stand.svg' AS image
UNION ALL
SELECT 'Waterproof Phone Pouch' AS name, 'Mobile Accessories' AS category, 'MobileMint' AS brand, 'Waterproof Phone Pouch from MobileMint, selected for everyday electronics use.' AS description, 'Category: Mobile Accessories; Model: 10-10; Ready stock' AS specifications, '6 months' AS warranty, 2835.00 AS price, 42 AS stock, 'stand.svg' AS image
) v
LEFT JOIN products existing ON existing.seller_id=u.id AND existing.name=v.name
WHERE u.email='seller10@khalibaba.com' AND existing.id IS NULL;

