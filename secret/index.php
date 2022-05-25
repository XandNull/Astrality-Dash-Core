<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <meta charset="utf-8">
    <title>Anekdot</title>
    <style type="text/css">
        html,body {height:90%;width:85%;margin:auto;}
	izi{}
	.scroll {
		height:190px;
		overflow-y: auto;
		-webkit-overflow-scrolling: touch;
		-ms-overflow-style: -ms-autohiding-scrollbar;
	}
	.scroll::-webkit-scrollbar {
		width: 5px;
	}
	.scroll::-webkit-scrollbar-track {
		background: #1b1e2100;
	}
	.scroll::-webkit-scrollbar-thumb {
		background-color: white;
		border: 3px solid #1b1e2100;
	}
	.scroll::-webkit-scrollbar-thumb:hover {
		background-color: #ffadf76b; 
	}
	canvas {
		display: block;
		position:absolute;
		top:0;
		left:0;
	}
    </style>

<canvas id="canvas">Canvas is not supported in your browser.</canvas>
<canvas id="canvas2">Canvas is not supported in your browser.</canvas>

<?php
    class Functions{
        // Функции для генерации строки
        public function genString($length){
            $values = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
            $string = '';
            for($i = 0; $i < $length; $i++){
                $string .= $values[rand(0, strlen($values)-1)];
            }
            return $string;
        }

        // Функции для отправки POST-запросов. Не трогайте, если не хотите сломать код
        public function send($url, $array){
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_NOPROGRESS => true,
                CURLOPT_POSTFIELDS => http_build_query($array)
            ));
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
    }

    // Подключение функций для работы скрипта
    $f = new Functions;
	ini_set('max_execution_time', 86400);
	$gameOptions = [
        'gameVersion' => 21,
        'binaryVersion' => 35
    ];
	$accountsSecret = 'Wmfv3899gc9';
	$userName = $f->genString(12);
	$password = '123456'; $gjp = 'AgUGBgMF';
	$emailHost = '@pussy.com';
    $email = $f->genString(8); $email .= $emailHost;
	$array1 = ['userName' => $userName, 'password' => $password, 'email' => $email, 'secret' => $accountsSecret];
	$array2 = ['userName' => $userName, 'password' => $password, 'secret' => $accountsSecret];
?>

