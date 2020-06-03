CREATE VIEW 家計簿01月 AS SELECT id,date,user_id,name,type,amount FROM records JOIN category ON records.category = category.category_id WHERE DATE_FORMAT(date,'%m')='01';

CREATE VIEW 家計簿02月 AS SELECT id,date,user_id,name,type,amount FROM records JOIN category ON records.category = category.category_id WHERE DATE_FORMAT(date,'%m')='02';

CREATE VIEW 家計簿03月 AS SELECT id,date,user_id,name,type,amount FROM records JOIN category ON records.category = category.category_id WHERE DATE_FORMAT(date,'%m')='03';

CREATE VIEW 家計簿04月 AS SELECT id,date,user_id,name,type,amount FROM records JOIN category ON records.category = category.category_id WHERE DATE_FORMAT(date,'%m')='04';

CREATE VIEW 家計簿05月 AS SELECT id,date,user_id,name,type,amount FROM records JOIN category ON records.category = category.category_id WHERE DATE_FORMAT(date,'%m')='05';

CREATE VIEW 家計簿06月 AS SELECT id,date,user_id,name,type,amount FROM records JOIN category ON records.category = category.category_id WHERE DATE_FORMAT(date,'%m')='06';

CREATE VIEW 家計簿07月 AS SELECT id,date,user_id,name,type,amount FROM records JOIN category ON records.category = category.category_id WHERE DATE_FORMAT(date,'%m')='07';

CREATE VIEW 家計簿08月 AS SELECT id,date,user_id,name,type,amount FROM records JOIN category ON records.category = category.category_id WHERE DATE_FORMAT(date,'%m')='08';

CREATE VIEW 家計簿09月 AS SELECT id,date,user_id,name,type,amount FROM records JOIN category ON records.category = category.category_id WHERE DATE_FORMAT(date,'%m')='09';

CREATE VIEW 家計簿10月 AS SELECT id,date,user_id,name,type,amount FROM records JOIN category ON records.category = category.category_id WHERE DATE_FORMAT(date,'%m')='10';

CREATE VIEW 家計簿11月 AS SELECT id,date,user_id,name,type,amount FROM records JOIN category ON records.category = category.category_id WHERE DATE_FORMAT(date,'%m')='11';

CREATE VIEW 家計簿12月 AS SELECT id,date,user_id,name,type,amount FROM records JOIN category ON records.category = category.category_id WHERE DATE_FORMAT(date,'%m')='12';
