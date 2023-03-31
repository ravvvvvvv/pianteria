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

    public function createFornitore($nome, $email, $telefono)
    {
         // Controllo se ci sono già altri utenti con la stessa mail
         $sql = "SELECT f.id
         FROM fornitore f
         WHERE f.email = :email";
 
         $stmt = $this->conn->prepare($sql);
         $stmt->bindValue(':email', $email, PDO::PARAM_STR);
 
         $stmt->execute();
 
         // Creo una variabile per contenere l'id dell'utente creato
         $user = $stmt->fetch(PDO::FETCH_ASSOC);
         
         $result = "fornitore gia presente";
         if ($stmt->rowCount() == 0)
         {
             // Aggiungo il fornitore nella tabella fornitore
             $sql = "INSERT into fornitore(id, nome, email, telefono)
             values( :id, :nome, :email, :telefono)";
 
             $stmt = $this->conn->prepare($sql);
             $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
             $stmt->bindValue(':email', $email, PDO::PARAM_STR);
             $stmt->bindValue(':telefono', $telefono, PDO::PARAM_STR);

             $result = $stmt->execute();
             
 
         }
         return $result;
     
    }
}


