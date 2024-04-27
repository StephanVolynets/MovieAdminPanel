-- database: ../test.sqlite
-- Note: Do not delete the line above! It is helpful for testing your init.sql file.
-- Setting up keys in tables:
-- PRIMARY KEY: Unique ID for each row, like film_id in Top_Films or tag_id in Tags
-- FOREIGN KEY in Film_Tags links back to Top_Films and Tags using film_id and tag_id
-- FOREIGN KEY setup means if we delete a film or tag, all related entries in Film_Tags vanish too (ON DELETE CASCADE)
-- Films Table
CREATE TABLE IF NOT EXISTS Top_Films (
    film_id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    director TEXT NOT NULL,
    synopsis TEXT NOT NULL,
    release_year INTEGER NOT NULL,
    ranking REAL NOT NULL,
    awards TEXT NOT NULL,
    award_count INTEGER NOT NULL
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

-- Users Table
CREATE TABLE users (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    username TEXT NOT NULL,
    password TEXT NOT NULL,
    is_admin INTEGER NOT NULL DEFAULT 0
);

-- create the sessions table
CREATE TABLE IF NOT EXISTS sessions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    session TEXT NOT NULL,
    last_login TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Seed data for Top_Films
INSERT INTO
    Top_Films (
        title,
        director,
        synopsis,
        release_year,
        ranking,
        awards,
        award_count
    )
VALUES
    (
        'Inception',
        'Christopher Nolan',
        'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a CEO.',
        2010,
        8.8,
        'Academy Award for Best Cinematography',
        1
    ),
    (
        'The Shawshank Redemption',
        'Frank Darabont',
        'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
        1994,
        9.3,
        '7 Oscar nominations',
        7
    ),
    (
        'Spirited Away',
        'Hayao Miyazaki',
        'During her family''s move to the suburbs, a sullen 10-year-old girl wanders into a world ruled by gods, witches, and spirits, and where humans are changed into beasts.',
        2001,
        8.6,
        'Oscar for Best Animated Feature',
        1
    ),
    (
        'The Godfather',
        'Francis Ford Coppola',
        'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
        1972,
        9.2,
        'Oscar for Best Picture',
        1
    ),
    (
        'Pulp Fiction',
        'Quentin Tarantino',
        'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine in four tales of violence and redemption.',
        1994,
        8.9,
        'Palme d''Or, Oscar for Best Original Screenplay',
        2
    ),
    (
        'Forrest Gump',
        'Robert Zemeckis',
        'The presidencies of Kennedy and Johnson, the events of Vietnam, Watergate, and other historical events unfold through the perspective of an Alabama man with an IQ of 75.',
        1994,
        8.8,
        '6 Oscars including Best Picture, Best Actor',
        6
    ),
    (
        'The Matrix',
        'The Wachowskis',
        'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.',
        1999,
        8.7,
        '4 Oscars including Best Visual Effects',
        4
    ),
    (
        'Goodfellas',
        'Martin Scorsese',
        'The story of Henry Hill and his life in the mob, covering his relationship with his wife Karen Hill and his mob partners Jimmy Conway and Tommy DeVito.',
        1990,
        8.7,
        '1 Oscar, 5 Oscar nominations',
        6
    ),
    (
        'The Silence of the Lambs',
        'Jonathan Demme',
        'A young F.B.I. cadet must receive the help of an incarcerated and manipulative cannibal killer to help catch another serial killer, a madman who skins his victims.',
        1991,
        8.6,
        '5 Oscars including Best Picture, Best Actor, Best Actress',
        5
    ),
    (
        'The Shining',
        'Stanley Kubrick',
        'A family heads to an isolated hotel for the winter where a sinister presence influences the father into violence, while his psychic son sees horrific forebodings from both past and future.',
        1980,
        8.4,
        '1 Oscar nomination',
        1
    ),
    (
        'The Dark Knight',
        'Christopher Nolan',
        'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
        2008,
        9.0,
        '2 Oscars, 8 Oscar nominations',
        10
    ),
    (
        'Interstellar',
        'Christopher Nolan',
        'A team of explorers travel through a wormhole in space in an attempt to ensure humanity''s survival.',
        2014,
        8.6,
        '1 Oscar win, 4 Oscar nominations',
        5
    );

-- Seed data for Tags
INSERT INTO
    Tags (name)
VALUES
    ('Drama'),
    ('Action'),
    ('Fantasy'),
    ('Crime'),
    ('Comedy'),
    ('Thriller'),
    ('Sci-Fi'),
    ('Biography'),
    ('Horror'),
    ('Superhero');

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
    (4, 4),
    -- The Godfather also has Crime
    (5, 4),
    -- Pulp Fiction has Crime
    (5, 5),
    -- Pulp Fiction also has Comedy
    (6, 1),
    -- Forrest Gump has Drama
    (6, 8),
    -- Forrest Gump also has Biography
    (7, 2),
    -- The Matrix has Action
    (7, 7),
    -- The Matrix also has Sci-Fi
    (8, 1),
    -- Goodfellas has Drama
    (8, 4),
    -- Goodfellas also has Crime
    (9, 6),
    -- The Silence of the Lambs has Thriller
    (9, 9),
    -- The Silence of the Lambs also has Horror
    (10, 1),
    -- The Shining has Drama
    (10, 6),
    -- The Shining also has Thriller
    (10, 9),
    -- The Shining also has Horror
    (11, 2),
    -- The Dark Knight has Action
    (11, 3),
    -- The Dark Knight also has Fantasy
    (11, 6),
    -- The Dark Knight also has Thriller
    (11, 10),
    -- The Dark Knight also has Superhero
    (12, 2),
    -- Interstellar has Action
    (12, 7);

-- Interstellar also has Sci-Fi
INSERT INTO
    users (name, username, password, is_admin)
VALUES
    (
        'Admin',
        'admin',
        '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.',
        1
    );
