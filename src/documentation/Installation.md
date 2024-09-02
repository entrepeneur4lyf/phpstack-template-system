# Installation Guide

This guide provides comprehensive instructions for installing and setting up the phpStack Template System in your PHP project.

## Requirements

- PHP 7.4 or higher
- Composer
- Redis (optional, for distributed caching)
- Web server (e.g., Apache, Nginx) with PHP support

## Installation Steps

1. **Install via Composer**:
   Open your terminal, navigate to your project directory, and run:
   ```bash
   composer require phpStack/template-system
   ```

2. **Verify Installation**:
   After installation, verify that the package has been added to your `composer.json` file and that the necessary files are present in the `vendor/phpStack` directory.

3. **Configure PHP Environment**:
   - Ensure your PHP version is 7.4 or higher:
     ```bash
     php -v
     ```
   - Enable required PHP extensions:
     - OpenSSL
     - PDO
     - Mbstring
     - Tokenizer
     - XML
     - Ctype
     - JSON
   
   You can check enabled extensions with:
   ```bash
   php -m
   ```

4. **Web Server Configuration**:
   - For Apache, ensure mod_rewrite is enabled and AllowOverride is set to All in your virtual host configuration.
   - For Nginx, add the following to your server block:
     ```nginx
     location / {
         try_files $uri $uri/ /index.php?$query_string;
     }
     ```

5. **Set Up Directory Permissions**:
   Ensure that your web server has write permissions to the cache and log directories:
   ```bash
   chmod -R 775 storage/cache
   chmod -R 775 storage/logs
   ```

6. **Configure Environment Variables**:
   Copy the `.env.example` file to `.env` and update the values:
   ```bash
   cp .env.example .env
   ```
   Edit the `.env` file with your specific configuration settings.

7. **Generate Application Key**:
   Run the following command to generate a unique application key:
   ```bash
   php artisan phpstack:key-generate
   ```

8. **Set Up Redis (Optional)**:
   If you plan to use distributed caching:
   - Install Redis on your server
   - Update the REDIS_* variables in your `.env` file

9. **Run Database Migrations (If Applicable)**:
   If your project uses a database, run:
   ```bash
   php artisan migrate
   ```

10. **Compile Assets (If Applicable)**:
    If your project uses frontend assets, compile them:
    ```bash
    npm install
    npm run dev
    ```

11. **Verify Installation**:
    - Run the built-in PHP server:
      ```bash
      php -S localhost:8000 -t public
      ```
    - Open a web browser and navigate to `http://localhost:8000`
    - You should see the phpStack welcome page

12. **Run Tests**:
    Execute the test suite to ensure everything is working correctly:
    ```bash
    ./vendor/bin/phpunit
    ```

## Post-Installation Steps

1. **Review Security Settings**:
   Check the [Security Best Practices](Security_Best_Practices.md) guide to ensure your installation is secure.

2. **Explore Examples**:
   Review the examples in the `Examples` directory to familiarize yourself with the system's features.

3. **Configure for Production**:
   Before deploying to production, make sure to:
   - Set `APP_ENV=production` and `APP_DEBUG=false` in your `.env` file
   - Optimize autoloader: `composer install --optimize-autoloader --no-dev`
   - Cache configuration: `php artisan config:cache`
   - Cache routes: `php artisan route:cache`

4. **Set Up Monitoring**:
   Consider setting up application monitoring and error tracking for production environments.

For more detailed configuration options and advanced setup, refer to the [Configuration Guide](Configuration.md) and [Advanced Configuration](AdvancedConfiguration.md) documents.

If you encounter any issues during installation, please consult the [Troubleshooting Guide](Troubleshooting.md) or reach out to our support team.
