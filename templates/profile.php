<div class="profile">
    <?php
    require_once '../php/_profile.php';

    // session_start(); // Start the session
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login"); // Redirect to login if not authenticated 
        exit;
    }
    // Database connection
    $db_path = __DIR__ . '/../bizou.sqlite3'; // Path to your database
    try {
        $pdo = new PDO("sqlite:" . $db_path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
    // Fetch user information
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT Email, InscriptionDate FROM bizou_user WHERE Id = :userId");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch();
    if (!$user) {
        die("User not found.");
    }
    $email = $user['Email'];
    $InscriptionDate = $user['InscriptionDate'];
    // Fetch user's posts
    $stmt = $pdo->prepare("SELECT Content, Date FROM message WHERE UserId = :userId ORDER BY Date DESC");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll();
    // Fetch user's comments
    $stmt = $pdo->prepare("SELECT Content, Date FROM message WHERE UserId = :userId ORDER BY Date DESC");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $comments = $stmt->fetchAll();
    ?>



    <h1>Mon Profil</h1>
    <div class="profile__info">
        <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Date d'inscription :</strong> <?php echo date('j F Y', $InscriptionDate); ?></p>
    </div>
    <div class="profile__actions">
        <form action="/php/_logout.php" method="post" class="profile__logout-form">
            <button type="submit" class="btn btn--big">Déconnexion</button>
        </form>
    </div>

    <h2>Mes Commentaires</h2>
    <div class="profile__comments">
        <?php if (empty($comments)): ?>
            <p>Aucun commentaire trouvé.</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="profile__comment">
                    <p><?php echo htmlspecialchars($comment['Content']); ?></p>
                    <p><em>Commenté le <?php echo date('j F Y', ($comment['Date'])); ?></em></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>