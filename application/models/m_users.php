<?php

class M_users extends CI_Model {

private function hash_password($password) {

        return password_hash($password, PASSWORD_DEFAULT);

}

public function get_users() {
        $query = $this->db->get('users', 1000);
        return $query->result();
}

public function get_user_details($userID) {
        $query = $this->db->get_where('users', array( 'id' => $userID), 1);
        $result = array();
        foreach ($query->result_array() as $row)
        {
                $result['id'] = $row['id'];
                $result['admin'] = $row['admin'];
                $result['email'] = $row['email'];
        }
        return $result;
}

public function get_user_details_email($email) {
        $query = $this->db->get_where('users', array( 'email' => $email), 1);
        $result = array();
        foreach ($query->result_array() as $row)
        {
                $result['id'] = $row['id'];
                $result['admin'] = $row['admin'];
                $result['email'] = $row['email'];
        }
        return $result;
}

public function login($email, $password) {
        $query = $this->db->get_where('users', array('email' => $email), 1);
        $result = $query->result();
        if($result) {
                foreach ($query->result_array() as $row)
                {
                        $result['id'] = $row['id'];
                        $result['admin'] = $row['admin'];
                        $result['password'] = $row['password'];
                        $result['email'] = $row['email'];
                }        
        if (password_verify($password, $result['password'])) {
                return true;
        } else {
                return false;
        }
        }

        else {
                return false;
        }
}

public function create_user($email, $password) {
        $date = date('Y-m-d H:i:s');
        $password = $this->hash_password($password);
        $p = array('email' => $email, 'password' => $password, 'date_created' => $date);
        $this->db->insert('users', $p);
        $insert_id = $this->db->insert_id();
        return $insert_id;
}

public function delete_user($id)
{
        $this->db->delete('users', array('id' => $id));
}

}

?>