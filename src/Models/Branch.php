<?php 

namespace Pandiselvamps\LaravelPhorest\Models;

use PandiSelvamPS\LaravelPhorest\Phorest;

class Branch extends Phorest{
    public function getBranches($business_id)
    {
        $response = $this->fetch('get', "/business/{$business_id}/branch", ['size' => 100]);
        if (@$response['status'] && isset($response['result']['_embedded']['branches'])) {
            $this->response = @$response['result']['_embedded']['branches'];
        }

        return $this->response;
    }
}