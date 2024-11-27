<?php
echo "Lancement de LibraryApp...\n";
require_once 'LibraryApp.php';
echo "LibraryApp chargée.\n";

$app = new LibraryApp();
echo "Application prête à démarrer.\n";

$app->run();