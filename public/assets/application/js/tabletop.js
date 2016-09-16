

      if($('#animation').width()){
      var animSvg = Snap("#animation");
      var bck = animSvg.paper.image("assets/application/img/tabletop_ImgID1.jpg", 0, 0, 1235, 822).attr({opacity:0.01});
 



var svgString1 = '<path id="s3" d="M533 232c0,137 0,368 0,482l148 0 0 -614 -498 0 0 614 130 0 0 -482 220 0z M654 544c-38,0 -49,0 -90,0l0 -138 90 0 0 138z M192 593l0 -128 109 0c0,17 0,114 0,128l-109 0zM533 232l0 482 148 0 0 0c-9,0 -145,0 -148,0l0 -482 -220 0 0 0 220 0z M183 714l130 0c0,0 0,0 0,0 -28,0 -45,0 -130,0l0 0z" stroke="black"/>';



function Drawing( svgString, transformString, timeBetweenDraws ) {
    this.fragment = Snap.parse( svgString );
    this.pathArray = this.fragment.selectAll('path');
    this.group = animSvg.g().transform( transformString ).drag();
    this.timeBetweenDraws = timeBetweenDraws;
};

Drawing.prototype.init = function( svgString, transformString ) {
      this.group.clear();
      this.currentPathIndex = 0;

};

Drawing.prototype.endReached = function() {
    if( this.currentPathIndex >= this.pathArray.length ) {
        return true;
    };
};

Drawing.prototype.callOnFinished = function() {
}

Drawing.prototype.initDraw = function() {
    this.init();
    this.draw();
};

Drawing.prototype.quickDraw = function() {
    this.init();
    this.timeBetweenDraws = 0;
    this.draw();
};

Drawing.prototype.draw = function() {         // this is the main animation bit
    if( this.endReached() ) {
        if( this.callOnFinished ) {
            this.callOnFinished();
            return
        };
    };
    var myPath = this.pathArray[ this.currentPathIndex ] ;

    this.leng = myPath.getTotalLength();

    this.group.append( myPath );

     myPath.attr({
       fill: 'none',
       "stroke-dasharray": this.leng + " " + this.leng,
       "stroke-dashoffset": this.leng
     });

     this.currentPathIndex++;

     myPath.animate({"stroke-dashoffset": 0}, this.timeBetweenDraws, mina.easeout, this.draw.bind( this ) );

};

var fil='blanchedAlmond',
strk="gainsboro";

var myDrawing1 = new Drawing( svgString1, '', 2500 );
animSvg.select('#dim').animate({opacity:1},1000);

myDrawing1.initDraw();
myDrawing1.callOnFinished = function(){

      var contour = animSvg.paper.path("M533 232c0,137 0,368 0,482l148 0 0 -614 -498 0 0 614 130 0 0 -482 220 0z M654 544c-38,0 -49,0 -90,0l0 -138 90 0 0 138z M192 593l0 -128 109 0c0,17 0,114 0,128l-109 0zM533 232l0 482 148 0 0 0c-9,0 -145,0 -148,0l0 -482 -220 0 0 0 220 0z M183 714l130 0c0,0 0,0 0,0 -28,0 -45,0 -130,0l0 0z")
          .attr({
            fill : 'linen ',
            stroke: strk,
            strokeWidth: 3,
            opacity:0   
        });


        animSvg.select('#dim').animate({opacity:0},1500);
        animSvg.select('#s3').animate({opacity:0},1000);
         contour.animate({
        'd':'M533 232c0,137 0,368 0,482l148 0 0 -614 -498 0 0 614 130 0 0 -482 220 0z M654 544c-38,0 -49,0 -90,0l0 -138 90 0 0 138z M192 593l0 -128 109 0c0,17 0,114 0,128l-109 0z M533 232l0 482 148 0 0 0c-9,0 -145,0 -148,0l0 -482 -220 0 0 0 220 0z M183 714l130 0c0,0 0,0 0,0 -28,0 -45,0 -130,0l0 0z',
            opacity:1   
                }, 1500, mina.easeinout, 
                    function(){
                        // document.getElementById('dim');
                        contour.animate({
                            'd':'M462 501c192,49 385,98 577,148l223 -31 -727 -131 -479 19 -154 323 538 -85 -228 -233 250 -10z  M939 563c-49,4 -98,8 -147,13l-136 -34 119 -9 164 30z M-8 656l25 -51 242 -19c11,14 22,28 33,42l-300 28z M462 509l578 161 222 -33 0 -19c-74,10 -149,20 -223,31l-577 -148 -249 11 9 9 240 -12z M-98 859l539 -86c0,-10 2,-30 -2,-29 -179,28 -358,57 -537,85l0 30z',
                            fill : fil,
                            strokeWidth: 2, 
                            stroke :strk,
                                    }, 750, mina.easeinout, 
                                                                function(){
                                                                    bck.animate({opacity:1},3000); 
                                                                    contour.animate({opacity:0},5000);
                                                                }
                    )}
                );

}
}
