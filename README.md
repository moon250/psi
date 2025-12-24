# ψ Psi 

Psi is my personnal, home-made search engine. It features :
- 🇬 Google search
- 🦆 Duckduckgo search
- 🚫 Website blacklisting
- 🔫 [Bangs](https://github.com/moon250/psi/blob/master/app/Services/Search/BangService.php#L12) (For example : "cute cats !g" redirects you to google while searching for cute cat pictures)
- 🌗 Light (Atom One Light) and Dark (Tokyo Night) theme

> [!NOTE]  
> Duckduckgo search may or may not work on your machine, depending if it flags you as a bot or not.
> You may disable completely DDG search to improve performances by commenting the corresponding provider in the [SearchService](https://github.com/moon250/psi/blob/master/app/Services/Search/SearchService.php#L21)

## How to use
1. Clone this repo
```shell
git clone https://github.com/moon250/psi
```
2. Build js files :
```shell
yarn build
```
3. Run docker container in the background :
```shell
docker-compose up -d --build
```
4. Copy and fill the .env
```shell
cp .env.example .env 
php artisan key:generate --ainsi
```
5. Install php dependancies
```shell
composer install
```
6. Fill [Unsplash API key](https://unsplash.com/oauth/applications) in `.env` file

## 🔋 Technologies used
- [Laravel](https://laravel.com)
- [Unsplash API](https://unsplash.com/developers)

Made with ♥️ by [moon250](https://github.com/moon250)

Copyright ©️ 2024 moon250. Licensed under [MIT](https://github.com/moon250/psi/blob/master/LICENSE) license.
