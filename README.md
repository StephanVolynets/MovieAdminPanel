# Cinematic Showcase - Movie Admin Panel

A comprehensive web application for managing and showcasing top-rated films, featuring both user and administrative interfaces.

### Backend Dashboard
![Xnip2024-08-26_19-58-57](https://github.com/user-attachments/assets/14fe30a2-fb5a-43ff-aaf2-6c31be93d112)

### Frontend Interface
![Xnip2024-08-26_20-21-10](https://github.com/user-attachments/assets/35d41039-9bb0-45f2-9773-46050f097235)

## Project Overview

This web application combines dynamic content management with user authentication, providing a platform for movie enthusiasts to explore top-ranked films across various genres. The system features both a public-facing interface for users and a comprehensive admin panel for content management.

## Features

### Public Interface
- Browse top-rated films with detailed information
- Filter movies by genres/tags
- View comprehensive movie details including:
  - Director information
  - Release year
  - Rankings
  - Awards
  - Synopsis
- Responsive design for optimal viewing across devices

### Admin Panel
- Secure authentication system
- Comprehensive dashboard with:
  - Total Films counter
  - Directors counter
  - Total Awards tracker
  - Average Rating calculator
- Full CRUD operations:
  - Add new films
  - Edit existing entries
  - Delete films
  - Manage tags/genres

## Technical Stack

- **Frontend**: 
  - HTML5
  - CSS (Tailwind CSS + Custom styling)
  - JavaScript
  - Responsive design principles
  
- **Backend**:
  - PHP
  - SQLite Database
  - PDO for database operations

- **Authentication**:
  - Session-based authentication
  - Secure password hashing
  - Role-based access control

## Database Schema

### Main Tables
- `Top_Films`: Stores film details
- `Tags`: Manages genre categories
- `Film_Tags`: Handles many-to-many relationships
- `Users`: Manages user accounts
- `Sessions`: Handles user sessions

## Getting Started

### Prerequisites
- PHP 7.4 or higher
- SQLite3
- Web server (Apache/Nginx)

### Installation

1. Clone this repository:
```bash
git clone [repository-url]
```

2. Open as a Codespace on GitHub or as a container in VS Code

3. Start the development server:
   - From the **Run** menu, select **Start Debugging**
   - Visit http://127.0.0.1:8080/

### Admin Access
- Username: Admin
- Password: monkey

## Project Structure

```
├── db/
│   └── init.sql           # Database initialization
├── includes/
│   ├── db.php            # Database connection
│   ├── sessions.php      # Session management
│   └── admin/            # Admin components
├── pages/
│   ├── home.php          # Main landing page
│   ├── details.php       # Film details
│   └── admin_view_all.php # Admin dashboard
└── public/
    └── uploads/          # Media storage
```

## Security Features

- Password hashing
- Session management
- SQL injection prevention
- XSS protection
- CSRF protection

## Contributing

This project is maintained by Stephan Volynets. For major changes, please open an issue first to discuss what you would like to change.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments

- Cornell University INFO 2300 course
- All film data is for demonstration purposes

---

For any questions or support, please contact: svv6@cornell.edu
