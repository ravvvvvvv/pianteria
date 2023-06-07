<?php
spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Ordine
{
    private PDO $conn;
    private Connect $db;

    public function __construct() //Si connette al DB.
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }

    public function getArchiveOrder() {
        $sql = "SELECT ordine.id, utente.username, ordine.data_acquisto, ordine.data_ritiro, (pianta_ordine.quantità * pianta.prezzo) as costo
				FROM utente
				INNER JOIN ordine ON ordine.id_user = utente.id 
				INNER JOIN pianta_ordine ON pianta_ordine.id_ordine = ordine.id 
                INNER JOIN punto_ritiro ON punto_ritiro.id = ordine.id_punto_ritiro
				INNER JOIN pianta ON pianta_ordine.id_pianta = pianta.id";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrder($id_ordine) {
        $sql = "SELECT utente.username, punto_ritiro.nome as punto_ritiro, pianta.stato_pianta, ordine.data_acquisto, ordine.data_ritiro, punto_ritiro.indirizzo, pianta.nome, pianta_ordine.quantità as quantità, (pianta_ordine.quantità * pianta.prezzo) as costo
        FROM ordine 
        INNER JOIN utente on utente.id = ordine.id_user
        INNER JOIN punto_ritiro on punto_ritiro.id = ordine.id_punto_ritiro
        INNER JOIN pianta_ordine on pianta_ordine.id_ordine = ordine.id
        inner join pianta on pianta.id = pianta_ordine.id_pianta
        WHERE ordine.id = :id_ordine";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id_ordine", $id_ordine,PDO::PARAM_INT);  
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function modifyStatoOrdine($id_ordine, $stato) {
        $sql = "UPDATE ordine
                SET stato = :stato
                WHERE id = :id_ordine";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":stato", $stato,PDO::PARAM_INT);  
        $stmt->bindValue(":id_ordine", $id_ordine,PDO::PARAM_INT);  
        return $stmt->execute();
    }
}
