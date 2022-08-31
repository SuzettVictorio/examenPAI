<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        canvas {
            background-color:cyan ;
            margin: auto;
        }

    </style>

</head>

<body>
    <canvas id="mycanvas"width="500" height="500">
    tu navegador no soporta canvas
    </canvas>

    <img src="floresita.png" id="imagen" style="display:none;">
    <script type="text/javascript">

    var cv = null;
    var ctx = null;
    var player1 = null;
    var player2 =null;
    var super_x= 240, super_y = 240;
    var direction = 'right';
    var score = 0;
    var speed = 3;
    var aux=speed;
    var pausa = false;
    var bloques = new Array(4);

    var bee = new Image();
    var floresita = new Image();
    var wall = new Image();
    var sonido1 = new Audio();
    

    function start(){
        cv = document.getElementById('mycanvas');
        ctx = cv.getContext('2d');
    
        player1 = new Cuadrado(super_x,super_y,40,40,'red');
        player2 = new Cuadrado(generateRandomIntegerInRange(500),generateRandomIntegerInRange(100),40,40,'yellow');

        bee.src = 'abeja.png';
        floresita.src = 'floresita.png';
        wall.src = 'wall.png';
        sonido1.src = 'bee-effects.mp3';

        bloques[0]= new Cuadrado(100,50,120,30);
        bloques[1]= new Cuadrado(50,300,30,120);
        bloques[2]= new Cuadrado(400,150,30,120);
        bloques[3]= new Cuadrado(200,400,120,30);
        paint();  
    }

    function paint(){

        window.requestAnimationFrame (paint);
        
        ctx.fillStyle = 'pink';
        ctx.fillRect(0,0,500,500);

        ctx.fillStyle= rbgaRand();
    
        player1.c=rbgaRand();
        //player1.dibujar(ctx);
        //player2.dibujar(ctx);
        
        ctx.drawImage(bee,player1.x,player1.y,40,40);
        ctx.drawImage(floresita,player2.x,player2.y,40,40);

        ctx.drawImage(wall,bloques.x,bloques.y,30,300);

        ctx.fillStyle='black';
        ctx.fillText("Score :"+score+"  Speed :"+speed,20,20)
     
        if(!pausa){
            update();
        }else{
            ctx.fillStyle='rgb(0,0,0,0.5)';
            ctx.fillRect(0,0,500,500);

            ctx.fillStyle='white';
            ctx.font ="30px Arial"
            ctx.fillText("P A U S E",230,230);
            
        }

        ctx.fillStyle='red';
        for(var i=0;i<bloques.length;i++){
            bloques[i].dibujar(ctx);
        }
       
    }

    function update(){

            if(direction == 'right'){
                 player1.x +=speed
                if(player1.x >= 500){
                    player1.x = 0;
                }
            }
            if(direction == 'left'){
                 player1.x -=speed;
                if(player1.x < 0){
                    player1.x = 50;
                }
            }
            if(direction == 'down'){
                player1.y +=speed;
                 if(player1.y >= 500){
                    player1.y = 0;
                }
            }
            if(direction == 'up'){
                player1.y -=speed;
                 if(player1.y <0){
                    player1.y = 500;
                }
            }
            if(player1.se_tocan(player2)){
                player2.x=generateRandomIntegerInRange(500);
                player2.y=generateRandomIntegerInRange(500);

                score +=5;
                speed +=1;
                sonido1.play();
            }

            if(player1.se_tocan(bloques[0])|| player1.se_tocan(bloques[1]) || 
                player1.se_tocan(bloques[2]) ||
                player1.se_tocan(bloques[3])){
            if(direction == 'right'){
                player1.x -=speed
                
            }
            if(direction == 'left'){
                 player1.x +=speed;
                
            }
            if(direction == 'down'){
                player1.y -=speed;
                
            }
            if(direction == 'up'){
                player1.y +=speed;
                
            }
            }
    }

    document.addEventListener('keydown', function(e){
        if(e.keyCode == 87 || e.keyCode == 38){
                direction='up';

            }
        // abajo
        if(e.keyCode == 83 || e.keyCode == 40){
            direction='down';
        }
        // derecha
        if(e.keyCode == 65 || e.keyCode == 37){
            direction='left';
        }
        //abajo
        if(e.keyCode == 68 || e.keyCode == 39){
                direction='right';
        }
        if(e.keyCode == 32){
            pausa =(pausa)? false : true;
}
      
       
    })

    window.addEventListener('load',start)

    window.requestAnimationFrame = (function () {
    return window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        function (callback) {
            window.setTimeout(callback, 17);
        };
    }());

    function Cuadrado(x,y,w,h,c){
        this.x=x;
        this.y=y;
        this.w=w;
        this.h=h;
        this.c=c;

        this.dibujar = function(ctx){
        ctx.fillStyle = this.c;
        ctx.fillRect(this.x,this.y,this.w,this.h);
        ctx.strokeRect(this.x,this.y,this.w,this.h);
        }

        this.se_tocan = function (target) { 

        if(this.x < target.x + target.w &&

        this.x + this.w > target.x && 

        this.y < target.y + target.h && 

        this.y + this.h > target.y)

        {

        return true;  

        }  

        };

    }

    function rbgaRand() {
        var o = Math.round, r = Math.random, s = 255;
        return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
    }

    function generateRandomInteger(max) {
        return Math.floor(Math.random() * max) + 1;
    }

    // Generate a random number between 2 and 10, including both 2 and 10
    function generateRandomIntegerInRange( max) {
        return Math.floor(Math.random() * (max  + 1));
    }


</script>

</body>

</html>
