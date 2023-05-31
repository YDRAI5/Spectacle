<?php

session_start(); // initialise la session

require_once '../config/bdd.php';

/* **************************************** CATEGORY **************************************** */

    /* ******************** category - create ******************** */

        if (isset($_GET['action']) && $_GET['action'] == 'artiste-create') {

            $name = strip_tags(trim($_POST['name'])); // nnettoyage des variables : enlève les balises et espaces blancs

            if (!empty($name) && strlen($name) <= 45) { // si le nom n'est pas vide et est inférieur à 45 caractères
                $req = $bdd->prepare('INSERT INTO artiste (nom) VALUES (:name)'); // prépare une requête SQL
                $req->bindParam(':name', $name, PDO::PARAM_STR); // associé la valeur $name à :name
                $req->execute(); // exécute la requête
                $_SESSION['notification'] = [
                    'type' => 'success',
                    'message' => 'Les artistes ont bien été créée'
                ]; // message de succès
            } else {
                $_SESSION['notification'] = [
                    'type' => 'danger',
                    'message' => 'Une erreur est survenue lors de la création de la catégorie'
                ]; // message d'erreur
            }

            header('Location: ../index.php?page=admin'); // redirection
        }

    /* ******************** category - update ******************** */

        if (isset($_GET['action']) && $_GET['action'] == 'category-update') {
            
        }

    /* ******************** category - delete ******************** */

        if (isset($_GET['action']) && $_GET['action'] == 'artiste-delete') {
            $req = $bdd->prepare('DELETE FROM artiste WHERE id = :id');
            $req->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            $req->execute();
            $_SESSION['notification'] = [
                'type' => 'success',
                'message' => 'Les artiste ont bien été supprimée'
            ];
            header('Location: ../index.php?page=admin');
        }

/* **************************************** ARTICLE **************************************** */

    /* ******************** article - create ******************** */

        if (isset($_GET['action']) && $_GET['action'] == 'salle-create') {
            
            // nettoyage des données
            $title = strip_tags(trim($_POST['title']));
            $content = strip_tags(trim($_POST['content']));
            $alt = strip_tags(trim($_POST['alt']));
            $published = strip_tags(trim($_POST['published']));
            $author = strip_tags(trim($_POST['author']));
            $category = (INT)$_POST['category'];

            $errorMessage = '<p>Merci de vérifier les points suivants :</p>';
            $validation = true;

            // vérification du titre
            if (empty($title) || strlen($title) > 100) {
                $errorMessage .= '<p>- le champ "titre" est obligatoire et doit comporter moins de 100 caractères.</p>';
                $validation = false;
            }

            // vérification du contenu
            if (empty($content) || strlen($content) > 65535) {
                $errorMessage .= '<p>- le champ "contenu" est obligatoire et doit comporter moins de 65535 caractères.</p>';
                $validation = false;
            }

            // vérification du texte alternatif
            if (empty($alt) || strlen($alt) > 255) {
                $errorMessage .= '<p>- le champ "texte alternatif" est obligatoire et doit comporter moins de 255 caractères.</p>';
                $validation = false;
            }

            // vérification de publié
            if (empty($published) || ($published != true && $published != false)) {
                $errorMessage .= '<p>- le champ "publié" est obligatoire.</p>';
                $validation = false;
            }

            // vérification de l'auteur
            if (empty($author) || strlen($author) > 100) {
                $errorMessage .= '<p>- le champ "auteur" est obligatoire et doit comporter moins de 100 caractères.</p>';
                $validation = false;
            }

            // vérification de la catégorie
            if (empty($category) || !is_int($category)) {
                $errorMessage .= '<p>- problème de catégorie.</p>';
                $validation = false;
            }

            // vérification de l'image
            $authorizedFormats = [
                'image/png',
                'image/jpg',
                'image/jpeg',
                'image/jp2',
                'image/webp'
            ];
            if (empty($_FILES['image']['name']) || $_FILES['image']['size'] > 2000000 || !in_array($_FILES['image']['type'], $authorizedFormats)) {
                $errorMessage .= '<p>l\'image ne doit pas dépasser 2 Mo et doit être au format PNG, JPG, JPEG, JP2 ou WEBP.</p>';
                $validation = false;
            }

            if ($validation === true) {
                // gestion de l'image
                /** 
                 * composer un nouveau nom d'image (unique et automatique)
                 * récupérer le format de l'image
                 * renomer l'image
                 * upload
                 */
                 $timestamp = time(); //   récupère le nombre de secondes depuis  le 1er janvier 1970
                 $format = strstr($_FILES['image']['name'], '.'); //récupère tout ce qui se trouve après le point (png, jpg, ...)
                 $imgName = $timestamp . $format; // créer un nouveau nom d'image 
                 move_uploaded_file($_FILES['image']['tmp_name'], '../assets/img/' . $imgName); //upload du fichier
            
                // requête
                $req = $bdd->prepare('INSERT INTO article (titre, contenu, image, alt, date_publication, publie, auteur, category_id)
                VALUES (:titre, :contenu, :image, :alt, NOW(), :publie, :auteur, :category_id)');
                $req->bindParam(':titre', $title, PDO::PARAM_STR);
                $req->bindParam(':contenu', $content, PDO::PARAM_STR);
                $req->bindParam(':image', $imgName, PDO::PARAM_STR);
                $req->bindParam(':alt', $alt, PDO::PARAM_STR);
                $req->bindParam(':publie', $published, PDO::PARAM_BOOL);
                $req->bindParam(':auteur', $author, PDO::PARAM_BOOL);
                $req->bindParam(':category_id', $category, PDO::PARAM_INT);
                $req->execute();


                //Message de succès
                $_SEESION['notification'] = [
                    'type' => 'succees',
                    'message' => 'M'
                ]
            
            } else {
                // message d'erreur
                echo $errorMessage;
            }

            // redirection
            die('ok');
        }

    /* ******************** article - update ******************** */

        if (isset($_GET['action']) && $_GET['action'] == 'article-update') {
            
        }

    /* ******************** article - delete ******************** */

        if (isset($_GET['action']) && $_GET['action'] == 'article-delete') {
            
        }
