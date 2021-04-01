-- query 1
INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword, comment) 
VALUES ("Tony", "Stark", "tony@starkent.com", "Iam1ronM@n", "I am the real Ironman");

-- query 2
UPDATE clients
SET clientLevel = 3
WHERE clientEmail = "tony@starkent.com";

-- query 3
UPDATE inventory
SET invDescription = replace(invDescription, "small interior", "spacious interior")
WHERE invMake = "GM" AND invModel = "Hummer";

-- query 4
SELECT inv.invModel, cla.classificationName
FROM inventory inv
INNER JOIN carclassification cla 
ON inv.classificationId = cla.classificationId
WHERE cla.classificationName = "SUV";

-- query 5
DELETE FROM inventory
WHERE invMake = "Jeep" AND invModel = "Wrangler";

-- query 6
UPDATE inventory
SET invImage = concat("/phpmotors", invImage), invThumbnail = concat("/phpmotors", invThumbnail);



