# MySQL Injection Test Environment

This project provides a test environment for experimenting with MySQL injection techniques.

## Setup Instructions

### Database Configuration
- Database name: `security_test_db`
- If you wish to use a different database name than `security_test_db`, you'll need to update it in both:
  - `seed.sql`
  - `index.php`
- No need to create the database first before running this code because the seed.sql will drop the database if exists then recreates it.

### Configuration Files
1. **package.json**
   - Update the username in the npm seed script
   - Password will be prompted during execution

2. **index.php**
   - Configure your database username and password

### Usage
1. Make sure you've configured as appropriately based on the above steps.
2. Make sure you've ran the seed (`npm run seed`)
3. Test `index.php` per the main `README.md` on SQL Injection.

## Security Warning
⚠️ This environment is for testing purposes only. Do not use in production.