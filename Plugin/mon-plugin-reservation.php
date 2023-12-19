function afficher_formulaire_reservation() {
    ob_start();
    ?>
    <!-- HTML pour le formulaire de réservation -->
    <form action="" method="post">
        <label for="date-reservation">Date de réservation:</label>
        <input type="date" id="date-reservation" name="date_reservation">
        <input type="submit" value="Réserver">
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('formulaire_reservation', 'afficher_formulaire_reservation');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['date_reservation'])) {
    $date_reservation = sanitize_text_field($_POST['date_reservation']);
    // Traiter la réservation ici
}
