-- Для того чтобы запустить скрипт нескольок раз
DROP TABLE IF EXISTS Composition;
DROP TABLE IF EXISTS Products;
DROP TABLE IF EXISTS Products_Raw;

CREATE TABLE Products_Raw (
    ProductCode INT,
    ProductName VARCHAR(100),
    PartCode INT,
    Quantity INT
);

INSERT INTO Products_Raw (ProductCode, ProductName, PartCode, Quantity) VALUES
(1, 'Bike', 101,2 ),
(1, 'Bike', 102, 1),
(2, 'Scooter', 101, 2),
(2, 'Scooter', 103, 1),
(3, 'Skateboard', 101, 4);

CREATE TABLE Products (
    ProductCode INT PRIMARY KEY,
    ProductName VARCHAR(100)
);

INSERT INTO Products (ProductCode, ProductName)
SELECT DISTINCT ProductCode, ProductName FROM Products_Raw;

ALTER TABLE Products_Raw DROP ProductName;

ALTER TABLE Products_Raw RENAME Composition;

ALTER TABLE Composition ADD PRIMARY KEY (ProductCode, PartCode);    

ALTER TABLE Composition ADD INDEX part_idx (PartCode);