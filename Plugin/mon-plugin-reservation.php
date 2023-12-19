function afficher_formulaire_reservation() {
    ob_start();
    ?>
    <!-- HTML pour le formulaire de réservation -->
    <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">
        <label for="date-reservation">Date de réservation:</label>
        <input type="date" id="date-reservation" name="date_reservation">
        <input type="submit" name="submit_reservation" value="Réserver">
    </form>
    <?php
    return ob_get_clean();
}

add_shortcode('formulaire_reservation', 'afficher_formulaire_reservation');

function traiter_reservation() {
    if (isset($_POST['submit_reservation']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $date_reservation = sanitize_text_field($_POST['date_reservation']);
        
        if (!empty($date_reservation)) {
            // Envoyer un e-mail aux administrateurs
            $to = get_option('admin_email');
            $subject = 'Nouvelle réservation';
            $message = 'Une nouvelle réservation a été faite pour la date: ' . $date_reservation;
            wp_mail($to, $subject, $message);

            // Message de confirmation pour l'utilisateur
            echo '<div>Votre réservation pour le ' . esc_html($date_reservation) . ' a été envoyée.</div>';
        }
    }
}

add_action('wp_footer', 'traiter_reservation');
