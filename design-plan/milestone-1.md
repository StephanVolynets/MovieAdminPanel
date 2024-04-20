# Project 3, Milestone 1: **Team** Design Journey

[← Table of Contents](design-journey.md)

**Make the case for your decisions using concepts from class, as well as other design principles, theories, examples, and cases from outside of class (includes the design prerequisite for this course).**

You can use bullet points and lists, or full paragraphs, or a combo, whichever is appropriate. The writing should be solid draft quality.

## Catalog
> What will your catalog website be about? (1 sentence)

    - Our catalog will showcase a collection of the highest-ranked movies and documentaries, featuring critically acclaimed and award-winning titles from around the world.

## Narrow or Wide Screen
> How will your **consumer** user access this website? From a narrow or wide screen?

    - Considering our target audience likely consists of cinema enthusiasts who appreciate high-quality visuals and detailed content, our website will be optimized for wide screens to enhance the viewing experience.

## Catalog Design
> Sketch each page of your entire media catalog website
> Provide a brief explanation _underneath_ each sketch. (1 sentence per sketch)
> **Refer to consumer or administrator persona by name in each explanation.**

TODO: sketch(es) + explanation

EXAMPLE:

    Home Page: Features a curated list of top-rated films and documentaries with high-resolution images and quick access options. This design caters to Jamie's desire for visually engaging and easily accessible content.

    Consumer Entry Details: Provides exhaustive details on each film, such as trailers, full cast, awards, and critical reviews. Jamie appreciates the depth of information available to explore a film’s artistic merit.

    Admin View All / Filter by Tag: Displays a comprehensive list with filtering options for genre or awards, facilitating efficient catalog management. Alex can swiftly update and manage the catalog according to the latest rankings and awards.

    Admin Insert Entry: A form interface for adding new entries to the catalog, ensuring ease of use and efficiency. Alex adds new top-ranked films and documentaries seamlessly.

    Admin Edit Entry / Tag / Untag: Offers a straightforward interface for editing film details, tagging, and untagging. Alex maintains accurate and current details for all listings.


## Catalog Design Patterns
> Explain how your design employs common catalog design patterns. (1-2 sentences)

    Our design employs a combination of grid layouts for browsing films and detailed accordion views for in-depth information, utilizing visual hierarchy and spatial relationships to guide the user's focus and improve informational accessibility.

## URL Design
> Plan your HTTP routing.
> List each route and the PHP file for each route.

| Page                                     | Route          | PHP File       |
| ---------------------------------------- | -----------    | -------------- |
| home / consumer view all / filter by tag | /              | pages/home.php |
| consumer entry details                   | /details/:id   | pages/details.php |
| admin view all / filter by tag           | /admin         | pages/admin_view_all.php|
| admin insert entry                       | /admin/new     | pages/admin_new.php |
| admin edit entry / tag / untag           | /admin/edit/:id| pages/admin_edit.php |
| login                                    | /login         | pages/login.php |



> Explain why these routes (URLs) are usable for your persona. (1 sentence)

This URL design is user-friendly, allowing Jamie to easily navigate and explore films, while Alex benefits from straightforward paths to manage content effectively.




## Database Schema
> Plan the structure of your database. You may use words or a picture.
> A bulleted list is probably the simplest way to do this.
> Include constraints for each field.

# Table: Films

    film_id: INTEGER {PRIMARY KEY, AUTOINCREMENT},
    title: TEXT {NOT NULL},
    director: TEXT {NOT NULL},
    synopsis: TEXT,
    release_year: INTEGER,
    ranking: REAL,
    awards: TEXT

## Table: Tags

    tag_id: INTEGER {PRIMARY KEY, AUTOINCREMENT},
    name: TEXT {NOT NULL}

## Table: Film_Tags

    film_id: INTEGER {FOREIGN KEY(Top_Films.film_id)},
    tag_id: INTEGER {FOREIGN KEY(Tags.tag_id)}
    This schema efficiently supports the catalog’s functionality with relational integrity, allowing complex queries and updates without duplicating data, adhering to best practices in database design.

## Contributors

I affirm that I have contributed to the team requirements for this milestone.

Consumer Lead: Stephan Volynets

Admin Lead: Stephan Volynets


[← Table of Contents](design-journey.md)
