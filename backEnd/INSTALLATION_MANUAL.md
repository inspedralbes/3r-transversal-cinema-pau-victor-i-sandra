# Manual d'instal·lació

## Entorn de desenvolupament

- Fer un git clone del repositori i obri-lo al Visual Studio Code o a un altre editor de codi.
- Importar els fitxer sql de la carpeta "backEnd > SQL" a la teva base de dades.
- Modificar el codi dels components vue que tenen un fetch amb (nomes) l'adreça IP de l'ordindor que contingui la part del backend.
- Amb l'editor, obrir la carpeta "frontEnd > vue" i en el terminal de l'editor, executar la comanda **npm install** i després **npm run dev**.
- Amb l'editor, obrir la carpeta backEnd > backendSymfony i en el terminal del editor, executar la comanda **composer install** i després **symfony server:start**.

## Entorn de producció

- Al servidor, clona la carpeta backEnd > *backendSymfony_dev* i *backEnd > backendSymfony_prod*. 
- Mou el fitxer de la carpeta *backendSymfony_prod* a la carpeta *backendSymfony_dev*.
- Al terminal, executar l'ordre **composer require symfony/requirements-checker**, **composer install --no-dev --optimize-autoloader**, **php bin/console cache:clear** i **composer require symfony/apache-pack** (quan et pregunta si hi confies, has de dir que sí).
- A la configuració del servidor, establir el DocumentRoot com el directori /public, per tal de millorar l'URL. 

