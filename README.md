# Guide to Using the Laravel  Chat Demo App

## Quick Start

1. **Clone or Download**  
   Download or clone this repository to your server.

2. **Install Dependencies**  
   Run the following command to install the necessary packages:
   ```bash
   composer install
   ```

3. **Setup Environment File**  
   Copy the example environment file and modify it:
   ```bash
   cp .env.example .env
   ```
   - Create a database and update the `.env` file with your database details.
   - Add your Pusher credentials in the `.env` file.

4. **Run Migrations and Seeding**  
   Migrate the database and seed it with sample data:
   ```bash
   php artisan migrate --seed
   ```

5. **Generate Application Key**  
   Generate the Laravel application key:
   ```bash
   php artisan key:generate
   ```

6. **Install Frontend Dependencies**  
   Install and build the frontend assets:
   ```bash
   npm install && npm run dev
   ```

7. **Start the Application**  
   Start the Laravel development server:
   ```bash
   php artisan serve
   ```

8. **Run Queue Worker**  
   Before using the chat app, start the queue worker:
   ```bash
   php artisan queue:work
   ```

9. **Access the App**  
   - Run the following commands to ensure the app is running:
     ```bash
     npm run dev
     php artisan serve
     ```
   - Choose a user from the database and log in to start chatting.

