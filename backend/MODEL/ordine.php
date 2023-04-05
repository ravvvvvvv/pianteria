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
        $sql = "SELECT * FROM ordine WHERE 1=1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrder($id_ordine) {
        $sql = "SELECT * FROM ordine WHERE id = :id_ordine";

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
