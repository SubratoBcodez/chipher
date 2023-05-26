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

	<div class="title">
		<div class="container">
			<h1>Cipher Encryption & Decryption Tools</h1>
			<p>The main goal of ciphers is to securely encrypt and decrypt information, ensuring confidentiality, integrity, and authentication. Ciphers utilize mathematical algorithms or substitution techniques to transform plaintext into ciphertext, making it unreadable without the proper key, thereby protecting sensitive data from unauthorized access and ensuring secure communication.</p>
		</div>
	</div>
	<div class="main_section container">
		<a href="playfair.php" class="single_sec">
			<h1>Playfair Cipher</h1>
			<p>The main goal of the Playfair cipher is to encrypt and decrypt text by substituting pairs of letters using a 5x5 grid, providing confidentiality and enhancing the security of communication.</p>
			<button>Encrypt/Decrypt</button>
		</a>
		<a href="affine.php" class="single_sec">
			<h1>Affine Cipher</h1>
			<p>The main goal of the affine cipher is to encrypt and decrypt text using a mathematical function that combines both multiplication and addition, providing confidentiality and increasing the complexity of decryption without the proper key.</p>
			<button>Encrypt/Decrypt</button>
		</a>
		<a href="vigenere.php" class="single_sec">
			<h1>Vigenere Cipher</h1>
			<p>The main goal of the Vigenère cipher is to encrypt and decrypt text using a polyalphabetic substitution method, enhancing the security of communication by introducing variability and making patterns harder to detect.</p>
			<button>Encrypt/Decrypt</button>
		</a>
	</div>

	<footer class="footer">
		<p>&copy;Developed by SB</p>
	</footer>
</body>
</html>