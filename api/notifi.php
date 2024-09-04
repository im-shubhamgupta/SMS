<?php
define('API_ACCESS_KEY','AAAAMDGQTqs:APA91bH0rm7cQiLS41q00fmFjbPM_mscd_f66s57tpB7f5F2VtyIPXgr5uiaar991jjSgzhX6FG4Fs4GelgPpVi4Xdo7BNbCOWF-pnSgl0n6uzCoIbmsrRFbKCX2UaRhXGalZPyL1aPS');
 $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
 $token='dilPSUwYH1c:APA91bG2_JGvW06aBFUcWtCa4z7hE4n_IWlFnGsKFXaevgmgBznHpwT5nNFIHloNPTa_ANxbvZ8C1AXG3JSxNce9S9DVflH-vcqYOk0iJlLOVIaHMvg9vlzyuzBaAun2RRijWzl_CW6C';

    $notification = [
            'title' =>'3:20',
            'body' => 'body of message.',
            'icon' =>'myIcon', 
            'sound' => 'mySound'
        ];
        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);


        echo $result;

?>