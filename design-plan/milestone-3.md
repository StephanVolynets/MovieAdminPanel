Here's your content formatted in Markdown:

### File Upload - Types of Files

- The website will allow users to upload image files (e.g., JPG, PNG, GIF).
- File extensions allowed: `.jpg`, `.jpeg`, `.png`, `.gif`

### File Upload - Updated DB Schema

```sql
CREATE TABLE top_films (
    film_id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    synopsis TEXT,
    release_year INTEGER,
    director TEXT,
    ranking REAL,
    image_extension TEXT
);
```

- Added `image_extension` column to store the file extension of the uploaded image.

### File Upload - File Storage

- Uploaded files will be stored in the `public/uploads/top_films` subfolder.

### File Upload - Path and URL

- File System Storage Path: `public/uploads/top_films/154.jpg`
- Resource URL: `<img src="public/uploads/top_films/154.jpg">`

### File Upload - Form Input

```html
<input type="file" name="image" accept="image/*" />
```

### File Upload - PHP File Upload Data

```php
$_FILES['image']['name']
```

### Filtering by a Tag - Query String Parameters

- Query string for filtering by a tag: `?tag=NAME`

### Filtering by a Tag - SQL Query Plan

```sql
SELECT tf.*, GROUP_CONCAT(t.name) AS tags
FROM Top_Films tf
LEFT JOIN Film_Tags ft ON tf.film_id = ft.film_id
LEFT JOIN Tags t ON ft.tag_id = t.tag_id
WHERE t.name = :selectedTag
GROUP BY tf.film_id
ORDER BY tf.ranking DESC;
```
