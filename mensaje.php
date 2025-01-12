<?php if (isset($_SESSION['mensaje'])) { ?>
    <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; border: 1px solid #c3e6cb; margin-bottom: 20px; text-align: center;">
        <?php
        echo $_SESSION['mensaje'];
        unset($_SESSION['mensaje']); // Elimina el mensaje
        ?>
    </div>
<?php } ?>

<?php if (isset($_SESSION['error'])) { ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; border: 1px solid #f5c6cb; margin-bottom: 20px; text-align: center;">
        <?php
        echo $_SESSION['error'];
        unset($_SESSION['error']); // Elimina el mensaje
        ?>
    </div>
<?php } ?>
