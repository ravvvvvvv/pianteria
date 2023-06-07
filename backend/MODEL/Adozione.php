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
        $sql = "SELECT adozioni.id, pianta.nome, pianta.nome_scientifico, stagione.nome as stagione, (adozioni.quantity * pianta.prezzo) as costo, pianta.fiore
				FROM pianta
				INNER JOIN adozioni ON adozioni.id_pianta = pianta.id 
				INNER JOIN stagione ON stagione.id = pianta.id_stagione ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdozione($id_adozione) {
        $sql = "SELECT pianta.fiore, utente.username, utente.email, pianta.stato_pianta, pianta.inizio_raccolto, punto_ritiro.nome as punto_ritiro, punto_ritiro.indirizzo, pianta.nome, adozioni.quantity as quantità, (adozioni.quantity * pianta.prezzo) as costo 
        from adozioni
        inner join pianta on pianta.id = adozioni.id_pianta
        inner join utente on utente.id = adozioni.id_user
        inner join punto_ritiro on punto_ritiro.id = adozioni.punto_ritiro
        where adozioni.id = :id_adozioni";
        $stmt = $this->conn->prepare($sql);
        $stmt->BindValue(":id_adozioni",$id_adozione,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
