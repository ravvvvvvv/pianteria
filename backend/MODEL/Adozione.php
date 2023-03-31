<?php
spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Adozione
{
    private PDO $conn;
    private Connect $db;

    public function __construct() //Si connette al DB.
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }

    public function getArchiveAdozione(){
        $sql = "SELECT a.id, a.id_pianta,a.id_user,a.quantity,a.punto_ritiro, u.id, u.username, u.email, o.id, o.id_punto_ritiro 
        from punto_ritiro pr 
        inner join ordine o on pr.id = o.id_punto_ritiro 
        inner join pianta_ordine po on o.id = po.id_ordine 
        inner join pianta p on po.id_pianta = p.id 
        inner join adozioni a on p.id = a.id_pianta 
        inner join utente u on a.id_user = u.id 
        where 1=1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdozione($id_adozione) {
        $sql = "SELECT *
        from adozioni a 
        where a.id = :id_adozione";
        $stmt = $this->conn->prepare($sql);
        $stmt->BindValue(":id_adozione",$id_adozione,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
