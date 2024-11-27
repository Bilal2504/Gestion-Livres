<?php

class History {
    private $actions = [];
    private $file;

    public function __construct($file = "history.json") {
        $this->file = $file;
        if (file_exists($file)) {
            $this->actions = json_decode(file_get_contents($file), true);
        }
    }

    public function addAction($action, $details) {
        $this->actions[] = ["action" => $action, "details" => $details, "timestamp" => date("Y-m-d H:i:s")];
        file_put_contents($this->file, json_encode($this->actions, JSON_PRETTY_PRINT));
    }

    public function displayHistory() {
        if (empty($this->actions)) {
            echo "Aucun historique disponible.\n";
            return;
        }
        echo "\n--- Historique des actions ---\n";
        foreach ($this->actions as $entry) {
            echo "[{$entry['timestamp']}] {$entry['action']} : {$entry['details']}\n";
        }
    }
}