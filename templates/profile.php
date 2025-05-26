    <?php
    require_once '../php/_profile.php';
    ?>
    <div class="profile-page">

        <div class="profile">

            <h1 class="profile__title">Mon Profil</h1>
            <div class="profile__info">

                <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Date d'inscription :</strong> <?php echo date('j F Y', $InscriptionDate); ?></p>
                <div class="profile__actions">
                    <form action="/php/_logout.php" method="post" class="profile__logout-form">
                        <button type="submit" class="btn btn--big">Déconnexion</button>
                    </form>
                </div>
            </div>


            <h2 class="profile__title">Mes Commentaires</h2>
            <div class=" profile__comments">
                <?php if (empty($comments)): ?>
                    <p>Aucun commentaire trouvé.</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="feed-item">
                            <p class="feed-item__content"><?php echo htmlspecialchars($comment['Content']); ?></p>
                            <p class="feed-item__date"><?php echo date('j F Y', ($comment['Date'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>