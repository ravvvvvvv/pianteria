<?php
spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Pianta
{
    private PDO $conn;
    private Connect $db;

    public function __construct() //Si connette al DB.
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }

    public function getArchivePianta(){
        $sql = "SELECT * FROM pianta p WHERE 1=1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPianta($id_pianta) {
        $sql = "SELECT * FROM pianta p WHERE p.id = :id_pianta";
        $stmt = $this->conn->prepare($sql);
        $stmt->BindValue(":id_pianta",$id_pianta,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createPianta($nome, $nome_scientifico, $fiore, $colore1, $colore2, $prezzo, $quantità, $adottabile, $prezzo_adozione, $inizio_raccolto, $fine_raccolto){
        if(empty($inizio_raccolto) && empty($fine_raccolto)){
            $sql = "INSERT INTO pianta (nome, nome_scientifico, fiore, colore1, colore2, prezzo, quantità, adottabile, prezzo_adozione)
                VALUES (:nome, :nome_scientifico, :fiore, :colore1, :colore2, :prezzo, :quantita, :adottabile, :prezzo_adozione)";
        }else {
            $sql = "INSERT INTO pianta (nome, nome_scientifico, fiore, colore1, colore2, prezzo, quantità, adottabile, prezzo_adozione, inizio_raccolto, :fine_raccolto)
            VALUES (:nome, :nome_scientifico, :fiore, :colore1, :colore2, :prezzo, :quantita, :adottabile, :prezzo_adozione, :inizio_raccolto, :fine_raccolto)";
        }
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":nome",$nome,PDO::PARAM_STR);
        $stmt->bindValue(":nome_scientifico",$nome_scientifico,PDO::PARAM_STR);
        $stmt->bindValue(":fiore",$fiore,PDO::PARAM_INT);
        $stmt->bindValue(":colore1",$colore1,PDO::PARAM_STR);
        $stmt->bindValue(":colore2",$colore2,PDO::PARAM_STR);
        $stmt->bindValue(":prezzo",$prezzo,PDO::PARAM_STR);
        $stmt->bindValue(":quantita",$quantità,PDO::PARAM_INT);
        $stmt->bindValue(":adottabile",$adottabile,PDO::PARAM_INT);
        $stmt->bindValue(":prezzo_adozione",$prezzo_adozione,PDO::PARAM_STR);
        
        if(!empty($inizio_raccolto)){
            $stmt->bindValue(":inizio_raccolto",$inizio_raccolto,PDO::PARAM_STR);
        }
        if(!empty($fine_raccolto)){
            echo "COME";
            $stmt->bindValue(":fine_raccolto",$fine_raccolto,PDO::PARAM_STR);
        }

        return $stmt->execute();
    }
}
