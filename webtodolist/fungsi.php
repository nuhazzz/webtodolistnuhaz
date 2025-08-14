<?php
function ambilTugas() {
    $data = file_get_contents("tugas.json");
    return json_decode($data, true);
}

function simpanTugas($tugas) {
    file_put_contents("tugas.json", json_encode($tugas, JSON_PRETTY_PRINT));
}
?>
