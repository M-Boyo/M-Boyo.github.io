<?php
// filepath: c:\Users\sailv\Desktop\Projet web\templates\message.php
?>
<section class="form-section">
    <form id="messageForm" class="form form--message" action="php/_publish.php" method="post">

        <div class="form__header">
            <div class="form__icon">💗</div>
            <h2 class="form__title">Envoyer un message</h2>
            <div class="form__icon">💗</div>
        </div>
        <div class="form__body">
            <div class="form__group form__group--message">
                <textarea class="form__textarea form__textarea--message" id="message" name="message" placeholder="Écrivez votre message" required></textarea>
            </div>
            <div class="form__actions">
                <button class="btn btn--big form__btn" type="submit">Envoyer</button>
            </div>
        </div>
    </form>
</section>