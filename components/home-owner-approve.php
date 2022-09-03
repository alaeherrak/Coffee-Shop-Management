<?php
if (!isset($_SESSION['username']) || !isset($_SESSION['cafe_name'])) header('Location: ./login.php');
?>
<div class="owner-approve" <?= (isset($_GET['oa'])) ? '' : 'style="display:none;"' ?>>
    <div class="owner-approve-list">
        <?php foreach ($contrats_ko as $contrat) :
            $stmt = $db->prepare('SELECT * FROM users WHERE username=?');
            $stmt->execute([$contrat->contrat_username]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
        ?>
            <div class="approve-list-row">
                <div class="approve-list-column">
                    ID <?= $contrat->id_contrat ?>
                </div>
                <div class="approve-list-column">
                    <?= $user->fullname ?>
                </div>
                <div class="approve-list-column">
                    <?= $contrat->contrat_username ?>
                </div>
                <div class="approve-list-column">
                    <a href="./approve.php?approve=ok&id=<?= $contrat->id_contrat ?>">Approve</a>
                    <a href="./approve.php?approve=no&id=<?= $contrat->id_contrat ?>">Decline</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>