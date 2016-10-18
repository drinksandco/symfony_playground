CREATE TABLE users
(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR NOT NULL,
    surname VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    username VARCHAR NOT NULL
);
CREATE UNIQUE INDEX users_id_uindex ON users (id);
