# --- Stage 1: Build Assets (Frontend/Vite) ---
# Kalau ini murni API Backend, stage ini bisa diskip.
# Tapi kalau ada admin panel (Filament) yg butuh build assets, pakai ini.
FROM node:20-alpine as frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# --- Stage 2: Runtime (PHP + Nginx) ---
FROM php:8.2-fpm-alpine

# 1. Install Library System yang dibutuhkan Laravel
RUN apk add --no-cache \
    nginx \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    oniguruma-dev \
    mysql-client

# 2. Install Ekstensi PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 3. Install Composer (ambil dari image composer resmi)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Setup Nginx (Kita timpa config default)
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# 5. Setup Folder Kerja
WORKDIR /var/www/html

# 6. Copy Codingan Laravel (Hati-hati, jangan copy .env)
COPY . .
# Copy hasil build frontend dari Stage 1 (jika ada)
COPY --from=frontend /app/public/build public/build

# 7. Install Dependencies PHP (Production Mode)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 8. Permission (Agar Nginx bisa tulis log/cache)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# 9. Config Entrypoint (Perintah yg jalan saat container start)
# Kita buat script kecil untuk jalanin Nginx & PHP-FPM barengan
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
