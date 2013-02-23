<html>
	<head>
		<LINK REL="stylesheet" HREF="./css/main.css" TYPE="text/css">
		<script type="text/javascript" src="./js/jquery.js" charset="shift_jis"></script>
		<script type="text/javascript" src="./js/jquery.gridster.js" charset="shift_jis"></script>
		<script type="text/javascript">

		</script>
	</head>
	<body>

	<div id="main" >

	<p>Talk Mob</p>

	<?php
	header('Content-Type: text/html; charset="UTF-8"');
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		writeData();
	}

	readData();

	function readData(){
		$keijban_file = 'keijiban.txt';

		$fp = fopen($keijban_file, 'r'); //　'r'　読み取り専用

		if ($fp){
			if (flock($fp, LOCK_SH)){
				while (!feof($fp)) {
					$buffer = fgets($fp);
					print($buffer);
				}

				flock($fp, LOCK_UN);
			}else{
				print('ファイルロックに失敗しました');
			}
		}

		fclose($fp);
	}

	function writeData(){
		$personal_name = $_POST['personal_name'];
		$contents = $_POST['contents'];
		$contents = nl2br($contents);

		$data = "<table><tr>";
		$data = $data."<td><img src='./img/neko.jpg'></td>";
		$data = $data."<td><p class='balloon'>".$contents."</p></td>";
		$data = $data."</tr></table>".PHP_EOL; //PHP改行コード

		$keijban_file = 'keijiban.txt';

		$fp = fopen($keijban_file, 'a+'); //'a' 追記専用

		if ($fp){
			if (flock($fp, LOCK_EX | LOCK_NB)){
				if (fwrite($fp,  $data) === FALSE){
					print('ファイル書き込みに失敗しました');
				}

				flock($fp, LOCK_UN);
			}else{
				print('ファイルロックに失敗しました');
			}
		}

		fclose($fp);
	}

	?>

		<div class="user-info">
			<form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
				<table>
					<!--
					<tr>
						<td style="text-align:right;">ID:</td>
						<td><input type="text" name="personal_name"></td>
					</tr>
					-->
					<tr>
						<td style="text-align:right;">コメント:</td>
						<td>
							<textarea name="contents" rows="2" cols="40"></textarea>
							<input type="submit" name="btn1" value="送信">
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div id="end"></div>

	</div>
</body>
</html>
