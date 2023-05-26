<?php

function prepareText($text)
{
    // Remove spaces and convert to uppercase
    $text = str_replace(' ', '', strtoupper($text));

    // Replace J with I
    $text = str_replace('J', 'I', $text);

    // Split into pairs of characters
    $pairs = str_split($text, 2);

    // Add X to the last pair if needed
    if (strlen(end($pairs)) === 1) {
        $pairs[count($pairs) - 1] .= 'X';
    }

    return $pairs;
}

function createMatrix($key)
{
    $key = str_replace(' ', '', strtoupper($key));
    $key = str_replace('J', 'I', $key);

    // Remove duplicate characters
    $key = implode('', array_unique(str_split($key)));

    // Generate alphabet without the characters in the key
    $alphabet = 'ABCDEFGHIKLMNOPQRSTUVWXYZ';
    $keyAlphabet = str_split($key);
    $remainingAlphabet = str_replace($keyAlphabet, '', $alphabet);

    // Create the matrix
    $matrix = array_merge($keyAlphabet, str_split($remainingAlphabet));

    return array_chunk($matrix, 5);
}

function findPosition($matrix, $char)
{
    foreach ($matrix as $rowIndex => $row) {
        $colIndex = array_search($char, $row);
        if ($colIndex !== false) {
            return array($rowIndex, $colIndex);
        }
    }

    return false;
}

function encrypt($plaintext, $key)
{
    $plaintext = prepareText($plaintext);
    $matrix = createMatrix($key);
    $ciphertext = '';

    foreach ($plaintext as $pair) {
        $char1 = $pair[0];
        $char2 = $pair[1];

        list($row1, $col1) = findPosition($matrix, $char1);
        list($row2, $col2) = findPosition($matrix, $char2);

        if ($row1 === $row2) {
            // Same row, shift to the right
            $col1 = ($col1 + 1) % 5;
            $col2 = ($col2 + 1) % 5;
        } elseif ($col1 === $col2) {
            // Same column, shift down
            $row1 = ($row1 + 1) % 5;
            $row2 = ($row2 + 1) % 5;
        } else {
            // Rectangle rule, swap columns
            $tmp = $col1;

            $col1 = $col2;
            $col2 = $tmp;
        }

        $encryptedPair = $matrix[$row1][$col1] . $matrix[$row2][$col2];
        $ciphertext .= $encryptedPair;
    }

    return $ciphertext;
}

function decrypt($ciphertext, $key)
{
    $ciphertext = prepareText($ciphertext);
    $matrix = createMatrix($key);
    $plaintext = '';

    foreach ($ciphertext as $pair) {
        $char1 = $pair[0];
        $char2 = $pair[1];

        list($row1, $col1) = findPosition($matrix, $char1);
        list($row2, $col2) = findPosition($matrix, $char2);

        if ($row1 === $row2) {
            // Same row, shift to the left
            $col1 = ($col1 - 1 + 5) % 5;
            $col2 = ($col2 - 1 + 5) % 5;
        } elseif ($col1 === $col2) {
            // Same column, shift up
            $row1 = ($row1 - 1 + 5) % 5;
            $row2 = ($row2 - 1 + 5) % 5;
        } else {
            // Rectangle rule, swap columns
            $tmp = $col1;
            $col1 = $col2;
            $col2 = $tmp;
        }

        $decryptedPair = $matrix[$row1][$col1] . $matrix[$row2][$col2];
        $plaintext .= $decryptedPair;
    }

    return $plaintext;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plaintext = $_POST['plaintext'];
    $key = $_POST['key'];
    $action = $_POST['submit'];

    if ($action === 'Encrypt') {
        $result = encrypt($plaintext, $key);
        $action = 'Encrypted';
    } else {
        $result = decrypt($plaintext, $key);
        $action = 'Decrypted';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <!-- <h1>Playfair Cipher</h1> -->

    <div class="main_section">
        <a href="#" class="single_sec">
            <h1>Playfair Cipher</h1>
            <p>The main goal of the Playfair cipher is to encrypt and decrypt text by substituting pairs of letters using a 5x5 grid, providing confidentiality and enhancing the security of communication.</p>
            <button>Encrypt/Decrypt</button>
        </a>
        <a href="#" class="single_sec">
            <h1>Affine Cipher</h1>
            <p>The main goal of the affine cipher is to encrypt and decrypt text using a mathematical function that combines both multiplication and addition, providing confidentiality and increasing the complexity of decryption without the proper key.</p>
            <button>Encrypt/Decrypt</button>
        </a>
        <a href="#" class="single_sec">
            <h1>Vigenere Cipher</h1>
            <p>The main goal of the Vigenère cipher is to encrypt and decrypt text using a polyalphabetic substitution method, enhancing the security of communication by introducing variability and making patterns harder to detect.</p>
            <button>Encrypt/Decrypt</button>
        </a>
    </div>


    <form action="play.php" method="post">
        <label for="plaintext">Enter Text:</label>
        <input type="text" name="plaintext" id="plaintext" required>
        <br><br>
        <label for="key">Enter Key:</label>
        <input type="text" name="key" id="key" required>
        <br><br>
        <input type="submit" name="submit" value="Encrypt">
        <input type="submit" name="submit" value="Decrypt">
    </form>

    <?php if (isset($result)) : ?>
        <h2><?php echo $action; ?> Text:</h2>
        <p><?php echo $result; ?></p>
    <?php endif; ?>
</body>
</html>
