<?php
  use Movo\Helpers\Format;
class CertTests extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_encrypts_test_with_()
    {

        $fp=fopen(base_path()."/cert/messagehub_TEST.cer","r");
        $pub_key=fread($fp,8192);
        fclose($fp);
        $plaintext = "String to encrypt";
        openssl_public_encrypt($plaintext,$crypttext, $pub_key );
         echo $crypttext;
        return(base64_encode($crypttext));

    }
}
