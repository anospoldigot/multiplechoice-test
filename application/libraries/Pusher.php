<?php defined('BASEPATH') or exit('No direct script access allowed');


class Pusher {

    public function sendEvent ()
    {
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $pusher = new Pusher\Pusher(
            '97ee5d46ebe18668b2eb',
            'b52eb9b66a6eb547913e',
            '1371998',
            $options
        );

        $data['message'] = 'hello world';
        
        $pusher->trigger('datatable', 'my-event', $data);
    }
}

