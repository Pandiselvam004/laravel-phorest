<?php 

namespace Pandiselvamps\LaravelPhorest\Models;

use PandiSelvamPS\LaravelPhorest\Phorest;

class Client extends Phorest{
    public function findUser($business_id, $client_id)
    {
        $response = $this->fetch('get', "/business/{$business_id}/client/{$client_id}", []);
        if (@$response['status'] && isset($response['result'])) {
            $this->response = $response['result'];
        }

        return $this->response;
    }
}
