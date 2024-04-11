# Project Name

Welcome to Project Name! This repository contains [brief description of the project].
## Installation

Follow the steps below to set up the project on your local machine:
### 1. Clone the Project

Clone the project repository into any directory of your choice:

```bash
git clone https://github.com/pachecocmi/taskbackend.git
```
### 2. Set Up Laradock

Clone Laradock repository next to your project directory:

```bash
git clone https://github.com/Laradock/laradock.git
```
Navigate to the Laradock directory and rename .env.example to .env:

```bash
cd laradock
cp .env.example .env
```
Next, navigate to the nginx/sites directory within Laradock and remove the .example extension from the configuration files:

```bash
cd nginx/sites
mv laravel.conf.example laravel.conf
mv node.conf.example node.conf
mv symfony.conf.example symfony.conf
[Remove .example from default.conf.example if present]
```
Open default.conf and ensure the root is set to /var/www. This configuration ensures Nginx locates the Laravel index correctly.

Modify the server_name in laravel.conf to match your project's domain.
### 3. Run Docker Containers

Start the Docker containers using Docker Compose:

```bash
docker-compose up -d nginx mysql phpmyadmin redis workspace
```
### 4. Set Up Project Dependencies

Run NPM build to compile assets (if applicable):

```bash
npm run build
```
Run database migrations to create the required database tables:

```bash
php artisan migrate
```
### 5. Configuration

Update your project's .env file with the following settings:

```dotenv
DB_HOST=mysql
REDIS_HOST=redis
QUEUE_HOST=beanstalkd
```

Next, update the hosts file and add the project name
```bash
127.0.0.1 taskmanager.test
```

### 6. Running the Project

After above setup, http://taskmanager.test should show the website's welcome page.

### 7. Permissions

If you encounter Laravel log permission issues, set appropriate permissions for the storage directory:

```bash
chmod -R ugo+rw storage
```

## Usage

The following routes are available for interacting with tasks:
### List Tasks

```bash
GET /task/list
```

This route retrieves a list of tasks. You can optionally provide a query parameter status to filter tasks by status.


### Create Task

```bash
POST /task/create
```
Use this route to create a new task. The request should include a JSON body with description field for the task description.
### Update Task

```bash
POST /task/update
```

Update an existing task by providing the id of the task to be updated along with the new description field in the request body.
### Complete Task

```bash
POST /task/complete
```

Mark a task as completed by providing the id of the task to be marked as completed in the request body.
### Delete Task

```bash
POST /task/delete
```

Delete a task by providing the id of the task to be deleted in the request body.


## Additional Resources

For more detailed information on Laradock, refer to the <a href="https://laradock.io/getting-started/">Laradock documentation</a>.
For more information on Laravel and it's installation procedures, refer to the <a href="https://laravel.com/docs/11.x/installation">Laravel Documentation</a>.
