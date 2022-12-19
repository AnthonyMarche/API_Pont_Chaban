 # Api Pont Chaban Delmas
 
 ## Description
 
This repository uses the API of Bordeaux Métropole on the closures of the Chaban Delmas bridge :  
https://opendata.bordeaux-metropole.fr/explore/dataset/previsions_pont_chaban/api/

This project is based on Symfony + twig and his style is based on Bootstrap.

This API does not allow to see the next closings, a fictitious date has been set: 09/15/2022 at 09:15:18 allowing to see the next closings from this date.

A countdown is also present in order to know in how long the next closing will take place from the fictitious date.

It is possible to filter the data displayed:
- by date
- by reason
- by reason on a chosen date


## Steps to launch the project on your computer
1. Clone the repo from Github.
2. Run `composer install`.
3. Run `symfony server:start`.
4. Run `yarn dev-server`.
5. Go to `http://127.0.0.1:8000/` with your favorite browser.

---
At the date of writing this ReadMe (18/12/2022), the data retrieved by the API begins at the beginning of 2022 and ends on 11/06/2022.

If you wish to have more data or less data, it is possible to change the dummy date by modifying the $today property in :  
`/src/Controller/Service/apiData.php`

In order to refine the fictitious date according to your wishes, it is advisable to indicate a fictitious date located between the dates indicated above or to consult the API link to find out from which date to which date it returns data .
