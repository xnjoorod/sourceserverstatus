<!DOCTYPE html>
<html>
  <head>
  	<meta charset="UTF-8"/>
  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
  	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  	<meta http-equiv="refresh" content="10" />
  	<title>NorteGaming.pt - Status dos servidores</title>
  </head>

  <body>
  <div class="container">
  <div class="row">
  </div>

  <div class="row">
  <h3 class="center-align white-text"><img src="http://nortegaming.pt/img/logo.png"/> <br>Current Server Status</h3>
  </div>

  <div class="row">
    <?php
    require 'SourceQuery/bootstrap.php';

    use xPaw\SourceQuery\SourceQuery;
    Header('X-Content-Type-Options: nosniff');

    $json = file_get_contents("servers.json");
    if($json === FALSE) { ?>
      <div class="card-panel red lighten center-align">Couldn't load the file with the server informations.</div>
    <?php
      exit;
    }

    $servers = json_decode($json,true);
    $totalJogadores = 0;
    $maxJogadores = 0;
    $info = [];

    define('SQ_TIMEOUT', 1);
    define('SQ_ENGINE', SourceQuery::SOURCE);

    foreach ($servers as $server) {
      $Query = new SourceQuery();
      try
      {
        $Query->Connect($server[0], $server[1], SQ_TIMEOUT, SQ_ENGINE);
        array_push($info, $Query->GetInfo());
      }
      catch( Exception $e )
      {
        $falha = $falha . `$server[2], `;
      }
      finally
      {
        $Query->Disconnect();
      }
    }
    ?>
    <?php if($falha){ ?>
    <div class="card-panel orange lighten center-align">Existem problemas de ligação com os seguintes servidores<b><?php echo $falha; ?></b></div>
    <?php } ?>
    <div class="col s12">
      <table class="grey lighten-5 striped">
        <?php
          foreach($info as $pos => $server){
          $totalJogadores = $totalJogadores + $server['Players'];
          $maxJogadores = $maxJogadores + $server['MaxPlayers'];
        ?>
        <tr>
          <td><b><?=$server['HostName'] ?></b></td>
          <td><?=$server['Map'] ?></td>
          <td><b><a href="steam://<?=$servers[$pos+1][0]?>:<?=$server['GamePort']?>" class="waves-effect waves-light"><?=$servers[$pos+1][0]?>:<?=$server['GamePort']?></a></b></td>
          <td><b><?=$server['Players']?>/<?=$server['MaxPlayers']?></b></td>
        </tr>
        <?php } ?>
      </table>
      <div class="col s6">
        <?php
        $myFile = fopen("recorde.txt", "r+");
        if($myFile == NULL) //if file does not exist, create it
        {
            $myFile = fopen("recorde.txt", "w+");
            file_put_contents("recorde.txt", 0);
            $recorde = 0;
            if($recorde < $totalJogadores){
              file_put_contents("recorde.txt", $totalJogadores);
              $recorde = $totalJogadores;
            }
        }else{
          $recorde = fgets($myFile);
          if($recorde < $totalJogadores){
            file_put_contents("recorde.txt", $totalJogadores);
            $recorde = $totalJogadores;
          }
        }
        fclose($myFile);
        ?>

        <div class="card-panel hoverable grey lighten-5">
          <span class="title"><b>Jogadores online</b></span>
          <a href="#!" class="secondary-content"><?=$totalJogadores ?>/<?=$maxJogadores ?></a>
        </div>
        <div class="white-text left-align">Available on <a href="https://www.github.com/DarkDracoon/sourceserverstatus">GitHub</a></div>
      </div>
      <div class="col s6">
        <div class="card-panel hoverable grey lighten-5">
          <span class="title"><b>Recorde de jogadores</b></span>
          <a href="#!" class="secondary-content"><?php echo $recorde; ?></a>
        </div>
        <div class="white-text right-align">made by <b><a href="http://www.drakz.pt/">João Rodrigues</a></b> (dяαкz ;3) &copy; 2018</div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
</body>
</html>
