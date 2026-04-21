# MMC Voter Utility

Voter search portal for Dr. Sanjaykumar S. Deshmukh's MMC Elections 2026 campaign.

Built with **Laravel 13** + **Livewire 4**.

## Features

- Public voter search (by name or mobile number)
- Downloadable & shareable PDF voting slips
- Admin panel with dashboard, voter management, branch management
- Excel import (supports up to 1 lakh voters, queue-based with status polling)
- Admin user management

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed        # creates default admin user
php artisan queue:work     # required for Excel imports
```
