CREATE TABLE IF NOT EXISTS "media_types"
(
    [MediaTypeId] INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    [Name] NVARCHAR(120)
);
INSERT INTO media_types VALUES(1,'MPEG audio file');
INSERT INTO media_types VALUES(2,'Protected AAC audio file');
INSERT INTO media_types VALUES(3,'Protected MPEG-4 video file');
INSERT INTO media_types VALUES(4,'Purchased AAC audio file');
INSERT INTO media_types VALUES(5,'AAC audio file');
