<?php

class M_aplikasi extends CI_Model
{

    public function select_select_join_3table_type($select, $table1, $table2, $on2, $type2, $table3, $on3, $type3, $where)
    {
        return $this->db->select($select)
            ->from($table1)
            ->join($table2, $on2, $type2)
            ->join($table3, $on3, $type3)
            ->where($where)
            ->get()
            ->result_array();
    }
    public function update_data($table, $set, $where)
    {
        $this->db->where($where);
        $this->db->update($table, $set);
        return $this->db->affected_rows();
    }
    public function get_data($table)
    {
        return $this->db->get($table)->result_array();
    }
    public function checking_user($username, $password)
    {
        $this->db->select('USERNAME, PASSWORD, NAME');
        $this->db->from('user_login');

        $conditions = array();

        if ($username) {
            $conditions['USERNAME'] = $username;
        }

        if ($password) {
            $conditions['PASSWORD'] = $password;
        }

        if (!empty($conditions)) {
            $this->db->where($conditions);
        }

        return $this->db->get()->row();
    }
    public function select_where($table, $where)
    {
        return $this->db->get_where($table, $where)->result_array();
    }
    public function insert_data($table, $data)
    {
        $insert_query = $this->db->insert_string($table, $data);
        $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
        $result = $this->db->query($insert_query);
        return $result;
    }
}