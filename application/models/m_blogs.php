<?php

class M_blogs extends CI_Model {

public $name;
public $body;
public $date;
public $user_id;

public function get_entries()
{
        $query = $this->db->get('posts', 100);
        return $query->result();
}

public function get_post_details($id) {
        $query = $this->db->get_where('posts', array( 'id' => $id), 1);
        $result = array();
        foreach ($query->result_array() as $row)
        {
                $result['author'] = $row['user_id'];
                $result['name'] = $row['name'];
                $result['body'] = $row['body'];
        }
        return $result;
}

public function insert_entry($name, $content, $user_id)
{
        $date = date('Y-m-d H:i:s');

        $insertArray = array('name' => $name, 'body' => $content, 'user_id' => $user_id, 'date' => $date);

        $this->db->insert('posts', $insertArray);
}

public function edit_entry($id, $name, $content)
{
        $updates = array('name' => $name, 'body' => $content);
        $this->db->update('posts', $updates, array('id' => $id));
}

public function delete_entry($id)
{
        $this->db->delete('posts', array('id' => $id));
}

}

?>