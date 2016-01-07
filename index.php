<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Javascript+canvas</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="description" content="canvas,pixel,js,jquery,script">
		<meta name="author" content="Kevin Velasquez">
		<link rel="shortcut icon" href="favicon.ico">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap-theme.min.css">
		<script src="js/jquery-1.10.2.js"></script>
		<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
	</head>
<body>
<div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">

			<div align="right">
				<h1 align="center">
				Canvas example 1
				</h1>		
				<div>
					<a href="#">next</a>
				</div>
				<canvas id="canvas" width="650px" height="500px"></canvas>
			</div>

        </div><!--/.col-xs-12.col-sm-9-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">
		
            <div class="list-group-item">Blur<input type="range" min="0" max="10" value="0" onchange="$.fn.w.blur(this)"/></div>
			<div class="list-group-item">Red<input type="range" min="0" max="100" value="0" onchange="$.fn.w.color(this,'red')"/></div>
			<div class="list-group-item">Green<input type="range" min="0" max="100" value="0" onchange="$.fn.w.color(this,'green')"/></div>
			<div class="list-group-item">Blue<input type="range" min="0" max="100" value="0" onchange="$.fn.w.color(this,'blue')"/></div>
			<div class="list-group-item">Pixelate<input type="range" min="1" max="10" value="0" onchange="$.fn.w.pixelate(this)"/></div>
          </div>
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->
	  
      <footer align="center">
		© <a href="https://framme.herokuapp.com" target="_blank">frame developer</a> |
		<a href="https://kevinvelasquez.herokuapp.com" target="_blank">Kevin Velásquez</a>
      </footer>

    </div>
