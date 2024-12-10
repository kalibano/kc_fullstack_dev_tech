
-- down
DROP TABLE IF EXISTS courses;

-- up

CREATE TABLE IF NOT EXISTS courses (
    course_id VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_preview VARCHAR(255) NOT NULL,
    category_id VARCHAR(255) NOT NULL
);


