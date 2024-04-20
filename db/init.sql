-- database: ../test.sqlite
-- Note: Do not delete the line above! It is helpful for testing your init.sql file.
-- Create the tables for Top_Films, Tags, and Film_Tags
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
        'The Lord of the Rings: The Return of the King',
        'Peter Jackson',
        'Gandalf and Aragorn lead the World of Men against Sauron''s army to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring.',
        2003,
        9.0,
        '11 Oscars including Best Picture, Best Director',
        11
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
    ('Horror');

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
    (6, 2),
    -- The Lord of the Rings: The Return of the King has Action
    (6, 3),
    -- The Lord of the Rings: The Return of the King also has Fantasy
    (7, 1),
    -- Forrest Gump has Drama
    (7, 8),
    -- Forrest Gump also has Biography
    (8, 2),
    -- The Matrix has Action
    (8, 7),
    -- The Matrix also has Sci-Fi
    (9, 1),
    -- Goodfellas has Drama
    (9, 4),
    -- Goodfellas also has Crime
    (10, 6),
    -- The Silence of the Lambs has Thriller
    (10, 9);
