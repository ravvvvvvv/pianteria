<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Rifornimento
{
    private Connect $db;
    private PDO $conn;
    public function __construct()
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }

    public function getArchiveRifornimento() {
        $sql = "SELECT * FROM rifornimento WHERE 1=1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRifornimento($id_rifornimento) {
        $sql = "SELECT * FROM rifornimento WHERE id = :id_rifornimento";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id_rifornimento",$id_rifornimento,PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
