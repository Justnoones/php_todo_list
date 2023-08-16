CREATE DATABASE todo_list;

CREATE USER 'todo_list_admin' @'localhost' IDENTIFIED BY 'Wns@0853';

GRANT ALL ON todo_list.* TO 'todo_list_admin' @'localhost' WITH GRANT OPTION;

CREATE USER 'todo_list_admin' @'127.0.0.1' IDENTIFIED BY 'Wns@0853';

GRANT ALL ON todo_list.* TO 'todo_list_admin' @'127.0.0.1' WITH GRANT OPTION;

CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    address TEXT,
    gender CHAR(6)
);

CREATE TABLE lists (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    task_title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    dead_line DATE DEFAULT NULL,
    done BOOLEAN NULL DEFAULT 0,
    done_at DATE NULL,
    created_at DATE DEFAULT NOW(),
    updated_at DATE DEFAULT NOW(),
    INDEX USING BTREE (task_title),
    CONSTRAINT FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
);