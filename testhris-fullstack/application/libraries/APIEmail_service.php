<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Exp format $data yang dikirim ke API Email Service: 
// posting_email($data) dengan $data format sebagai berikut:
// $data = [
//     'app_name' => 'HRIS IBSW',
//     'email_to' => ['user1@example.com', 'user2@example.com'],
//     'email_cc' => ['user3@example.com'],
//     'email_bcc' => ['user4@example.com'],
//     'email_subject' => 'Test Email',
//     'email_body' => '<h1>Hello World</h1>',
//     'email_attachments' => [
//         [
//             'filename' => 'report.pdf',
//             'path' => '/path/to/report.pdf' 
//         ],
//         [
//             'filename' => 'image.jpg',
//             'path' => '/path/to/image.jpg'
//         ]
//     ]
// ];
// Pastikan $data sudah sesuai format sebelum dikirim ke API Email Service
// karena API Email Service akan melakukan validasi terhadap data yang diterima
// dan mengembalikan response error jika data tidak valid
// cara penggunaan API Email Service:
// $email_service = new APIEmail_service();
// $response = $email_service->posting_email($data);
// if($response['status']){
//     echo "Email sent successfully";
// }else{
//     echo "Failed to send email: " . $response['message'];
//     if(isset($response['error'])){   
//         echo "Error details: " . print_r($response['error'], true);
//     }
// }
// memanggil library curl untuk mengirim request ke API Email Service pada controller
// $this->apiemail_service->posting_email($data);
// atau jika tidak menggunakan autoload, bisa dengan cara:
// $email_service = new APIEmail_service();
// $email_service->posting_email($data);

class APIEmail_service
{
    
    public function posting_email($data)
    {

        $data['IBSW_KEY'] = 'emailibsw';

        $username = 'admin';
        $password = '1234';

        $ch = curl_init('http://172.19.8.109/email_services/data_email_ibsw/post_email');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST, true);

        // Basic Auth
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        // cek error
        if (curl_errno($ch)) {
            echo 'Error Curl: ' . curl_error($ch);
        }

        curl_close($ch);

        echo $response;
    }
}