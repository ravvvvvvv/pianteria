<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Fornitore
{
    private Connect $db;
    private PDO $conn;
    public function __construct()
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }

public function getFornitore($id_fornitore)
    {
        $sql = "SELECT f.id, f.nome, f.email, f.telefono 
        from fornitore f 
        where f.id = :id_fornitore";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_fornitore', $id_fornitore, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getArchiveFornitore(){
        $sql = "SELECT f.id, f.nome, f.email, f.telefono, r.id, r.quantità, r.data_ordine, r.data_arrivo, r.id_pianta, r.id_fornitore, r.id_user  
        from fornitore f
        inner join rifornimento r on f.id = r.id_fornitore
        inner join pianta p on r.id_pianta = p.id 
        inner join pianta_ordine po on p.id = po.id_pianta 
        where 1=1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


