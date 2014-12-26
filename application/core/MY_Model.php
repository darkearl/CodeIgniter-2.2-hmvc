<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public $primaryFilter = 'intval'; // htmlentities for string keys
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /**
     * Save or update a record.
     * @param string $table_name
     * @param array $data
     * @param mixed $id Optional
     * @param string $primary_key (optional, default = 'ID')
     * @return mixed The ID of the saved record
     * @author Nguyen Tho Trung
     */
    public function save($table_name, $data, $id = FALSE,$primary_key ='ID') {
        if ($id == FALSE) {
            // This is an insert
            $this->db->set($data)->insert($table_name);
        }
        elseif ($id != FALSE && is_array($id)) {
            // This is an update follow multi key
            $filter = $this->primaryFilter;
            $this->db->set($data);
            foreach($id as $key => $value){
                $this->db->where($key, $filter($value));  
            }
            $this->db->update($table_name);
        }
        else { 
            // This is an update follow primary key
            $filter = $this->primaryFilter;
            $this->db->set($data)->where($primary_key, $filter($id))->update($table_name);
        }
        
        // Return the ID
        return $id == FALSE ? $this->db->insert_id() : $id;
    }
    /**
     * Delete one or more tables by ID
     * @param mixed $tables an table or an array of tables array(table1 =>primary_key1,table2 =>primary_key2)
     * @param mixed $value
     * @param string $primary_key (optional, default = 'ID')
     * @return void
     * @author Nguyen Tho Trung
     */
    function delete($tables, $value, $primary_key ='ID'){
        $tables = ! is_array($tables) ? array($tables => $primary_key) : $tables;
        $filter = $this->primaryFilter;
        $value = $filter($value);
        if ($value) {
                foreach($tables as $table => $primary_key){
                    $this->db->where(htmlentities($primary_key), htmlentities($value))->delete($table);
                }
            }
    }
}