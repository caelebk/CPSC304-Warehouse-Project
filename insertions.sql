--Customer Table Inserts
INSERT INTO Customer(email, CName, address) VALUES ('jsmith@gmail.com', 'John Smith', '2331 meme street v6z 0i2 BC Vancouver');
INSERT INTO Customer(email, CName, address) VALUES ('fredt@gmail.com','Fred Tick','9932 bonker avenue v6a 8f2 BC Vancouver');
INSERT INTO Customer(email, CName, address) VALUES ('fmeep@gmail.com','Andrew Meep','3982 looney street z8w 9z1 BC Vancouver');
INSERT INTO Customer(email, CName, address) VALUES ('jtulip@gmail.com','Jennifer Tulip','4962 ooga jungle v3w 4x1 BC Vancouver');
INSERT INTO Customer(email, CName, address) VALUES ('mmop@gmail.com','Meryl Mop','2391 lion avenue v2s 9o2 BC Vancouver');

--Employee Table Inserts
INSERT INTO Employee(employeeID, EName) VALUES ('1','Paul Lee');
INSERT INTO Employee(employeeID, EName) VALUES ('2','Mary Jane');
INSERT INTO Employee(employeeID, EName) VALUES ('3','Emily Miller');
INSERT INTO Employee(employeeID, EName) VALUES ('4','Richard Brown');
INSERT INTO Employee(employeeID, EName) VALUES ('5','James Jones');
INSERT INTO Employee(employeeID, EName) VALUES ('6','Bill Gates');
INSERT INTO Employee(employeeID, EName) VALUES ('7','Jeff Bezos');
INSERT INTO Employee(employeeID, EName) VALUES ('8','Kate Silver');
INSERT INTO Employee(employeeID, EName) VALUES ('9','Jeffery Peanut');
INSERT INTO Employee(employeeID, EName) VALUES ('10','Mario Giordano');

--EmployeeParking Table Inserts
INSERT INTO EmployeeParking(age, parkingSpot, experienceLevel) VALUES ('25','A10','1 year');
INSERT INTO EmployeeParking(age, parkingSpot, experienceLevel) VALUES ('51','A11','15 year');
INSERT INTO EmployeeParking(age, parkingSpot, experienceLevel) VALUES ('36','A12','3 year');
INSERT INTO EmployeeParking(age, parkingSpot, experienceLevel) VALUES ('31','B10','1 year');
INSERT INTO EmployeeParking(age, parkingSpot, experienceLevel) VALUES ('56','B11','15 year');

--Truck Table Inserts
INSERT INTO Truck(parkingSpot, truckNumber) VALUES ('A10','1');
INSERT INTO Truck(parkingSpot, truckNumber) VALUES ('A11','2');
INSERT INTO Truck(parkingSpot, truckNumber) VALUES ('A12','3');
INSERT INTO Truck(parkingSpot, truckNumber) VALUES ('B10','20');
INSERT INTO Truck(parkingSpot, truckNumber) VALUES ('B11','21');

--Driver Table Inserts
INSERT INTO Driver(age, experienceLevel, employeeID) VALUES ('25','1 year','1');
INSERT INTO Driver(age, experienceLevel, employeeID) VALUES ('51','15 year','2');
INSERT INTO Driver(age, experienceLevel, employeeID) VALUES ('36','3 year','3');
INSERT INTO Driver(age, experienceLevel, employeeID) VALUES ('31','1 year','4');
INSERT INTO Driver(age, experienceLevel, employeeID) VALUES ('56','15 year','5');

--Packer Table Inserts
INSERT INTO Packer(employeeID, basketNum) VALUES ('6','22');
INSERT INTO Packer(employeeID, basketNum) VALUES ('7','23');
INSERT INTO Packer(employeeID, basketNum) VALUES ('8','24');
INSERT INTO Packer(employeeID, basketNum) VALUES ('9','25');
INSERT INTO Packer(employeeID, basketNum) VALUES ('10','26');

--GoesTo Table Inserts
INSERT INTO GoesTo(employeeID, email) VALUES ('1','jsmith@gmail.com');
INSERT INTO GoesTo(employeeID, email) VALUES ('2','fredt@gmail.com');
INSERT INTO GoesTo(employeeID, email) VALUES ('3','fmeep@gmail.com');
INSERT INTO GoesTo(employeeID, email) VALUES ('4','jtulip@gmail.com');
INSERT INTO GoesTo(employeeID, email) VALUES ('5','mmop@gmail.com');

--PlaceOrder Table Inserts
INSERT INTO PlaceOrder(orderID, email) VALUES ('1001','jsmith@gmail.com');
INSERT INTO PlaceOrder(orderID, email) VALUES ('1002','fredt@gmail.com');
INSERT INTO PlaceOrder(orderID, email) VALUES ('1003','fmeep@gmail.com');
INSERT INTO PlaceOrder(orderID, email) VALUES ('1004','jtulip@gmail.com');
INSERT INTO PlaceOrder(orderID, email) VALUES ('1005','mmop@gmail.com');

