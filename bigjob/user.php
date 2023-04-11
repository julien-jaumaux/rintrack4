<?php
session_start();
class User
{

    public $id;
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;


    public function __construct($id){
        $this->id = $id;
    }


    /*-----------méthode get--------------*/

    public function getLogin(){
        return $this->login;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getFirstname(){
        return $this->firstname;
    }

    public function getLastname(){
        return $this->lastname;
    }

    /*--------------méthode set--------------*/

    public function setLogin($login){
        $this->login = $login;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setFirstname($firstname){
        $this->firstname = $firstname;
    }

    public function setLastname($lastname){
        $this->lastname = $lastname;
    }

    /*---------------------------*/

    public function register($login, $password, $email, $firstname, $lastname,$bdd){

$login = $_POST['login'];
$stmt = $bdd->prepare("SELECT * FROM utilisateurs WHERE login=?");
$stmt->execute([$login]); 
$user = $stmt->fetchAll();

        if(!empty($login) && !empty($password)  && !empty($email) && !empty($firstname) && !empty($lastname) && $_POST['password'] === $_POST['confirmpassword']){
            if($stmt->rowCount()>0){
                echo"le login d'utilisateur existe déjà";
            }else{
            $createUser = $bdd->prepare("INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES (?, ?, ?, ?, ?)");
            $createUser->execute([$login, $password, $email, $firstname, $lastname]); 
            header("location:connexion.php"); 
        }
        }
        else{
        echo"Veuillez remplir tous les champs ou veuillez entrer deux mot de passe identiques";
        } 
    }

    public function connect($login, $password,$bdd){
        if(!empty($login) && !empty($password)){
        $connect = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ? AND password = ?");
        $connect->execute([$login, $password]);
        $result = $connect->fetch(PDO::FETCH_ASSOC);

        if($connect->rowCount()==1){ 
        $this->id = $result['id'];    
        $this->login = $result['login'];
        $this->password = $result['password'];  
        $this->email = $result['email'];
        $this->firstname = $result['firstname'];  
        $this->lastname = $result['lastname'];   
        $_SESSION['user'] = $this;
        header("location:calendrier.php");
        var_dump($this->isConnected());
        }
        }
        else{
            echo"Veuillez remplir tous les champs";
            } 
    }
    
    public function disconnect(){
        unset($_SESSION['user']);
        header('Location:connexion.php');
    }

    public function isConnected(){
        if (isset($_SESSION['user'])){
            echo "--connnected--";
            return true;
        }
        else{
            echo "--disconnected--";
            return false;
        }
    } 
    
    public function update($login, $password, $email, $firstname, $lastname,$bdd)
    {
        $updateUser = $bdd->prepare("UPDATE utilisateurs SET login=?, password=?, email=?, firstname=?, lastname=? WHERE login = ?");
        $updateUser->execute([$login, $password, $email, $firstname, $lastname, $_SESSION['user']->login]);
        $_SESSION['user']->login = $_POST['login'];
        $_SESSION['user']->password = $_POST['password'];
        $_SESSION['user']->email = $_POST['email'];
        $_SESSION['user']->firstname = $_POST['firstname'];
        $_SESSION['user']->lastname = $_POST['lastname'];
        $_SESSION['valider'] = "votre profil est bien modifié";
        header("location:profil.php");
        exit();
        
    }
}

?>