<?php
// Connexion a la base de donnees
include("config.php");
$request_method = $_SERVER["REQUEST_METHOD"];

function getModeles()
{
    global $conn;
    $query = "SELECT * FROM modele";
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

function getModele($id = 0)
{
    global $conn;
    $query = "SELECT * FROM modele";
    if ($id != 0) {
        $query .= " WHERE modele_id=" . $id . " LIMIT 1";
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

function AddModele()
{
    global $conn;
   
    $nom= $_POST["nom"];
    $description = $_POST["description"];

    // Utilisation de la valeur fournie dans le formulaire
    $query = "INSERT INTO modele ( nom,description) VALUES('" . $nom .  "','" . $description . "')";  

    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Modele ajoutée avec succès.'
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

function updateModele($id)
{
    global $conn;
    $_PUT = array();
    parse_str(file_get_contents('php://input'), $_PUT);
  // Utilisation de $_PUT au lieu de $_POST pour la modification
    
     $nom= $_PUT["nom"];
     $description= $_PUT["description"];
    
    $query = "UPDATE modele SET  nom='" . $nom . "',  descriprion='" . $description . "' WHERE modele_id=" . $id;

    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Modele mise à jour avec succès.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Échec de la mise à jour du Modele. ' . mysqli_error($conn)
        );
    }

    // Définit le type de contenu de la réponse comme JSON
    header('Content-Type: application/json');
    // Convertit le tableau en format JSON et l'affiche
    echo json_encode($response);
}

function deleteModele($id)
{
    global $conn;
    $query = "DELETE FROM modele WHERE modele_id=" . $id;
    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Modele supprimée avec succès.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'La suppression de Modele a échoué. ' . mysqli_error($conn)
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
            getModele($id);
        } else {
            getModele();
        }
        break;

    default:
        // Méthode de requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;

    case 'POST':
        // Ajouter une voiture
        AddModele();
        break;

    case 'PUT':
        // Mettre à jour une voiture
        $id = intval($_GET["id"]);
        updateModele($id);
        break;

    case 'DELETE':
        // Supprimer une voiture
        $id = intval($_GET["id"]);
        deleteModele($id);
        break;
}
?>
