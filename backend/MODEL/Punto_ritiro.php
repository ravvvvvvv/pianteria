<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Punto_ritiro
{
    private Connect $db;
    private PDO $conn;

    public function __construct()
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }

    public function getArchivePuntoRitiro()
    {
        
        $sql = "SELECT pr.id, pr.nome, pr.indirizzo, u.id, u.username, u.email, o.id, o.data_acquisto, o.data_ritiro, o.stato
        from utente u
        inner join adozioni a on u.id = a.id_user 
        inner join pianta p on a.id_pianta = p.id 
        inner join pianta_ordine po on p.id = po.id_pianta 
        inner join ordine o on po.id_ordine = o.id 
        inner join punto_ritiro pr on o.id_punto_ritiro = pr.id 
        where 1=1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPuntoRitiro($punto_ritiro)
    {
        
        $sql = "SELECT *
        FROM punto_ritiro pr 
        WHERE pr.id = :id_punto_ritiro";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id_punto_ritiro", $punto_ritiro, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
