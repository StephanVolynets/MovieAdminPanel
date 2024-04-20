# Project 3, Milestone 2: **Consumer** Design Journey

[← Table of Contents](../design-journey.md)


## Milestone 1 Feedback Revisions
> Explain what you revised in response to the Milestone 1 feedback (1-2 sentences)
> If you didn't make any revisions, explain why.

    I had no feedback, but after I completed milestone I made style changes like using tailwind and bootstrap to enhance the look of my tables and button by making it more spaced out and feature larger font sizes for better readability.

## Details Page URL
> Design the URL for the consumer's detail page.
> What is the URL for the detail page?

    1. "/movie-details"

 git config --global user.email "svv6@cornell.edu"
  git config --global user.name "Stephan Volynets"

> What query string parameters will you include in the URL?

| Query String Parameter Name       | Description       |
| --------------------------------- | ----------------- |
| 'id'                              | ?id=123 where "123"|
|                                   | is the unique is  |
|                                   | the unique identifier (movie ID) from DB |



## SQL Query Plan
> Plan the SQL query to retrieve a record from one of your query string parameters.

```
SELECT title, synopsis, director, release_year, duration, genre, rating, awards
FROM movies
WHERE movie_id = :id;
```

> Plan the SQL query to retrieve all tag names for a specific record.

```
SELECT tag_name
FROM tags
JOIN movie_tags ON tags.tag_id = movie_tags.tag_id
WHERE movie_tags.movie_id = :id;
```


## Contributors

I affirm that I am submitting my work for the consumer requirements in this milestone.

Consumer Lead: Stephan Volynets


[← Table of Contents](../design-journey.md)
