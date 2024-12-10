-- down
DROP TABLE IF EXISTS categories;

-- up

CREATE TABLE IF NOT EXISTS categories (
    id VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    parent VARCHAR(255) NULL
);

