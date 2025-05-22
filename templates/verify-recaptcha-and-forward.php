<?php
$recaptchaSecret = '6LeeSkErAAAAAEg4bNyrScPjOBREUnLZcco-PXK_';
$recaptchaToken = $_POST['recaptchaToken'] ?? '';

$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaToken}");
$responseData = json_decode($response);

if ($responseData->success && $responseData->score > 0.5) {
    if(@$_POST['firstName'] && @$_POST['lastName']) {
        $postData = http_build_query([
            'firstName' => $_POST['firstName'] ?? '',
            'lastName' => $_POST['lastName'] ?? '',
            'email' => $_POST['email'] ?? '',
            'reference' => $_POST['reference'] ?? '',
            'message' => $_POST['message'] ?? ''
        ]);

        $opts = ['http' =>
            [
                'method'  => 'POST',
                'header'  => "Content-Type: application/x-www-form-urlencoded",
                'content' => $postData
            ]
        ];
        $context  = stream_context_create($opts);
        $formspreeResponse = file_get_contents('https://formspree.io/f/xkndodoq', false, $context);
    } else {
        $postData = http_build_query([
            'email' => $_POST['email'] ?? ''
        ]);

        $opts = ['http' =>
            [
                'method'  => 'POST',
                'header'  => "Content-Type: application/x-www-form-urlencoded",
                'content' => $postData
            ]
        ];
        $context  = stream_context_create($opts);
        // Remove &amp; and use raw URL
        @file_get_contents('https://bohemethreads.us17.list-manage.com/subscribe/post?u=4576bddfd57e85a02b69d020f&id=19c9e58137&f_id=005066e0f0', false, $context);
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
