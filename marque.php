<?php
// Connexion a la base de donnees
include("config.php");
$request_method = $_SERVER["REQUEST_METHOD"];

function getMarques()
{
    global $conn;
    $query = "SELECT * FROM marque";
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

function getMarque($id = 1)
{
    global $conn;
    $query = "SELECT * FROM marque";
    if ($id != 1) {
        $query .= " WHERE marque_id=" . $id . " LIMIT 1";
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

function AddMarque()
{
    global $conn;
   
    $nom= $_POST["nom"];
    $pays= $_POST["pays"];
    
    // Utilisation de la valeur fournie dans le formulaire
    $query = "INSERT INTO marque( nom,pays) VALUES('" . $nom .  "','" . $pays .  "')";

    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Categorie ajoutée avec succès.'
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

function updateMarque($id)
{
    global $conn;
    $_POST = array();
    parse_str(file_get_contents('php://input'), $_PUT);
  // Utilisation de $_PUT au lieu de $_POST pour la modification
    
     $nom= $_PUT["nom"];
     $pays= $_PUT["pays"];
     
    
    $query = "UPDATE marque SET  nom='" . $nom .  "',pays='" . $pays.  "',WHERE categorie_id=" . $id;

    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Categorie mise à jour avec succès.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Échec de la mise à jour de la categorie. ' . mysqli_error($conn)
        );
    }

    // Définit le type de contenu de la réponse comme JSON
    header('Content-Type: application/json');
    // Convertit le tableau en format JSON et l'affiche
    echo json_encode($response);
}

function deleteMarque($id)
{
    global $conn;
    $query = "DELETE FROM marque WHERE marque_id=" . $id;
    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Marque supprimée avec succès.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'La suppression de Marque a échoué. ' . mysqli_error($conn)
        );
    }
    // Définit le type de contenu de la réponse comme JSON
    header('Content-Type: application/json');
    // Convertit le tableau en format JSON et l'affiche
    echo json_encode($response);
}

switch ($request_method) {

    case 'GET':
        // Récupérer les categories
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            getMarque($id);
        } else {
            getMarque();
        }
        break;

    default:
        // Méthode de requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;

    case 'POST':
        // Ajouter une categorie
        AddMarque();
        break;

    case 'PUT':
        // Mettre à jour une categorie
        $id = intval($_GET["id"]);
        updateMarque($id);
        break;

    case 'DELETE':
        // Supprimer une categorie
        $id = intval($_GET["id"]);
        deleteMarque($id);
        break;
}
?>
