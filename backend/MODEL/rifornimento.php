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
        $sql = "SELECT r.id, f.nome, r.data_ordine, r.data_arrivo, r.quantità
        		FROM fornitore f
        		INNER JOIN rifornimento r on f.id = r.id_fornitore
                WHERE 1=1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRifornimento($id_rifornimento) {
        $sql = "SELECT r.id, f.nome, r.data_ordine, r.data_arrivo, r.quantità, p.nome as nome_pianta, (p.prezzo * r.quantità) as costo_totale
        		FROM fornitore f
        		INNER JOIN rifornimento r on f.id = r.id_fornitore
                INNER JOIN pianta p on p.id = r.id_pianta
                WHERE r.id = :id_rifornimento";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id_rifornimento",$id_rifornimento,PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getDataRifornimento($id_rifornimento) {
        $sql = "SELECT  r.data_ordine as data
        		FROM fornitore f
        		INNER JOIN rifornimento r on f.id = r.id_fornitore
                INNER JOIN pianta p on p.id = r.id_pianta
                WHERE 1=1
                ORDER BY data desc";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id_rifornimento",$id_rifornimento,PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createRifornimento($id_pianta, $id_fornitore, $quantità, $data_ordine, $data_arrivo, $id_user, $prezzo, $fine_raccolto) {
        $sql = "INSERT INTO rifornimento (id_pianta, id_fornitore, quantità, data_ordine, data_arrivo, id_user, prezzo, fine_raccolto)
                VALUES (:id_pianta, :id_fornitore, :quantita, :data_ordine, :data_arrivo, :id_user, :prezzo, :fine_raccolto)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id_pianta",$id_pianta,PDO::PARAM_INT);
        $stmt->bindValue(":id_fornitore",$id_fornitore,PDO::PARAM_INT);
        $stmt->bindValue(":quantita",$quantità,PDO::PARAM_INT);
        $stmt->bindValue(":data_ordine",$data_ordine,PDO::PARAM_STR);
        $stmt->bindValue(":data_arrivo",$data_arrivo,PDO::PARAM_STR);
        $stmt->bindValue(":id_user",$id_user,PDO::PARAM_INT);
        $stmt->bindValue(":prezzo",$prezzo,PDO::PARAM_INT);
        $stmt->bindValue(":fine_raccolto",$fine_raccolto,PDO::PARAM_STR);

        return $stmt->execute();
    }
}
