<?php

    class GameList
    {
        public function check_userlist($user_id)  //To check the value of list_id
        {
            $query="select * from user where user_id='$user_id' limit 1";
            $DB= new Database();
            $result=$DB->read($query);
            $row=$result[0];
            return $row['list_id'];
        }
        public function check_addinggames($game_id)
        {
            $query="select * from addinggames where game_id='$game_id' limit 1";
            $DB= new Database();
            $result=$DB->read($query);
            if ($result)
            {
                $query="select list_id,entry_id from addinggames where game_id='$game_id' limit 1";
                $data=$DB->read($query);
                $row=$data[0];
                return $row['entry_id'];
            }
            else
            {
                return false;
            }
        }

        public function addgame($game_id,$list_id,$entry_id)
        {
            $query="insert into addinggames(game_id,list_id,entry_id) values ('$game_id','$list_id','$entry_id')";
            $DB= new Database();
            $addgame=$DB->save($query);
        }
        

        public function post_review($review,$list_id,$entry_id)
        {
            $query="insert into reviews(list_id,entry_id,review) values ('$list_id','$entry_id','$review')";
            $DB= new Database();
            $postreview=$DB->save($query);
        }

        public function create_new_game_list($user_id,$game_id,$status) //For users who have list_id valued NULL
        {
            $entry_id=$this->create_entryid();
            $DB= new Database();
            if ($status=='review')
            {
                $flag=1;
                $query1="insert into game_list(entry_id,flag_review) values ('$entry_id','$flag')";
                $query2="select list_id from game_list where entry_id='$entry_id' limit 1";
                $create_list=$DB->save($query1);
                $data=$DB->read($query2); // To extract the list_id
                $row=$data[0];
                $list_id=$row['list_id'];
                $query3="update user set list_id='$list_id' where user_id='$user_id'";
                $this->addgame($game_id,$list_id,$entry_id);
                $update_list_id=$DB->save($query3);
                $id = array($list_id,$entry_id);
                return $id;
            }
        }
        public function create_existing_game_list($list_id,$game_id,$status) //For users who don't have list_id valued NULL
        {
            $entry_id=$this->create_entryid();
            $DB= new Database();
            if ($status=='review')
            {
                $flag=$this->check_and_set_flag($status,$list_id);
                $query="insert into game_list(list_id,entry_id,flag_review) values ('$list_id','$entry_id','$flag')";
                $create_list=$DB->save($query);
                $this->addgame($game_id,$list_id,$entry_id);
                return $entry_id;
            }  
        }
        private function create_entryid()
        {
            $length=rand(4,19);
            $entryid="";
            for ($i=0 ; $i<$length; $i++)
            {
                $entryid.=rand(0,9);
            }
            return $entryid;
        }
        private function check_and_set_flag($status,$list_id)
        {
            if ($status=="review")
            {
                $query="select flag_review from game_list where list_id='$list_id'";
                $DB= new Database();
                $result=$DB->read($query);
                $row=$result[0];
                if ($row['flag_review']==0)
                {
                    return 1;
                }       
                else
                {
                    return 1;
                }
            }
        }
    }

?>