--Package Table Inserts
INSERT INTO Package(psize, stock) VALUES ('XS','3200');
INSERT INTO Package(psize, stock) VALUES ('S','5321');
INSERT INTO Package(psize, stock) VALUES ('M','8529');
INSERT INTO Package(psize, stock) VALUES ('L','5781');
INSERT INTO Package(psize, stock) VALUES ('XL','2356');

--Requires Table Inserts
INSERT INTO Requires(psize, orderID, email) VALUES ('XS','1001','jsmith@gmail.com');
INSERT INTO Requires(psize, orderID, email) VALUES ('S','1002','fredt@gmail.com');
INSERT INTO Requires(psize, orderID, email) VALUES ('M','1003','fmeep@gmail.com');
INSERT INTO Requires(psize, orderID, email) VALUES ('L','1004','jtulip@gmail.com');
INSERT INTO Requires(psize, orderID, email) VALUES ('XL','1005','mmop@gmail.com');

--WorksOn Table Inserts
INSERT INTO WorksOn(orderID, email, employeeID) VALUES ('1001','jsmith@gmail.com','6');
INSERT INTO WorksOn(orderID, email, employeeID) VALUES ('1002','fredt@gmail.com','7');
INSERT INTO WorksOn(orderID, email, employeeID) VALUES ('1003','fmeep@gmail.com','8');
INSERT INTO WorksOn(orderID, email, employeeID) VALUES ('1004','jtulip@gmail.com','9');
INSERT INTO WorksOn(orderID, email, employeeID) VALUES ('1005','mmop@gmail.com','10');



--Category Table Inserts
INSERT INTO Category(title, location) VALUES ('Kitchen','A01');
INSERT INTO Category(title, location) VALUES ('Stationary','B02');
INSERT INTO Category(title, location) VALUES ('Clothing','C05');
INSERT INTO Category(title, location) VALUES ('Technology','D08');
INSERT INTO Category(title, location) VALUES ('Furniture','E01');

--EmployeeProduct Table Inserts
INSERT INTO EmployeeProduct(employeeID, productID) VALUES ('6','5001');
INSERT INTO EmployeeProduct(employeeID, productID) VALUES ('7','5002');
INSERT INTO EmployeeProduct(employeeID, productID) VALUES ('8','5003');
INSERT INTO EmployeeProduct(employeeID, productID) VALUES ('9','5004');
INSERT INTO EmployeeProduct(employeeID, productID) VALUES ('10','5005');

--Brand Table Inserts
INSERT INTO Brand(companyName) VALUES ('Amazon Jungle');
INSERT INTO Brand(companyName) VALUES ('Kitchen Master');
INSERT INTO Brand(companyName) VALUES ('Tape Man');
INSERT INTO Brand(companyName) VALUES ('Couchers');
INSERT INTO Brand(companyName) VALUES ('Disney');

--Product Table Inserts
INSERT INTO Product(productName, companyName, employeeID) VALUES ('Monkey Pant','Amazon Jungle','6');
INSERT INTO Product(productName, companyName, employeeID) VALUES ('Sporks','Kitchen Master','7');
INSERT INTO Product(productName, companyName, employeeID) VALUES ('Washi tape','Tape Man','8');
INSERT INTO Product(productName, companyName, employeeID) VALUES ('Couch','Couchers','9');
INSERT INTO Product(productName, companyName, employeeID) VALUES ('Lightsaber','Disney','10');
INSERT INTO Product(productName, companyName, employeeID) VALUES ('Sporks','Disney','10');
INSERT INTO Product(productName, companyName, employeeID) VALUES ('Sporks','Amazon Jungle','10');
INSERT INTO Product(productName, companyName, employeeID) VALUES ('Sporks','Tape Man','10');
INSERT INTO Product(productName, companyName, employeeID) VALUES ('Sporks','Couchers','10');

--ProductStock Table Inserts
INSERT INTO ProductStock(productName, stock, companyName) VALUES ('Monkey Pant','29','Amazon Jungle');
INSERT INTO ProductStock(productName, stock, companyName) VALUES ('Sporks', '15', 'Amazon Jungle');
INSERT INTO ProductStock(productName, stock, companyName) VALUES ('Sporks','78','Kitchen Master');
INSERT INTO ProductStock(productName, stock, companyName) VALUES ('Washi Tape','49','Tape Man');
INSERT INTO ProductStock(productName, stock, companyName) VALUES ('Couch','22','Couchers');
INSERT INTO ProductStock(productName, stock, companyName) VALUES ('Lightsaber','23','Disney');
INSERT INTO ProductStock(productName, stock, companyName) VALUES ('Mouse Ears','40','Disney');
INSERT INTO ProductStock(productName, stock, companyName) VALUES ('Sporks','10','Disney');

--IsPartOf Table Inserts
INSERT INTO IsPartOf(productID, title) VALUES ('5001','Kitchen');
INSERT INTO IsPartOf(productID, title) VALUES ('5002','Stationary');
INSERT INTO IsPartOf(productID, title) VALUES ('5003','Clothing');
INSERT INTO IsPartOf(productID, title) VALUES ('5004','Technology');
INSERT INTO IsPartOf(productID, title) VALUES ('5005','Furniture');

COMMIT WORK;