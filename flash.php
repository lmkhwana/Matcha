<?php 
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['flash'])): ?>
    <?php foreach($_SESSION['flash'] as $type => $message): ?>

        <div id="hideMe" style="position: relative; z-index: 999" id="hideMe" class="alert alert-<?= $type; ?>">
            <?= $message; ?>
        </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>