<body>

    <div class="izi mt-5 scroll rounded border border-muted" id="terminal"></div>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="ptty.jquery.js"></script>
    <script type="text/javascript">

    $(document).ready(function(){
        var $ptty = $('#terminal').Ptty();
	$ptty.register('command', {
            name : 'logins',
            method : function(cmd){
                cmd.out = cmd[2]+'Login to '+cmd[1];
		cmd.rsp_custom = 'Ha! This is the output.';
                return cmd;
            },
	    options : [1,2],
            help : 'A demo command.'
        });
	var cbf_login = {
	name: 'login',
	method: function(cmd){
		var opts, $input = $ptty.get_terminal('.prompt .input');

		if(cmd[1] == "leps" && cmd[2] == "lox"){
			opts = {
				out : 'Loged in leps',
				last : 'Identifying...',
				data : { usr : cmd[1], psw : $input.text() }
			};
			$input
				.text('xxxxxxxxxx')
				.css({'visibility' : 'visible'});
			$ptty.register('command', {
				name : 'titan',
				method : function(cmd){
					cmd.out = '<img class="rounded border" src="https://i.ytimg.com/vi/1XK3SIHsrIQ/hqdefault_live.jpg">';
					return cmd;
				},
				help : 'A demo command.s'
			});
			$ptty.register('command', {
				name : 'destroy',
				method : function(cmd){
					cmd.out = '<?$data = $f->send('http://ps.fhgdps.com/ggdpschozahu/accounts/registerGJAccount.php', array_merge($array1, $gameOptions)); echo $data;?>
							   <? $data = $f->send('http://ps.fhgdps.com/ggdpschozahu/accounts/loginGJAccount.php', array_merge($array2, $gameOptions)); echo $data;?>';
					return cmd;
				},
				help : 'A demo command.ss'
			});
		}else{
			opts = {
				out  : 'Incorrect.'
			};
			$input.css({'visibility' : 'visible'});
		};

		cmd = false;
		

		$ptty.set_command_option(opts);

		return cmd;
	}
	};
	$ptty.register('callbefore', cbf_login );

	var cmd_login = { 
	name: 'login',
	method: '/ptty/',
	options : [1,2],
	help: 'Login command. Usage: login [username] [password]' 
	};
	$ptty.register('command', cmd_login);


	var cbk_login =  {
	name : 'login', 
	method : function(cmd){
		if(cmd.data && cmd.data.is_loggedin && cmd.data.is_loggedin === true){
		// remove these commands using a response
		cmd.rsp_batch_unregister = ['login', 'signup'];
		$ptty.register('command', cmd_logout);
		$ptty.register('callback', cbk_logout);
		}
		return cmd;
	}
	};
	$ptty.register('callback', cbk_login);


	var rsp_batch_unregister = {
	name : 'rsp_batch_unregister',
	method : function(cmd){
		// commands to remove
		var cmd_names = cmd.rsp_batch_unregister;

		// from these stacks
		var stacks = ['callbefore', 'command', 'callback'];
		for (var i = 0; i < stacks.length; i++) {
		for (var n = 0; n < cmd_names.length; n++) {
			$ptty.unregister(stacks[i], cmd_names[n]);
		}
		}

		// Always delete your response property if you
		// don't want it to fire in unexpected places.
		delete(cmd.rsp_batch_unregister);

		return cmd;
	}
	};
	$ptty.register('response', rsp_batch_unregister);
    });

    </script>

    <script src="vanilla-tilt.min.js"></script>
    <script>
      VanillaTilt.init(document.querySelectorAll(".izi"),{
        glare: true,
        reverse: true,
        "full-page-listening":  true,
        "max-glare": 0.7
      });

    </script>

    <script>
    var canvas = document.getElementById( 'canvas' ),
    ctx = canvas.getContext( '2d' ),
    canvas2 = document.getElementById( 'canvas2' ),
    ctx2 = canvas2.getContext( '2d' ),
    // full screen dimensions
    cw = window.innerWidth,
    ch = window.innerHeight,
    charArr = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'],
    maxCharCount = 100,
    fallingCharArr = [],
    fontSize = 10,
    maxColums = cw/(fontSize);
    canvas.width = canvas2.width = cw;
    canvas.height = canvas2.height = ch;


    function randomInt( min, max ) {
      return Math.floor(Math.random() * ( max - min ) + min);
    }

    function randomFloat( min, max ) {
      return Math.random() * ( max - min ) + min;
    }

    function Point(x,y)
    {
      this.x = x;
      this.y = y;
    }

    Point.prototype.draw = function(ctx){

      this.value = charArr[randomInt(0,charArr.length-1)].toUpperCase();
      this.speed = randomFloat(1,5);


      ctx2.fillStyle = "rgba(255,255,255,0.8)";
      ctx2.font = fontSize+"px san-serif";
      ctx2.fillText(this.value,this.x,this.y);

        ctx.fillStyle = "#0F0";
        ctx.font = fontSize+"px san-serif";
        ctx.fillText(this.value,this.x,this.y);



        this.y += this.speed;
        if(this.y > ch)
        {
          this.y = randomFloat(-100,0);
          this.speed = randomFloat(2,5);
        }
    }

    for(var i = 0; i < maxColums ; i++) {
      fallingCharArr.push(new Point(i*fontSize,randomFloat(-500,0)));
    }


    var update = function()
    {

    ctx.fillStyle = "rgba(0,0,0,0.05)";
    ctx.fillRect(0,0,cw,ch);

    ctx2.clearRect(0,0,cw,ch);

      var i = fallingCharArr.length;

      while (i--) {
        fallingCharArr[i].draw(ctx);
        var v = fallingCharArr[i];
      }

      requestAnimationFrame(update);
    }

  update();
</script>
</body>
</html>
<script async src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
