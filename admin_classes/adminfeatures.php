<?php

class AdminFeatures
{
    public function add_game($name,$genre,$date,$dev,$plat,$synop,$image)
        {
            $query="insert into games(name, genre, release_date, developer, synopsis, images) values 
            ('$name','$genre','$date','$dev','$synop', '$image' )";
            $DB = new Database();
            $DB->save($query);
        }

    public function check_game($id,$name)
    {
        $query1 = "select * from games where name = '$name' ";
        $DB = new Database();
        $q1 = $DB->read($query1);
        if ($q1)
        {
            return 'Game Name already exists!';
        }
        else
        {
            return false;
        }

    }

    
    public function check_user($id)
    {
        $query= "select * from user where user_id = '$id' ";
        $DB = new Database();   
        $result = $DB->read($query);
        return $result;
         
    }
    public function delete_user($id)
    {
        $query= "delete from user where user_id = '$id' ";
        $DB = new Database();
        $DB->save($query);
    }



}




?>