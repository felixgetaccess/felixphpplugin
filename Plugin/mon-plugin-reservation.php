function afficher_formulaire_reservation() {
    ob_start();
    ?>
    <!-- HTML pour le formulaire de réservation -->
    <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">
        <label for="date-reservation">Date de réservation:</label>
        <input type="date" id="date-reservation" name="date_reservation">
        
        <label for="creneau-reservation">Créneau horaire:</label>
        <select id="creneau-reservation" name="creneau_reservation">
            <option value="9h-10h">9h-10h</option>
            <option value="10h-11h">10h-11h</option>
            <!-- Ajoutez d'autres créneaux horaires selon vos besoins -->
        </select>
        
        <input type="submit" name="submit_reservation" value="Réserver">
    </form>
    <?php
    return ob_get_clean();
}

add_shortcode('formulaire_reservation', 'afficher_formulaire_reservation');

function traiter_reservation() {
    if (isset($_POST['submit_reservation']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $date_reservation = sanitize_text_field($_POST['date_reservation']);
        $creneau_reservation = sanitize_text_field($_POST['creneau_reservation']);
        
        if (!empty($date_reservation) && !empty($creneau_reservation)) {
            // Envoyer un e-mail aux administrateurs
            $to = get_option('admin_email');
            $subject = 'Nouvelle réservation';
            $message = 'Une nouvelle réservation a été faite pour la date: ' . $date_reservation . ' au créneau ' . $creneau_reservation;
            wp_mail($to, $subject, $message);

            // Message de confirmation pour l'utilisateur
            echo '<div>Votre réservation pour le ' . esc_html($date_reservation) . ' au créneau ' . esc_html($creneau_reservation) . ' a été envoyée.</div>';
        }
    }
}

add_action('wp_footer', 'traiter_reservation');
