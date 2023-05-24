<?php
// Connexion a la base de donnees
include("config.php");
$request_method = $_SERVER["REQUEST_METHOD"];

function getVoitures()
{
    global $conn;
    $query = "SELECT * FROM voiture";
    $response = array();
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = $row;
    }
    // Définit le type de contenu de la réponse comme JSON
    header('Content-Type: application/json');
    // Convertit le tableau en format JSON et l'affiche de manière lisible
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function getVoiture($id = 0)
{
    global $conn;
    $query = "SELECT * FROM voiture";
    if ($id != 0) {
        $query .= " WHERE id=" . $id . " LIMIT 1";
    }
    $response = array();
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = $row;
    }
    // Définit le type de contenu de la réponse comme JSON
    header('Content-Type: application/json');
    // Convertit le tableau en format JSON et l'affiche de manière lisible
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function AddVoiture()
{
    global $conn;
    $nom = $_POST["nom"];
    $modele_id = $_POST["modele_id"];
    $marque_id = $_POST["marque_id"];
    $designation = $_POST["designation"];
    $prix = $_POST["prix"];
    $couleur = $_POST["couleur"];
    $annee = $_POST["annee"]; // Utilisation de la valeur fournie dans le formulaire
    $query = "INSERT INTO voiture(nom, modele_id, marque_id, designation, prix, couleur, annee) VALUES('" . $nom . "','" . $modele_id . "','" . $marque_id . "','" . $designation . "', '" . $prix . "', '" . $couleur . "', '" . $annee . "')";

    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Voiture ajoutée avec succès.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'ERREUR! ' . mysqli_error($conn)
        );
    }
    // Définit le type de contenu de la réponse comme JSON
    header('Content-Type: application/json');
    // Convertit le tableau en format JSON et l'affiche
    echo json_encode($response);
}

function updateVoiture($id)
{
    global $conn;
    $putParams = array();
    parse_str(file_get_contents('php://input'), $putParams);
    $nom = $putParams["nom"];// Utilisation de $_PUT au lieu de $_POST pour la modification
    $modele_id = $putParams["modele_id"];
    $marque_id = $putParams["marque_id"];
    $designation = $putParams["designation"];
    $prix = $putParams["prix"];
    $couleur = $putParams["couleur"];
    $annee = $putParams["annee"];
    $query = "UPDATE voiture SET nom='" . $nom . "', modele_id='" . $modele_id . "', marque_id='" . $marque_id . "', designation='" . $designation . "', prix='" . $prix . "', couleur='" . $couleur . "', annee='" . $annee . "' WHERE id=" . $id;

    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Voiture mise à jour avec succès.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Échec de la mise à jour de la voiture. ' . mysqli_error($conn)
        );
    }

    // Définit le type de contenu de la réponse comme JSON
    header('Content-Type: application/json');
    // Convertit le tableau en format JSON et l'affiche
    echo json_encode($response);
}

function deleteVoiture($id)
{
    global $conn;
    $query = "DELETE FROM voiture WHERE id=" . $id;
    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Voiture supprimée avec succès.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'La suppression de la voiture a échoué. ' . mysqli_error($conn)
        );
    }
    // Définit le type de contenu de la réponse comme JSON
    header('Content-Type: application/json');
    // Convertit le tableau en format JSON et l'affiche
    echo json_encode($response);
}

switch ($request_method) {

    case 'GET':
        // Récupérer les voitures
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            getVoiture($id);
        } else {
            getVoitures();
        }
        break;

    default:
        // Méthode de requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;

    case 'POST':
        // Ajouter une voiture
        AddVoiture();
        break;

    case 'PUT':
        // Mettre à jour une voiture
        $id = intval($_PUT["id"]);
        updateVoiture($id);
        break;

    case 'DELETE':
        // Supprimer une voiture
        $id = intval($_DELETE["id"]);
        deleteVoiture($id);
        break;
}
?>
