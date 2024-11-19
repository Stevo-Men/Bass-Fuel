SET search_path TO public;

-- Table pour vos produits
-- Vous devez insérer vos propres données selon les produits de votre site (au moins 12).
--      name = Nom du produit
--      description = Longue description
--      image_url = Lien vers l'image d'un site externe ou pointant sur un dossier de votre site (e.g. /public/images/product1.png)
--      price = Prix du produit
create table if not exists product (
    product_id serial not null primary key,
    name varchar(255) not null,
    description text not null,
    image_url varchar(1024) not null,
    price decimal(12, 2) not null
);

-- Table pour les produits populaires affichés sur la page d'accueil
--      product_id = ID provenant de la table products
--
--      NOTE: Il faudra faire un SELECT avec un JOIN entre top_products et products pour récupérer les informations
create table if not exists top_product (
    product_id serial not null primary key,
    foreign key(product_id) references product(product_id)
);

-- Table pour vos utilisateurs
-- C'est au moment de passer la commande qu'on va créer l'utilisateur.
--      firstname = Prénom
--      lastname = Nom de famille
--      email = Courriel
create table if not exists customer (
    customer_id serial not null primary key,
    firstname varchar(255) not null,
    lastname varchar(255) not null,
    email varchar(255) not null
);

-- Table pour vos commandes
-- C'est au moment de passer la commande qu'on va créer la commande.
--      customer_id = Le ID de l'utilisateur (e.g. l'utilisateur doit être inséré avant pour obtenir son ID)
--      country = Pays
--      street = Rue complète (123 rue Fausse)
--      city = Ville
--      zip_code = Code postal
--      total = Total de la commande
create table if not exists "order" (
    order_id serial not null primary key,
    customer_id int not null,
    country varchar(255) not null,
    street varchar(512) not null,
    city varchar(255) not null,
    zip_code varchar(6) not null,
    total decimal(12, 2)  not null,
    foreign key(customer_id) references customer(customer_id)
);

-- Table pour vos commandes
-- C'est au moment de passer la commande qu'on va créer les articles de la commande.
--      price = Prix du produit
--      name = Nom du produit
--      quantity = Quantité achetée
--      order_id = Le ID de la commande
--      product_id = Le ID du produit commandé
create table if not exists order_item (
    order_item_id serial not null primary key,
    price decimal(12, 2)  not null,
    name varchar(255) not null,
    quantity int not null,
    order_id int not null,
    product_id int not null,
    foreign key(order_id) references "order"(order_id),
    foreign key(product_id) references product(product_id)
);