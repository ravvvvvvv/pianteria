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
    
    public function createPianta($nome, $nome_scientifico, $fiore, $colore1, $colore2, $prezzo, $quantità, $adottabile, $prezzo_adozione, $inizio_raccolto, $fine_raccolto, $stato_pianta, $stagione){
        if(empty($inizio_raccolto) && empty($fine_raccolto)){
            $sql = "INSERT INTO pianta (nome, nome_scientifico, fiore, colore1, colore2, prezzo, quantità, adottabile, prezzo_adozione, active)
                VALUES (:nome, :nome_scientifico, :fiore, :colore1, :colore2, :prezzo, :quantita, :adottabile, :prezzo_adozione, :active)";
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
        $stmt->bindValue(":active",$stato_pianta,PDO::PARAM_INT);

        if(!empty($inizio_raccolto)){
            $stmt->bindValue(":inizio_raccolto",$inizio_raccolto,PDO::PARAM_STR);
        }
        if(!empty($fine_raccolto)){
            echo "COME";
            $stmt->bindValue(":fine_raccolto",$fine_raccolto,PDO::PARAM_STR);
        }

        $result = $stmt->execute();

        $last_id = $this->conn->lastInsertId();

        $sql2 = "INSERT INTO pianta_stagione (id_pianta, id_stagione)
                VALUES (:id_pianta, :id_stagione)";
        foreach($stagione as $stg){
            $stmt = $this->conn->prepare($sql2);
            $stmt->bindValue(":id_pianta",$last_id, PDO::PARAM_INT);
            $stmt->bindValue(":id_stagione",$stg, PDO::PARAM_INT);

            $stmt->execute();
        }

        return $result;
    }

    public function modifyPianta($id_pianta, $nome, $nome_scientifico, $fiore, $colore1, $colore2, $prezzo, $quantita, $adottabile, $prezzo_adozione, $inizio_raccolto, $fine_raccolto, $stato_pianta, $stagione){
        if(empty($inizio_raccolto) && empty($fine_raccolto)){
            $sql = "UPDATE pianta 
            set nome = :nome, nome_scientifico = :nome_scientifico, fiore = :fiore, colore1 = :colore1, 
            colore2 = :colore2, prezzo = :prezzo, quantità = :quantita, adottabile = :adottabile, 
            prezzo_adozione = :prezzo_adozione, stato_pianta = :stato_pianta
            where id = :id_pianta";
        }else {
            $sql = "UPDATE pianta 
            set nome = :nome, nome_scientifico = :nome_scientifico, fiore = :fiore, colore1 = :colore1, 
            colore2 = :colore2, prezzo = :prezzo, quantità = :quantita, adottabile = :adottabile, 
            prezzo_adozione = :prezzo_adozione, inizio_raccolto = :inizio_raccolto, fine_raccolto = :fine_raccolto,
            stato_pianta = :stato_pianta
            where id = :id_pianta";
        }
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue("id_pianta",$id_pianta,PDO::PARAM_INT);
        $stmt->bindValue(":nome",$nome,PDO::PARAM_STR);
        $stmt->bindValue(":nome_scientifico",$nome_scientifico,PDO::PARAM_STR);
        $stmt->bindValue(":fiore",$fiore,PDO::PARAM_INT);
        $stmt->bindValue(":colore1",$colore1,PDO::PARAM_STR);
        $stmt->bindValue(":colore2",$colore2,PDO::PARAM_STR);
        $stmt->bindValue(":prezzo",$prezzo,PDO::PARAM_STR);
        $stmt->bindValue(":quantita",$quantita,PDO::PARAM_INT);
        $stmt->bindValue(":adottabile",$adottabile,PDO::PARAM_INT);
        $stmt->bindValue(":prezzo_adozione",$prezzo_adozione,PDO::PARAM_STR);
        $stmt->bindValue(":stato_pianta",$stato_pianta,PDO::PARAM_INT);

        if(!empty($inizio_raccolto)){
            $stmt->bindValue(":inizio_raccolto",$inizio_raccolto,PDO::PARAM_STR);
        }
        if(!empty($fine_raccolto)){
            $stmt->bindValue(":fine_raccolto",$fine_raccolto,PDO::PARAM_STR);
        }

        $result = $stmt->execute();

        //Cancello tutte le stagioni precendenti
        $sql2 = "DELETE FROM pianta_stagione
                WHERE id_pianta = :id";
        $stmt = $this->conn->prepare($sql2);
        $stmt->bindValue(":id",$id_pianta,PDO::PARAM_INT);
        $stmt->execute();

        //Inseriamo le nuove stagioni
        $sql3 = "INSERT INTO pianta_stagione(id_pianta, id_stagione)
                VALUES(:id_pianta, :id_stagione)";
        foreach($stagione as $stg){
            $stmt = $this->conn->prepare($sql3);
            $stmt->bindValue(":id_pianta",$id_pianta, PDO::PARAM_INT);
            $stmt->bindValue(":id_stagione",$stg, PDO::PARAM_INT);

            $stmt->execute();
        }

        return $result;
    }

    public function modifyActivePianta($id_pianta, $active){
        $sql = "UPDATE pianta p
        SET stato_pianta = :active
        where p.id = :id_pianta";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":active",$active,PDO::PARAM_INT);
        $stmt->bindValue(":id_pianta",$id_pianta,PDO::PARAM_INT);

        return $stmt->execute();
    }
}
