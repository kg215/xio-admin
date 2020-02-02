<template>
    <canvas id="o-so-cool"></canvas>
</template>

<script>
    export default {
        name: "Osoc",
        mounted: function(){
            let oSoCool=document.querySelector("#o-so-cool"),
                ctx=oSoCool.getContext("2d");

            function resize(){
                oSoCool.width=window.innerWidth || document.documentElement.clientWidth || document.body.offsetWidth;
                oSoCool.height=window.innerHeight || window.documentElement.clientWidth || document.body.offsetHeight;
            }

            resize();
            window.addEventListener("resize",resize);

            let dots = new Set([])
                ,width=.2
                ,speed=1
                ,num=100;

            for(let i = 0; i < num; i++) {
                let x = Math.random() * oSoCool.width
                    , y = Math.random() * oSoCool.height
                    , xa = Math.random() * 2*speed - speed
                    , ya = Math.random() * 2*speed - speed;
                dots.add(new Map(Object.entries({
                    x,
                    y,
                    xa,
                    ya,
                    max: 6000
                })));
            }

            (function animateCoolO(){
                ctx.clearRect(0, 0, oSoCool.width, oSoCool.height);
                ctx.fillStyle="rgba(0, 0, 0, .85)";
                ctx.fillRect(0, 0, oSoCool.width, oSoCool.height);

                dots.forEach(function (info) {
                    let x=info.get("x")
                        ,y=info.get("y")
                        ,xa=info.get("xa")
                        ,ya=info.get("ya");
                    xa *= x>oSoCool.width || x<0 ? -1 : 1;
                    ya *= y>oSoCool.height || y<0 ? -1 : 1;
                    x += xa;
                    y += ya;
                    ctx.fillStyle="rgba(137,223,219,0.65)";
                    ctx.fillRect(x-0.5,y-0.5,1,1);

                    ctx.beginPath();
                    ctx.strokeStyle="rgba(51,237,255,0.65)";
                    for(let dot of dots){
                        let dotX=dot.get("x")
                            ,dotY=dot.get("y");
                        if(dotX === x && dotY===y){ continue }
                        let xc = Math.abs(x-dotX)
                            ,yc = Math.abs(y-dotY)
                            ,d = Math.pow(xc,2) + Math.pow(yc,2) ;
                        if(d>dot.get("max")){ continue }
                        ctx.lineWidth = width;
                        ctx.moveTo(x,y);
                        ctx.lineTo(dot.get("x"),dot.get("y"));
                    }
                    ctx.stroke();
                    ctx.closePath();

                    info.set("xa",xa);
                    info.set("ya",ya);
                    info.set("x",x);
                    info.set("y",y);
                });
                requestAnimationFrame(animateCoolO);
            })();
        }
    }
</script>

