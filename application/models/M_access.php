<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_access extends CI_Model
{
    private function get_role()
    {
        $user = $this->session->userdata('user');
        return $user['id_role'];
    }

    public function menu()
    {
        $role = $this->get_role();

        $query_menu =  "SELECT m.nama_menu, m.icon, m.url
                        FROM `t_menu` as m JOIN `t_akses_menu` acc
                        ON m.id_menu = acc.id_menu
                        WHERE acc.id_role = '".$role."'
                        AND m.activated = '1'
                        ORDER BY m.id_menu ASC
                        ";
        return $menu = $this->db->query($query_menu)->result_array();
    }
}