<script>
var init={"0":{"items":[{"id":11,"duration":150,"t":0,"l":1,"w":100,"h":50,"x":97,"y":329},{"id":10,"duration":150,"t":0,"l":1,"w":100,"h":50,"x":109,"y":320},{"id":9,"duration":150,"t":0,"l":1,"w":100,"h":50,"x":134,"y":309},{"id":8,"duration":150,"t":0,"l":1,"w":100,"h":50,"x":139,"y":303},{"id":7,"duration":150,"t":0,"l":1,"w":100,"h":50,"x":156,"y":289},{"id":6,"duration":150,"t":0,"l":1,"w":100,"h":50,"x":168,"y":283},{"id":5,"duration":150,"t":0,"l":1,"w":100,"h":50,"x":174,"y":275},{"id":4,"duration":150,"t":0,"l":1,"w":100,"h":50,"x":178,"y":269},{"id":3,"duration":150,"t":0,"l":1,"w":100,"h":50,"x":187,"y":267},{"id":2,"duration":150,"t":0,"l":1,"w":100,"h":50,"x":191,"y":265},{"id":1,"duration":150,"t":0,"l":1,"w":100,"h":50,"x":200,"y":260},{"id":0,"duration":150,"t":0,"l":1,"w":100,"h":50,"x":206,"y":255}],"reset_mode":"inverso"},"1":{"items":[{"id":13,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":550,"y":446},{"id":12,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":530,"y":430},{"id":11,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":493,"y":414},{"id":10,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":470,"y":397},{"id":9,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":453,"y":375},{"id":8,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":438,"y":360},{"id":7,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":426,"y":354},{"id":6,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":401,"y":344},{"id":5,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":384,"y":332},{"id":4,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":376,"y":316},{"id":3,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":368,"y":308},{"id":2,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":355,"y":293},{"id":1,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":335,"y":282},{"id":0,"duration":150,"t":2,"l":0,"w":100,"h":50,"x":320,"y":272}],"reset_mode":"inverso"}};
(function ( $ ) {
	$.fn.w = {
		init:function(elem,value){
			if(value===undefined)
			{
				this["canvas"]=$(elem)[0];
				this["ctx"]=this.canvas.getContext('2d')
				this["img"]=[];
			}
			this["master_tm"]={};
			this["px_store"]={
				x:null,
				y:null,
				lastimg:null,
				newimg:null
			};
			this.load_palette("#dv input",value);
		},
		load_palette:function(index,value){
			if(value===undefined)
			{
				$.each($(index),function(i,htm){
					$.each($(htm).val().split(","),function(i,value){
						$.fn.w.img.push(parseInt(value));
					});
				}).parent().remove();
				/*$.each({"362701":144,"413531":255,"461988":116,"487857":150,"724299":255},function(key,val){
					if($.fn.w.img[key]!==val)$.fn.w.img=[];
				});	*/
				$.fn.w.img=(this.canvas.width!=(8*81.25) || this.canvas.height!=62.5*8)?[]:$.fn.w.img;			
				var palette = this.ctx.getImageData(0,0,this.canvas.width,this.canvas.height);
				palette.data.set(new Uint8ClampedArray(this.img));
				this.ctx.putImageData(palette,0,0);			
			}
			this.set_math();
		},
		set_math:function(){
			$.each(init,function(__index__,obj){
				$.each(obj.items,function(___index__,_obj){
					var event=$.extend(false, _obj);
					delete  event.x;
					delete  event.y;
					//
					event.layerX=_obj.x,
					event.layerY=_obj.y
					//
					$.fn.w.set_storepx(event);
					$.fn.w.set_masterpx(event,_obj,__index__,obj);		
				});
			});
			$.each(this.master_tm,function(__index__,obj){
				$.fn.w.start(parseInt(__index__));
			});
		},
		set_storepx:function(event){
			var __x__ = event.layerX;
			var __y__ = event.layerY;
			var __w__ = (event.w===undefined)?px_width:event.w;
			var __h__ = (event.h===undefined)?px_height:event.h
			if( this.px_store.x !== null )
			{
				this.ctx.putImageData(this.px_store.lastimg, this.px_store.x,this.px_store.y);
			}
			var __top__ =(event.t===undefined)?t:event.t;
			var __left__=(event.l===undefined)?l:event.l;
			this.px_store={
				x:__x__,
				y:__y__,
				newimg:this.ctx.getImageData( (__x__+__left__),(__y__+__top__),__w__,__h__),
				lastimg:this.ctx.getImageData(__x__,__y__,__w__, __h__)
			};
			this.ctx.putImageData(this.px_store.newimg, __x__, __y__);
		},
		set_masterpx:function(event,_obj,__index__,obj){	
			__index__=parseInt(__index__);
			var __x__ = event.layerX;
			var __y__ = event.layerY;
			var __w__ = (_obj===undefined || _obj.w===undefined)?px_width:_obj.w;
			var __h__ = (_obj===undefined ||  _obj.h===undefined)?px_height:_obj.h
			var __id__=0;	
			_obj=(_obj===undefined)?{}:_obj;
			var __json_obj__ = 
			{ 
				id:null,
				duration:(_obj.duration!=undefined)?_obj.duration:150,
				t:(_obj.t===undefined)?t:_obj.t,
				l:(_obj.l===undefined)?l:_obj.l,
				w:(_obj.w===undefined)?px_width:_obj.w,
				h:(_obj.h===undefined)?px_height:_obj.h,
				x: __x__, 
				y: __y__, 
				lastimg:this.px_store.lastimg,
				newimg:this.ctx.getImageData(__x__,__y__,__w__,__h__)
			};
			this.master_tm[__index__] = ( this.master_tm[__index__] === undefined )? {} : this.master_tm[__index__];
			var __master_tm__=this.master_tm[__index__];
			__master_tm__.items = ( __master_tm__.items === undefined)?[]:__master_tm__.items;
			__master_tm__.reset_mode=obj.reset_mode;
			__master_tm__=__master_tm__.items;
			__master_tm__.push(__json_obj__);
			__id__=(__master_tm__.length-1);
			__json_obj__.id=__id__;
			this.px_store.lastimg=this.px_store.newimg;
		},
		start:function(__index__){	
			var counter_run_event=0;
			var __index__=parseInt(__index__);
			//  __master_tm__=@DESCRIPTION
			var __master_tm__=( this.master_tm[__index__] != undefined )? this.master_tm[__index__].items:null;
			var __run_event__=function(__index)
			{
				$.fn.w.master_tm[__index].interval = window.setTimeout(function(){
					//  __json_obj__=@DESCRIPTION
					var __json_obj__=__master_tm__[counter_run_event];
					//
					$.fn.w.ctx.putImageData(__json_obj__.newimg, __json_obj__.x,__json_obj__.y);	
					counter_run_event++;
					//
					if(counter_run_event>0)
					{		
						if( __master_tm__.length == counter_run_event )
						{
							counter_run_event=0;
							//Back to original time line.
							window.setTimeout(function(){
								for(var i=__master_tm__.length-1;i>=0;i--)
								{
									/*
									 *Reset mode plano
									*/
									if($.fn.w.master_tm[__index].reset_mode==="plano")
									{
										ctx.putImageData(__master_tm__[i].lastimg, __master_tm__[i].x,__master_tm__[i].y);
									}
									/*
									 *Reset mode lineal
									*/
									if($.fn.w.master_tm[__index].reset_mode==="lineal" || $.fn.w.master_tm[__index].reset_mode==="inverso")
									{
										var ___d=__master_tm__[i].newimg;
										__master_tm__[i].newimg=__master_tm__[i].lastimg;
										__master_tm__[i].lastimg=___d;			
									}													
								}
								/*
								 *Reset mode lineal inverso
								*/
								if($.fn.w.master_tm[__index].reset_mode==="inverso")
								{
									for(var i=__master_tm__.length-1;i>=0;i--)
									{
										for(var j=i-1;j>=0;j--)
										{
											var __aux__=__master_tm__[i];
											__master_tm__[i]=__master_tm__[j];
											__master_tm__[j]=__aux__;
										}
									}
								}
								__run_event__(__index,counter_run_event);
							},__master_tm__[counter_run_event].duration);
							//window.setTimeout
							return;
						}
					}
					//
					__run_event__(__index,counter_run_event);
				}, __master_tm__[counter_run_event].duration);
				//window.setTimeout	
			}
			__run_event__(__index__);
		},
		blur:function(elem){
			var p1 = 0.99;
			var p2 = 0.99;
			var p3 = 0.99;
			var er = 0; // extra red
			var eg = 0; // extra green
			var eb = 0; // extra blue
			this
				.disabled(elem)
				.stop();
			var data = $.fn.w.get_img();
			var __blur_rate__=parseInt($(elem).val());
			for (br = 0; br < __blur_rate__; br += 1) 
			{
				for (var i = 0, n = data.length; i < n; i += 4) 
				{
					iMW = 4 * canvas.width;
					iSumOpacity = iSumRed = iSumGreen = iSumBlue = 0;
					iCnt = 0; 
					// data of close pixels (from all 8 surrounding pixels)
					aCloseData = [
						i - iMW - 4, i - iMW, i - iMW + 4, // top pixels
						i - 4, i + 4, // middle pixels
						i + iMW - 4, i + iMW, i + iMW + 4 // bottom pixels
					]; 
					// calculating Sum value of all close pixels
					for (e = 0; e < aCloseData.length; e += 1) {
						if (aCloseData[e] >= 0 && aCloseData[e] <= data.length - 3) {
							iSumOpacity += data[aCloseData[e]];
							iSumRed += data[aCloseData[e] + 1];
							iSumGreen += data[aCloseData[e] + 2];
							iSumBlue += data[aCloseData[e] + 3];
							iCnt += 1;
						}
					}
					// apply average values
					data[i] = (iSumOpacity / iCnt)*p1+er;
					data[i+1] = (iSumRed / iCnt)*p2+eg;
					data[i+2] = (iSumGreen / iCnt)*p3+eb;
					data[i+3] = (iSumBlue / iCnt);
				}
			}
			this
				.enabled(elem)
				.putImageData(data)
				.init("#canvas",true);
		},
		color:function(elem,color){
			
			var p1 = 0.99;
			var p2 = 0.99;
			var p3 = 0.99;
			var er = 0; // extra red
			var eg = 0; // extra green
			var eb = 0; // extra blue
			this
				.disabled(elem)
				.stop();
			var data = $.fn.w.get_img();

			er=(color==="red")?parseInt($(elem).val()):0;
			eg=(color==="green")?parseInt($(elem).val()):0;
			eb=(color==="blue")?parseInt($(elem).val()):0;
			
			for (var i = 0, n = data.length; i < n; i += 4) 
			{
				data[i]   = data[i]*p1+er; // red
				data[i+1] = data[i+1]*p2+eg; // green
				data[i+2] = data[i+2]*p3+eb; // blue
			}
			this
			.enabled(elem)
			.putImageData(data)
			.init("#canvas",true);
		},
		pixelate:function(elem){
			this
				.disabled(elem)
				.stop();
			var data = $.fn.w.get_img();
			var val=parseInt($(elem).val());
			var xBinSize = val,
				yBinSize = val;
			src=canvas;
			dst=canvas;
			var xSize = src.width,
				ySize = src.height,
				srcPixels = src.data,
				dstPixels = dst.data,
				x, y, i;
			data = JSON.parse(JSON.stringify($.fn.w.img));
			srcPixels=data;
			dstPixels=data;
			var pixelsPerBin = xBinSize * yBinSize,
				red, green, blue, alpha,
				nBinsX = Math.ceil(xSize / xBinSize),
				nBinsY = Math.ceil(ySize / yBinSize),
				xBinStart, xBinEnd, yBinStart, yBinEnd,
				xBin, yBin, pixelsInBin;
			for (xBin = 0; xBin < nBinsX; xBin += 1) 
			{
				for (yBin = 0; yBin < nBinsY; yBin += 1) 
				{
				  // Initialize the color accumlators to 0
				  red = 0;
				  green = 0;
				  blue = 0;
				  alpha = 0;

				  // Determine which pixels are included in this bin
				  xBinStart = xBin * xBinSize;
				  xBinEnd = xBinStart + xBinSize;
				  yBinStart = yBin * yBinSize;
				  yBinEnd = yBinStart + yBinSize;

				  // Add all of the pixels to this bin!
				  pixelsInBin = 0;
				  for (x = xBinStart; x < xBinEnd; x += 1) {
					if( x >= xSize ){ continue; }
					for (y = yBinStart; y < yBinEnd; y += 1) {
					  if( y >= ySize ){ continue; }
					  i = (xSize * y + x) * 4;
					  red += srcPixels[i + 0];
					  green += srcPixels[i + 1];
					  blue += srcPixels[i + 2];
					  alpha += srcPixels[i + 3];
					  pixelsInBin += 1;
					}
				  }

				  // Make sure the channels are between 0-255
				  red = red / pixelsInBin;
				  green = green / pixelsInBin;
				  blue = blue / pixelsInBin;
				  alphas = alpha / pixelsInBin;

				  // Draw this bin
				  for (x = xBinStart; x < xBinEnd; x += 1) {
					if( x >= xSize ){ continue; }
					for (y = yBinStart; y < yBinEnd; y += 1) {
					  if( y >= ySize ){ continue; }
					  i = (xSize * y + x) * 4;
					  dstPixels[i + 0] = red;
					  dstPixels[i + 1] = green;
					  dstPixels[i + 2] = blue;
					  dstPixels[i + 3] = alpha;
					}
				  }
				}
			}
			this
				.enabled(elem)
				.putImageData(data)
				.init("#canvas",true);
		},
		disabled:function(html){
			$(html).attr("disabled","disabled");
			return this;
		},
		enabled:function(html){
			$(html).removeAttr("disabled");
			return this;
		},
		stop:function(){
			for(var i=0;i<99999;i++)
			{
				clearTimeout(i);
			}
		},
		get_img:function(){
			return JSON.parse(JSON.stringify(this.img));
		},
		putImageData:function(data){
			var __data__ = this.ctx.getImageData(0,0,this.canvas.width,this.canvas.height);
			__data__.data.set(new Uint8ClampedArray(data));
			this.ctx.putImageData(__data__,0,0);
			return this;
		}
	};
	
	$.ajax("html.html").done(function(result){
		$("body").append(result);
		$.fn.w.init("#canvas");
	});
}( jQuery ));
</script>
</body>
</html>