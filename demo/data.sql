PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;

DROP TABLE authors;
DROP TABLE comments;
DROP TABLE posts;

CREATE TABLE authors (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL);
INSERT INTO authors VALUES(1,'Ciaran Holt');
INSERT INTO authors VALUES(2,'Xenos Burks');
INSERT INTO authors VALUES(3,'Kaseem Flores');
INSERT INTO authors VALUES(4,'Yasir Lee');
INSERT INTO authors VALUES(5,'Rogan Morgan');
INSERT INTO authors VALUES(6,'Dalton Workman');
INSERT INTO authors VALUES(7,'Clark Kelley');
INSERT INTO authors VALUES(8,'Rooney Bond');
INSERT INTO authors VALUES(9,'Kuame Scott');
INSERT INTO authors VALUES(10,'Alec Larsen');

CREATE TABLE posts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author INTEGER DEFAULT NULL, title VARCHAR(100) NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, postDate DATETIME NOT NULL, CONSTRAINT FK_885DBAFABDAFD8C8 FOREIGN KEY (author) REFERENCES authors (id) NOT DEFERRABLE INITIALLY IMMEDIATE);

INSERT INTO posts VALUES(1,1,'How I Improved My GraphQL In One Easy Lesson', 'aut rerum at omnis voluptates error magnam ex dolore iure repudiandae blanditiis rerum molestiae eos', CURRENT_TIMESTAMP);
INSERT INTO posts VALUES(2,2,'GraphQL Strategies For Beginners', 'Miwha hih sin pop foebtil zadiz nedbifhev roddezid ruma afantik ju fa fibu ofifi iw ov ceh hehos.', CURRENT_TIMESTAMP);
INSERT INTO posts VALUES(3,3,'Dont Just Sit There! Start GraphQL', 'Upbedpef uvocupne uhufa hidav bulu bo vug tejrededo egikamab eswa vavo ha gemoh.', CURRENT_TIMESTAMP);
INSERT INTO posts VALUES(4,4,'Guaranteed No Stress GraphQL', 'Ju efifu lewdi mufobifu wojelbac bejeti lupjudwa jakvo finantu eco lelcas zu eggarnuc safip upizepi wanfom taz.', CURRENT_TIMESTAMP);
INSERT INTO posts VALUES(5,5,'5 Brilliant Ways To Teach Your Audience About GraphQL', 'Nevcodcij dubuwod ut ibucut ritu zudanvig fu dobfuc tupivoza vurwebbil masze pozepa inoobbuf mecbugobi ebut ol.
', CURRENT_TIMESTAMP);
INSERT INTO posts VALUES(6,6,'Get Better GraphQL Results By Following 3 Simple Steps', 'Ufa dil pucihsod pubuzo kekoj vomweg pasfiun sel wogoc honpe re jowtibu lewpemo seeb.
', CURRENT_TIMESTAMP);
INSERT INTO posts VALUES(7,7,'Do GraphQL Better Than Barack Obama', 'Vakowho fume jekuf do naamumas liez kewowo aviosubo vusatcef upuotadoj nozopi rima ufiki dolurdut atbo vazwinze afivaza digi.
', CURRENT_TIMESTAMP);
INSERT INTO posts VALUES(8,8,'Fascinating GraphQL Tactics That Can Help Your Business Grow', 'Ceplopus wulac piknikbih jihose ibzu ji dukhijo zoilaco zos tulak vohas dulved.
', CURRENT_TIMESTAMP);
INSERT INTO posts VALUES(9,9,'How I Improved My GraphQL  In One Day', 'Nungeblu lehun jon suid efi vomajopu wol muh gi esvu ekpu ohgabu kawlicba hezfo fib giltorug anu.
', CURRENT_TIMESTAMP);
INSERT INTO posts VALUES(10,10,'The Ultimate Guide To GraphQL', 'Ugisejuf ceggisih zilkewwut zeamu nu nan kebhi liav biap wa jizga buufe rannop remajhim.
', CURRENT_TIMESTAMP);


CREATE TABLE comments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, post INTEGER DEFAULT NULL, title VARCHAR(100) NOT NULL COLLATE BINARY, content VARCHAR(255) NOT NULL COLLATE BINARY, commentDate DATETIME NOT NULL, CONSTRAINT FK_5F9E962AF675F31B FOREIGN KEY (author_id) REFERENCES authors (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5F9E962A5A8A6C8D FOREIGN KEY (post) REFERENCES posts (id) NOT DEFERRABLE INITIALLY IMMEDIATE);
INSERT INTO comments VALUES(1,3,1,'It works!','The author is spot on!', CURRENT_TIMESTAMP);
INSERT INTO comments VALUES(2,4,1,'Valuable lesson','I learned tons from this simple lesson', CURRENT_TIMESTAMP);
DELETE FROM sqlite_sequence;
INSERT INTO sqlite_sequence VALUES('posts',10);
INSERT INTO sqlite_sequence VALUES('comments',2);
INSERT INTO sqlite_sequence VALUES('authors',10);
CREATE INDEX IDX_885DBAFABDAFD8C8 ON posts (author);
CREATE INDEX IDX_5F9E962AF675F31B ON comments (author_id);
CREATE INDEX IDX_5F9E962A5A8A6C8D ON comments (post);
COMMIT;
