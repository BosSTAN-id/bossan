<div class="controlaset-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
        <br />
        Admin dalam ASCII: 
        <?php echo ord('VT'); ?>
        <br />
        Dikembalikan lagi:
        <?php echo chr(97); ?> 
    </p>
</div>
<?php
/**
 * simple method to encrypt or decrypt a plain text string
 * initialization vector(IV) has to be the same when encrypting and decrypting
 * PHP 5.4.9 ( check your PHP version for function definition changes )
 *
 * this is a beginners template for simple encryption decryption
 * before using this in production environments, please read about encryption
 * use at your own risk
 *
 * @param string $action: can be 'encrypt' or 'decrypt'
 * @param string $string: string to encrypt or decrypt
 *
 * @return string
 */
function dokudoku($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'adierzo';
    $secret_iv = 'bramisbandi';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

$plain_txt = "admin";
echo "Plain Text = $plain_txt\n";
echo '<br />';

$encrypted_txt = dokudoku('encrypt', $plain_txt);
echo "Encrypted Text = $encrypted_txt\n";
echo '<br />';

$decrypted_txt = dokudoku('decrypt', '$encrypted_txt');
echo "Decrypted Text = $decrypted_txt\n";
echo '<br />';

if( $plain_txt === $decrypted_txt ) echo "SUCCESS";
else echo "FAILED";

echo "\n";
?>
