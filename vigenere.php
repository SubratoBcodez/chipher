<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

	<div class="container2">
        <div class="heading">
            <h1>Vigenere Cipher</h1>
            <a href="index.php">← Back</a>
        </div>
    </div>

	<section class="cipher_area">

        <form method="post" action="">

            <div class="cipher_input">
                <label for="plaintext">Plaintext/Ciphertext:</label>
                <textarea rows="5" type="text" id="plaintext" name="plaintext" required></textarea><br>
            </div>

            <div class="cipher_input">
                <label for="key">Key:</label>
                <input type="text" id="key" name="key" required><br>
            </div>

            <div class="submit_type">
                <input class="submitbutton" type="submit" name="encrypt" value="Encrypt">
                <input class="submitbutton" type="submit" name="decrypt" value="Decrypt">
            </div>
        </form>

    </section>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $plaintext = $_POST["plaintext"];
        $key = $_POST["key"];

        if (isset($_POST["encrypt"])) {
            $ciphertext = vigenereEncrypt($plaintext, $key);
            ?>
            <div class="container2">
                <h3 class="output">Encrypted Text:</h3>
                <textarea class="custom_textarea" rows="5">
                    <?php echo $ciphertext; ?>
                </textarea>
            </div>
            <?php
        } elseif (isset($_POST["decrypt"])) {
            $decryptedText = vigenereDecrypt($plaintext, $key);
            ?>
            <div class="container2">
                <h1 class="output">Decrypted Text:</h1>
                <textarea class="custom_textarea" rows="5">
                    <?php echo $decryptedText; ?>
                </textarea>
            </div>
            <?php
        }
    }

    function vigenereEncrypt($plaintext, $key) {
        $plaintext = strtoupper($plaintext);
        $key = strtoupper($key);
        $ciphertext = '';
        $keyLen = strlen($key);
        $keyPos = 0;

        for ($i = 0; $i < strlen($plaintext); $i++) {
            $char = $plaintext[$i];

            if (ctype_upper($char)) {
                $keyChar = $key[$keyPos % $keyLen];
                $keyPos++;
                $char = chr((ord($char) + ord($keyChar) - 2 * ord('A')) % 26 + ord('A'));
            }

            $ciphertext .= $char;
        }

        return $ciphertext;
    }

    function vigenereDecrypt($ciphertext, $key) {
        $ciphertext = strtoupper($ciphertext);
        $key = strtoupper($key);
        $plaintext = '';
        $keyLen = strlen($key);
        $keyPos = 0;

        for ($i = 0; $i < strlen($ciphertext); $i++) {
            $char = $ciphertext[$i];

            if (ctype_upper($char)) {
                $keyChar = $key[$keyPos % $keyLen];
                $keyPos++;
                $char = chr((ord($char) - ord($keyChar) + 26) % 26 + ord('A'));
            }

            $plaintext .= $char;
        }

        return $plaintext;
    }
    ?>
</body>
</html>
