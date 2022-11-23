#!/bin/bash
curl -o import/pho_doc.csv  --silent http://cadic.cnd.fr:8000/exl-img/export/pho_doc_20221123.csv
APP_ENV=dev /usr/bin/php bin/console doctrine:fixtures:load --append
