<?php

class Users_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_user_data($userLogin) {

        $this->db
            ->select("userID, passwordHash, userFullName, userEmail")
            ->from("users")
            ->where("userLogin", $userLogin);

        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return NULL;
        }
    }
}