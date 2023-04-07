<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Utente
{
    private Connect $db;
    private PDO $conn;

    public function __construct()
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }


    public function login($email, $password)
    {
        $sql = "SELECT *
        from utente u
        where u.email =  :email  and `password` =  :password_user";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password_user', $password, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function deleteUtente($id_utente)
    {
        $utente = $this->getUtente($id_utente);

        if ($utente == null)
            return false;

        $sql = "DELETE FROM Utente 
        WHERE  id = :id_utente";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_utente', $id_utente, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getUtente($id_utente)
    {
        $sql = "SELECT *
            FROM utente u
            WHERE u.id = :id_utente";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_utente', $id_utente, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function resetPassword($id_utente, $password_utente)
    {
        $sql = "SELECT *
            FROM utente u
            WHERE u.id = :id_utente";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_utente', $id_utente, PDO::PARAM_INT);

        $stmt->execute();
        $utente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($utente["livello_permessi"] != 2)
        {
            return 3;
        }

        $sql = "UPDATE utente
        SET `password` = :password_utente
        WHERE id = :id_utente";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_utente', $id_utente, PDO::PARAM_INT);
        $stmt->bindValue(':password_utente', $password_utente, PDO::PARAM_STR);

        return $stmt->execute();
    }

    
    public function registraUtente($username, $email, $password, $livello_permessi)
    {
        // Controllo se ci sono già altri utenti con la stessa mail
        $sql = "SELECT u.id
        FROM utente u
        WHERE u.email = :email";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->execute();

        // Creo una variabile per contenere l'id dell'utente creato
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $result = "utente gia presente";
        if ($stmt->rowCount() == 0)
        {
            // Aggiungo l'utente nella tabella user
            $sql = "INSERT into ordine(id, username, email, `password`, livello_permessi)
            values( :id, :username, :email, :`password`, :livello_permessi)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->bindValue(':livello_permessi', $livello_permessi, PDO::PARAM_STR);
            
            $result = $stmt->execute();
            

        }
        return $result;
    }
    
}
?>
