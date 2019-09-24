#init5 wiki

## Installation

```bash
# Clone Repo
git clone https://github.com/linnit/Wiki.git

# Move to directory
cd Wiki

# Install packages
composer install

# Create database tables
php bin/console doctrine:migrations:migrate

# Load tables
php bin/console doctrine:fixtures:load

```