<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_client_auth extends CI_Model
{
    private $table = 'mst_clients';

    public function doGetLoginData($email, $password)
    {
        $client = $this->db
            ->from($this->table)
            ->where('email', $email)
            ->get()
            ->row();

        if (!$client) return;

        if (password_verify($password, $client->password)) {
            return $client;
        }
    }
}
