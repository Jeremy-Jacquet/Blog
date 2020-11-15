<?php 
if($alert->checkAlert()) { ?>
    <!-- ALERT -->
    <?php
    if($alert->checkError()) { 
        $alert->showError();
    }
    if($alert->checkSuccess()) { 
        $alert->showSuccess();
    } 
} 
?>
