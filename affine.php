<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="container2">
		<div class="heading">
			<h1>Affine Cipher</h1>
			<a style="background: #FF4757; color: #fff;" href="index.php">← Back</a>
		</div>
	</div>
	<div class="container2">
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<div class="cipher_input">
				<label for="plaintext">Plaintext:</label>
				<textarea rows="4" name="plaintext" id="plaintext" required></textarea>
			</div>

			<div class="cipher_input">
				<label for="a">Value of a:</label>
				<input type="number" name="a" id="a" required>
			</div>

			<div class="cipher_input">
				<label for="b">Value of b:</label>
				<input type="number" name="b" id="b" required>
			</div>

			<div class="submit_type">
				<input style="background: #FF4757; color: #fff;" class="submitbutton" type="submit" name="encrypt" value="Encrypt">
				<input style="background: #FF4757; color: #fff;" class="submitbutton" type="submit" name="decrypt" value="Decrypt">
			</div>
		</form>
	</div>

	<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$plaintext = $_POST["plaintext"];
		$a = (int)$_POST["a"];
		$b = (int)$_POST["b"];

		function affineEncrypt($plaintext, $a, $b)
		{
			$ciphertext = "";
            $plaintext = strtoupper($plaintext); // Convert the plaintext to uppercase
            
            // Iterate over each character in the plaintext
            for ($i = 0; $i < strlen($plaintext); $i++) {
            	$char = $plaintext[$i];

                // Check if the character is a letter
            	if (ctype_alpha($char)) {
                    // Convert the letter to a numeric value (A = 0, B = 1, etc.)
            		$numericValue = ord($char) - ord('A');

                    // Apply the affine encryption formula: E(x) = (ax + b) mod 26
            		$encryptedValue = ($a * $numericValue + $b) % 26;

                    // Convert the encrypted numeric value back to a letter
            		$encryptedChar = chr($encryptedValue + ord('A'));

            		$ciphertext .= $encryptedChar;
            	} else {
                    // If the character is not a letter, simply append it to the ciphertext
            		$ciphertext .= $char;
            	}
            }
            
            return $ciphertext;
        }
        
        function affineDecrypt($ciphertext, $a, $b)
        {
        	$plaintext = "";
            $ciphertext = strtoupper($ciphertext); // Convert the ciphertext to uppercase
            
            // Calculate the modular multiplicative inverse of a
            $inverseA = 0;
            for ($i = 0; $i < 26; $i++) {
            	if (($a * $i) % 26 == 1) {
            		$inverseA = $i;
            		break;
            	}
            }
            
            // Iterate over each character in the ciphertext
            for ($i = 0; $i < strlen($ciphertext); $i++) {
            	$char = $ciphertext[$i];

                // Check if the character is a letter
            	if (ctype_alpha($char)) {
                    // Convert the letter to a numeric value (A = 0, B = 1, etc.)
            		$numericValue = ord($char) - ord('A');

                    // Apply the affine decryption formula: D(x) = a^(-1)(x - b) mod 26
            		$decryptedValue = ($inverseA * ($numericValue - $b + 26)) % 26;

                // Convert the decrypted numeric value back to a letter
            		$decryptedChar = chr($decryptedValue + ord('A'));

            		$plaintext .= $decryptedChar;
            	} else {
                // If the character is not a letter, simply append it to the plaintext
            		$plaintext .= $char;
            	}
            }

            return $plaintext;
        }

        if (isset($_POST["encrypt"])) {
        	$ciphertext = affineEncrypt($plaintext, $a, $b);
        	?>
        	<div class="container2">
        		<h3 class="output">Encrypted Ciphertext:</h3>
        		<textarea class="custom_textarea" rows="4"><?php echo $ciphertext ?></textarea>
        	</div>
        	<?php
        } elseif (isset($_POST["decrypt"])) {
        	$decryptedText = affineDecrypt($plaintext, $a, $b);
        	?>
        	<div class="container2">
        		<h3 class="output">Decrypted Plaintext:</h3>
        		<textarea class="custom_textarea" rows="4"><?php echo $decryptedText; ?></textarea>
        	</div>
        	<?php
        	
        }
    }
    ?>


</body>
</html>



