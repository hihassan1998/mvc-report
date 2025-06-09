# MVC Report

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/hihassan1998/mvc-report/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/hihassan1998/mvc-report/?branch=main)

[![Code Coverage](https://scrutinizer-ci.com/g/hihassan1998/mvc-report/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/hihassan1998/mvc-report/?branch=main)

[![Build Status](https://scrutinizer-ci.com/g/hihassan1998/mvc-report/badges/build.png?b=main)](https://scrutinizer-ci.com/g/hihassan1998/mvc-report/build-status/main)

This is a student project developed as part of the MVC course at BTH (Blekinge Institute of Technology). The project is built using PHP and follows the Symfony framework structure with a clear MVC architecture.

## Project Structure

- `/src/Controller` – Contains all controllers responsible for handling business logic.
- `/src/Dice` – Contains the Pig game's Dice class and its extended classes for kmom02.
- `/src/Card` – Contains the Card game's Card class and its extended classes for kmom02.
- `/templates` – Stores view files (HTML/Twig templates).
- `/templates/<app name>` – Stores view files (HTML/Twig templates).
- `/public` – The web root and application entry point via `index.php`.
- `composer.json` – Manages PHP dependencies (similar to `package.json` in JavaScript).

## Content
This following section outlines the contributions made to the repository throughout the different course modules.

- **kmom01**: Introduction to the framework. Component and template creation with a "crazy" demo page and project setup for upcoming course modules.
- **kmom02**: Object-Oriented Programming – Includes the "Pig" game and a simple card game, both built using OOP principles.
- **kmom07**: Object-Oriented Programming – Includes the "Project -  Sustainable Development Goals Visualization " a website with data added dynamically using Sqlite ORM database, Javascript, Chart.js and static content using .html.twig files.

###  Sustainable Development Goals Visualization
This project is part of the MVC course at BTH. It focuses on the 17 Global Goals, with emphasis on:

- Goal 7 – Affordable and Clean Energy
- Goal 12 – Responsible Consumption and Production

The app is built with Symfony following the MVC pattern, and it uses Doctrine ORM for database interaction.

#### Features
- Visualizes sustainability indicators with Chart.js
- Shows national data from SCB (Statistics Sweden)
- Uses SQLite for local data storage
- Interactive charts and views for easier understanding
  
#### Goal 7 Highlights
- Displays renewable energy use by sector (2005–2017)
- Compares total renewable use with national energy consumption
- Includes links to official SCB data sources

#### Goal 12 Highlights
- Presents emissions data by sector, including private and public consumption
- Compares Swedish and global emissions per category
- Shows trends and highlights areas with the highest impact

## Getting Started

1. Clone the repository or upload the files to your web directory.
2. Run `composer install` to install the required dependencies.
3. Make sure your `.htaccess` file is properly configured for your web server environment.


## Contributions

Contributions are welcome! 