 # Api Pont Chaban Delmas
 
 ## Description
 
This repository uses the API of Bordeaux Métropole on the closures of the Chaban Delmas bridge :  
https://opendata.bordeaux-metropole.fr/explore/dataset/previsions_pont_chaban/api/

This project is based on Symfony + twig and his style is based on Bootstrap.  
It allows you to visualize all the future traffic closures of the Chaban Delmas Bridge from today's date.

A countdown is also present in order to know in how long the next closing will take place from the current date.

It is possible to filter the data displayed:
- by date
- by reason
- by reason on a chosen date


## Steps to launch the project on your computer

### Prerequisites

- Check if composer is installed.
- Check if yarn & node are installed.

### Install

1. Clone the repo from Github.
2. Run `composer install`.
3. Run `yarn install`.

### Start the project

1. Run `symfony server:start`.
2. Run `yarn build`.
3. Go to `http://127.0.0.1:8000/` with your favorite browser.
