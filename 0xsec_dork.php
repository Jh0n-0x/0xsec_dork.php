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

$d = $argv[2];
if($argv[3] != "-sql"){
	
	$d = $d ." ". $argv[3];
}
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
	[+] Autor: Pablo Santhus
	[+] Data: 01/01/2017
	[+] Nome: 0xsec_dork
	[+] Ajuda: 0xsec_dork.php -h
	[+] Dork: {$d}

";


}

	banner();
	$dork = urlencode($d);
	$urls = "https://www.bing.com/search?q=";
	$url = $urls . $dork;
	$pag = array("&first=1","&first=2","&first=3","&first=4","&first=5","&first=6","&first=7","&first=8","&first=9","&first=10");

if($argv[1] == "-dork" or $argv[1] == "-d" && isset($argv[3])){

	foreach($pag as $paginacao){
		$web = $url . $paginacao;
		$f = @fopen($web, "r");

		while($buf = fgets($f, 1024)){
			$buf = fgets($f, 4096);
			preg_match_all("#\b((((ht|f)tps?://)|(ftp)\.)[a-zA-Z0-9\.\#\@\:%_/\?\=\~\-]+)#i", $buf, $match);

			for($i=0; $match[$i]; $i++){

				for($f = 0; $match[$i][$f]; $f++){

					if(isset($match[$i][$f]) && !strstr($match[$i][$f], "google") && !strstr($match[$i][$f], "microsoft") && !strstr($match[$i][$f], "youtube") && !strstr($match[$i][$f], "bing") && !strstr($match[$i][$f], "blogger") && !strstr($match[$i][$f], "yahoo") && !strstr($match[$i][$f], "facebook")){

						$sites = strtolower($match[$i][$f]);
						$sites = str_replace(array("http://","https://","ht"), "", $match[$i][$f]);
						
						if(!$sites == ""){
							print "[*] " . $sites . "\n";
							$fp = fopen("url.txt", "a");
							fwrite($fp, " " . $sites . "\n");
							$num = count(file("url.txt"));
						}
						
					}
				}
			}
		}
	}
print "\n";
print "___________________________________________________________________\n\n";

echo "[+] Numero de sites encontrado {$num} \n";

print "____________________________________________________________________\n\n";

	if($argv[3] == "-sql"){
		print "[+] Verificando \n";sleep(2);
		print "[+] Verificacao 100%\n";
		print "[+] Capturando Hosts\n";sleep(2);
		print "[+] Hosts Capturados\n";
		print "[+] Iniciando... \n\n";

		$file = file("url.txt");
		$site = str_replace(" ", "\n", $file);
		foreach($site as $site){
			$site = str_replace("\n", "", $site);
			$site = str_replace("\r", "", $site);

			$caminho = "http://" . $site . "'";
			$verf = file_get_contents($caminho);

			if( strstr($verf, "error") or strstr($verf, "mysql") or strstr($verf, "syntax") or strstr($verf, "Warning") or strstr($verf, "SQL syntax")){
					print"\n";
					print "_____________________________________________________________________\n\n";
					print "[+] Site Vuln: " . $site . "\n\n";
					print "_____________________________________________________________________\n\n";
			}else{
				print "[-] Site NOT Vuln: " . $site . "\n";
			}
		}

		$u = fopen("url.txt", "w");
		fwrite($u, "");

	}

	if($argv[4] == "-sql"){
		print "[+] Verificando \n";sleep(2);
		print "[+] Verificacao 100%\n";
		print "[+] Capturando Hosts\n";sleep(2);
		print "[+] Hosts Capturados\n";
		print "[+] Iniciando... \n\n";

		$file = file("url.txt");
		$site = str_replace(" ", "\n", $file);
		foreach($site as $site){
			$site = str_replace("\n", "", $site);
			$site = str_replace("\r", "", $site);

			$caminho = "http://" . $site . "'";
			$verf = file_get_contents($caminho);

			if( strstr($verf, "error") or strstr($verf, "mysql") or strstr($verf, "syntax") or strstr($verf, "Warning") or strstr($verf, "SQL syntax")){
					print"\n";
					print "_____________________________________________________________________\n\n";
					print "[+] Site Vuln: " . $site . "\n\n";
					print "_____________________________________________________________________\n\n";
			}else{
				print "[-] Site NOT Vuln: " . $site . "\n";
			}
		}

		$u = fopen("url.txt", "w");
		fwrite($u, "");
	}


}

if($argv[1] == "-h" or $argv[1] == "-help"){
	print("\n\n");
	print "  ######################################################\n";
    print "  #                                                    #\n";
	print "  #   0x0x0x0x0x0x Painel de Ajuda 0x0x0x0x0x0x0x0     #\n";
    print "  #                                                    #\n";
	print "  ######################################################\n\n";

	echo "
			OPTIONS[-dork, -sql, -h]

	-dork       Adiciona uma dork para pesquisa ex:(inurl:news.php?id=)

	 -sql       Verifica Vulnerabilidade SQL Injection

	   -h       Exibe painel de ajuda

	   exemplos:

	   0xsec_dork.php -dork inurl:news.php?id=
	   0xsec_dork.php -dork inurl:news.php?id= -sql
	   0xsec_dork.php -dork inurl:news.php?id= site:gov.br -sql

\n";
}


?>
