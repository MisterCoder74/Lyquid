<?php
$team_id = $_POST['team'];
$project_id = $_POST['project'];

// Leggi i dati dal file teams.json
$teams = json_decode(file_get_contents("../dbs/teams.json"), true);

// Cerca il team corrispondente all'id selezionato
foreach ($teams as &$team) {
  if ($team['id'] == $team_id) {
    // Verifica che il progetto non sia già assegnato al team
    if (!in_array($project_id, $team['projects'])) {
//header("Location: usersteam_manager.php");
//    }

    // Aggiungi il progetto alla lista dei progetti assegnati
    $team['projects'][] = $project_id;
    break;
  }
}
}

// Scrivi i dati aggiornati nel file teams.json
file_put_contents("../dbs/teams.json", json_encode($teams));

header("Location: usersteam_manager.php");
?>