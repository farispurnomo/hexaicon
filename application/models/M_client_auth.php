<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_client_auth extends CI_Model
{
    private $table_client               = 'mst_clients';
    private $table_subscription_plan    = 'mst_subscription_plans';
    private $table_password_resets      = 'password_resets';

    public function doGetClientByEmail($email)
    {
        return $this->db
            ->from($this->table_client)
            ->where('email', $email)
            ->get()
            ->row();
    }

    public function doGetLoginData($email, $password)
    {
        $client = $this->doGetClientByEmail($email);

        if (!$client) return;

        if (password_verify($password, $client->password)) {
            return $client;
        }
    }

    public function doGetDefaultSubscriptionPlan()
    {
        return $this->db
            ->from($this->table_subscription_plan)
            ->where('is_default', 1)
            ->get()
            ->row();
    }

    public function doInsertClientData(array $data)
    {
        $this->db->insert($this->table_client, $data);
        return $this->db->affected_rows();
    }

    public function doInsertPasswordReset(array $data)
    {
        $this->db->delete($this->table_password_resets, ['email' => $data['email']]);

        $this->db->insert($this->table_password_resets, $data);
        return $this->db->affected_rows();
    }

    public function doGetTokenResetData($email, $token)
    {
        return $this->db
            ->from($this->table_password_resets)
            ->where('token', $token)
            ->where('email', $email)
            ->get()
            ->row();
    }

    public function doUpdatePasswordClientByEmail($email, $new_password)
    {
        $this->db->delete($this->table_password_resets, ['email' => $email]);

        $this->db->where('email', $email);
        $this->db->update($this->table_client, array(
            'password'  => $new_password
        ));
        return $this->db->affected_rows();
    }
}
