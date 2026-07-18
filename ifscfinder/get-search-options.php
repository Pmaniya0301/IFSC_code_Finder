<?php
header('Content-Type: application/json');
include('admin/includes/dbconnection.php');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'get_banks':
        $sql = "SELECT ID as id, BankName as name FROM tblbank ORDER BY BankName ASC";
        $query = $dbh->prepare($sql);
        $query->execute();
        echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'get_states':
        $sql = "SELECT ID as id, State as name FROM tblstate ORDER BY State ASC";
        $query = $dbh->prepare($sql);
        $query->execute();
        echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'get_cities':
        $state_id = intval($_GET['state_id'] ?? 0);
        $sql = "SELECT ID as id, City as name FROM tblcity WHERE StateID = :state_id ORDER BY City ASC";
        $query = $dbh->prepare($sql);
        $query->bindParam(':state_id', $state_id, PDO::PARAM_INT);
        $query->execute();
        echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'get_branches':
        $bank_id = $_GET['bank_id'] ?? '';
        $city_id = intval($_GET['city_id'] ?? 0);
        
        $sql = "SELECT ID as id, Branch as name FROM tblbankdetail WHERE BankName = :bank_id AND CityID = :city_id ORDER BY Branch ASC";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bank_id', $bank_id, PDO::PARAM_STR);
        $query->bindParam(':city_id', $city_id, PDO::PARAM_INT);
        $query->execute();
        echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'get_branch_details':
        $branch_id = intval($_GET['branch_id'] ?? 0);
        
        $sql = "SELECT tblbankdetail.*, tblbank.BankName as bn, tblbank.ShortName, tblstate.State, tblcity.City 
                FROM tblbankdetail 
                INNER JOIN tblstate ON tblbankdetail.StateID = tblstate.ID 
                INNER JOIN tblcity ON tblbankdetail.CityID = tblcity.ID 
                INNER JOIN tblbank ON tblbankdetail.BankName = tblbank.ID 
                WHERE tblbankdetail.ID = :branch_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':branch_id', $branch_id, PDO::PARAM_INT);
        $query->execute();
        echo json_encode($query->fetch(PDO::FETCH_ASSOC));
        break;

    default:
        echo json_encode(['error' => 'Invalid action']);
        break;
}
?>
