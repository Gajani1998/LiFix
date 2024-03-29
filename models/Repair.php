<?php

namespace models;

require_once "Database.php";

class Repair extends Database
{

    public function getTotal_damageitems_forday($tech_id, $item_id)
    {
        $date = date("Y-m-d");

        $q0 = "SELECT repair_id FROM repair WHERE technician_id='$tech_id' AND date='$date'";

        $q = "SELECT SUM(quantity) as total FROM repair_inventory_asc WHERE repair_id IN ($q0) AND damage_used_flag=1 AND item_id=$item_id";

        $result = $this->conn->query($q);
        $result = $result->fetch_array();
        return $result[0];
    }

    // public function createRepair( $status,$lp_id,$technician_id,$clerk_id)
    // {
    //     $date = date("yy-m-d");

    //     $q = "INSERT INTO `repair`(`date`, `status`, `lp_id`, `technician_id`, `clerk_id`) VALUES 
    //     ('$date', '$status','$lp_id', '$technician_id' , '$clerk_id' )";

    //     $this->conn->query($q);
    //     return $this->conn->insert_id;
    // }

    public function createRepair($status, $lp_id, $technician_id, $clerk_id, $complainer_id)
    {
        $date = date("Y-m-d");

        $q = "INSERT INTO `repair`(`date`, `status`, `lp_id`, `technician_id`, `clerk_id`, `complainer_id`) VALUES 
        ('$date', '$status','$lp_id', '$technician_id' , '$clerk_id', '$complainer_id')";

        $this->conn->query($q);
        return $this->conn->insert_id;
    }

    public function getRepairHistory( $paginationfilter,$searchfilter)
    {
        $search_word = " WHERE division LIKE '%$searchfilter%' OR lp_id LIKE '%$searchfilter%' OR date LIKE '%$searchfilter%' ";
        if ($searchfilter == '') {
        
            $q = "SELECT * FROM repair_history" . $paginationfilter;
        }else{
            
            $q = "SELECT * FROM repair_history" . $search_word . $paginationfilter;
        }
        
        $list =   $this->conn->query($q);
        return $list;
    }

    public function getRepairHistoryCount($searchfilter)
    {
        $search_word = " WHERE division LIKE '%$searchfilter%' OR lp_id LIKE '%$searchfilter%' OR date LIKE '%$searchfilter%' ";

        if ($searchfilter == '') {
        
            $q = "SELECT COUNT(repair_id) AS count FROM repair_history " ;
        }else{
            
            $q = "SELECT COUNT(repair_id) AS count FROM repair_history " . $search_word ;
        }
        
        $count =   $this->conn->query($q);
        $count =   $count->fetch_assoc();
        return $count["count"];
    }

    public function getRepairsCountById($id)
    {
        $q = "SELECT COUNT(repair.repair_id) AS count
        FROM repair 
        WHERE repair.status='c' AND repair.technician_id = $id";
        $count =   $this->conn->query($q);
        return $count;
    }


    public function getUnassignedRepairs()
    {
        $q = "SELECT repair.repair_id, repair.lp_id, lamppost.division , repair.date 
        FROM lamppost INNER JOIN repair 
        ON lamppost.lp_id=repair.lp_id WHERE repair.technician_id=0 AND repair.status='a' ORDER BY repair.date DESC ";

        $list =   $this->conn->query($q);
        return $list;
    }

    public function getAssignedRepairs($tech_id)
    {
        $q = "SELECT repair.repair_id, repair.lp_id, lamppost.division , repair.date 
        FROM lamppost INNER JOIN repair 
        ON lamppost.lp_id=repair.lp_id WHERE repair.technician_id='$tech_id' AND repair.status='a' ORDER BY repair.date DESC ";

        $list =   $this->conn->query($q);
        return $list;
    }

    public function changeStatus($id, $st)
    {
        $date = date("Y-m-d");
        
        $q = "UPDATE `repair` SET `status`='$st',`date`='$date'  WHERE `repair_id`= '$id'";
        $this->conn->query($q);
    }

    public function assignRepair($id, $tech_id)
    {
        $q = "UPDATE `repair` SET `technician_id`='$tech_id' WHERE `repair_id`= '$id'";
        $this->conn->query($q);
    }

    public function getRepairByid($r_id)
    {
        $q = "SELECT repair.repair_id, repair.lp_id,repair.status,repair.date ,repair.technician_id , lamppost.division , lamppost.lattitude,lamppost.longitude
        FROM lamppost INNER JOIN repair 
        ON lamppost.lp_id=repair.lp_id WHERE repair.repair_id='$r_id'";

        $list =   $this->conn->query($q);
        // echo $list;
        return $list->fetch_assoc();
    }
    public function getRepairItemsByid($r_id, $used_damage_flag)
    {
        $q = "SELECT repair_inventory_asc.item_id, repair_inventory_asc.quantity, inventory.name
        FROM repair_inventory_asc INNER JOIN inventory
        ON repair_inventory_asc.item_id=inventory.Item_id 
        WHERE repair_inventory_asc.repair_id='$r_id' AND repair_inventory_asc.damage_used_flag = '$used_damage_flag' ";

        $list =   $this->conn->query($q);
        // echo $list;
        return $list->fetch_all(MYSQLI_ASSOC);
    }

    private function AddUsedReturnItem($r_id, $item_id, $quantity, $returnflag)
    {
        $q = "INSERT INTO `repair_inventory_asc`( `repair_id`, `item_id`, `quantity`, `damage_used_flag`) VALUES 
        ('$r_id','$item_id' , '$quantity', '$returnflag')";

        if ($this->conn->query($q) !== TRUE)
            die('<h4 style="background-color: red;color: #fff;padding: 5px;border-radius: 5px;margin: 5px 0; position: absolute;">Process failed - Invalid request</h4> ');
    }

    public function CompleteRepair($r_id, $used_items, $return_items)
    {
        // add used items to database
        foreach ($used_items as $item) {
            $this->AddUsedReturnItem($r_id, $item[0], $item[1], 0);
        }
        // add return items to database
        foreach ($return_items as $item) {
            $this->AddUsedReturnItem($r_id, $item[0], $item[1], 1);
        }
        // chansge repair status as completed
        $this->changeStatus($r_id, 'c');
        
    }

    public function CreateEmergencyRepair($lp_id, $technician_id, $used_items, $return_items)
    {
        // hence this is emgrepair status is e, clerkid is 0 (defalt one) because he did not assign that to technician
        $r_id = $this->createRepair('e', $lp_id, $technician_id, 0, 0);

        // add used items to database
        foreach ($used_items as $item) {
            $this->AddUsedReturnItem($r_id, $item[0], $item[1], 0);
        }
        // add return items to database
        foreach ($return_items as $item) {
            $this->AddUsedReturnItem($r_id, $item[0], $item[1], 1);
        }
    }
}
