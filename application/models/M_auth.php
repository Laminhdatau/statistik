<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_auth extends CI_Model
{
    public function cek_user($username, $password)
    {
        $user['user'] = $this->db->query("SELECT username, id_role  FROM t_user WHERE username = '". $username ."'")->row_array();
        
        if (!empty($user)) {
            $valid = $this->db->query("SELECT IF((password = md5('". $password ."') ), TRUE, FALSE) AS pass FROM t_user WHERE username = '". $username ."'")->row_array();
            if (!empty($valid['pass'])) {
                $user['pass'] = $valid['pass'];
                return $user;
            } else {
                $user['pass'] = FALSE;
                return $user;
            }
        } else {
            $error['user'] = FALSE;
            return $error;
        }

        // return $this->db->query("SELECT kd, id_role,email FROM v_user WHERE email = '". $email ."' AND password = md5('". $password ."') ")->row();
    }

}