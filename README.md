# Recruitment Task for Fooz

Solution for the recruitment task for Fooz. The task consists of 6 points:

## Introduction

A customer asks for some changes to his WordPress website which uses the default TwentyTwenty theme. Please prepare proper file structure and implement all the changes listed below:

## Task 1

There are some styling changes required, and there is a high chance that there will be a lot more styling changes needed in the future. Where would you insert your custom CSS rules?

## Task 2

Load a custom JavaScript located in `assets/js/scripts.js` (file depends on jQuery and should be loaded in the footer rather than header).

## Task 3

Write a code which will add custom post type “Books” with taxonomy “Genre”. Custom post type must have slug “library” and translatable labels. Taxonomy must have slug “book-genre” and translatable labels.

## Task 4

Create custom templates for:

1. Single Book page – displays Book title, image, book genre, date.
2. Genre page (taxonomy) – displays list of Books from specific genre (5 books per page, please implement pagination or simple links to show next/previous page).

## Task 5

Create two shortcodes:

1. First one should return the title of most recent book.
2. Second one will return a list of 5 books from given Genre (user must be able to specify genre, let's assume it's just term ID). Returned books should be sorted alphabetically.

## Task 6 - Bonus

Create an AJAX callback returning 20 books in JSON format. JSON should only contain the following fields: name, date, genre, excerpt. You can use `scripts.js` file created previously in Task 2 to make an AJAX call.


## Installing and setup

1. Put files in `themes/` directory in your WordPress files.
2. Install dependencies two commands:

    ```
    npm install
    composer update
    ```

3. Enable theme in WordPress settings.
4. Done

## Commands

Building the code:

```
npm run build
```

Building the code for production:

```
npm run buildprod
```

## Running project via Browser Sync

Set your proxy and port in new `.browsersync.config.json` file and run command:

```
npm run watch
```

## Features

- webpack for JS bundling
- SCSS compiling
- PHP class autoloader
- Image conventer

## Files structure

- Logic and PHP scripts in `inc/`. Each logical part of the code should have its own class, that is initialized in `functions.php`. Global namespace for classes is `Fooz`.
- Global JS scripts in `assets/js/`.
- Global SCSS styles in `assets/scss/`.
- General theme parts in `templates/`and `patterns/`.
- `functions.php` is to be used only as class loader. Everything else should be kept in separate classes in `inc/`.


## Conventions

### Coding

- CSS classes: **BEM**.
- SCSS variables: **snake_case**.
- PHP variables: **snake_case**.
- JS variables: **camelCase**.
- Comment your code - I recommend using a plugin - **Better Comments** with Visual Studio Code.
- Break code into small chunks, in **separate files**
