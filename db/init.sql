-- database: ../test.sqlite
-- Note: Do not delete the line above! It is helpful for testing your init.sql file.
-- Create the tables for Top_Films, Tags, and Film_Tags
-- Films Table
CREATE TABLE IF NOT EXISTS Top_Films (
    film_id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    director TEXT NOT NULL,
    synopsis TEXT,
    release_year INTEGER,
    ranking REAL,
    awards TEXT
);

-- Tags Table
CREATE TABLE IF NOT EXISTS Tags (
    tag_id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);

-- Film_Tags Table
CREATE TABLE IF NOT EXISTS Film_Tags (
    film_id INTEGER,
    tag_id INTEGER,
    PRIMARY KEY (film_id, tag_id),
    FOREIGN KEY (film_id) REFERENCES Top_Films(film_id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES Tags(tag_id) ON DELETE CASCADE
);

-- Seed data for Top_Films
INSERT INTO
    Top_Films (
        title,
        director,
        synopsis,
        release_year,
        ranking,
        awards
    )
VALUES
    (
        'Inception',
        'Christopher Nolan',
        'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a CEO.',
        2010,
        8.8,
        'Academy Award for Best Cinematography'
    ),
    (
        'The Shawshank Redemption',
        'Frank Darabont',
        'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
        1994,
        9.3,
        '7 Oscar nominations'
    ),
    (
        'Spirited Away',
        'Hayao Miyazaki',
        'During her family’s move to the suburbs, a sullen 10-year-old girl wanders into a world ruled by gods, witches, and spirits, and where humans are changed into beasts.',
        2001,
        8.6,
        'Oscar for Best Animated Feature'
    ),
    (
        'The Godfather',
        'Francis Ford Coppola',
        'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
        1972,
        9.2,
        'Oscar for Best Picture'
    );

-- Seed data for Tags
INSERT INTO
    Tags (name)
VALUES
    ('Drama'),
    ('Action'),
    ('Fantasy'),
    ('Crime');

-- Seed data for Film_Tags
INSERT INTO
    Film_Tags (film_id, tag_id)
VALUES
    (1, 2),
    -- Inception has Action
    (2, 1),
    -- The Shawshank Redemption has Drama
    (3, 3),
    -- Spirited Away has Fantasy
    (4, 1),
    -- The Godfather has Drama
    (4, 4);

-- The Godfather also has Crime
