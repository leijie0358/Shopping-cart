var canvas,context;
var img;
var imgIsLoaded;
var imgX=0,imgY=0,imgScale = 1;
var img_mark;
var mark_pos=new Array();
var nav=new Array();
var currentImage = 0;
var navflag=0;
var gradient;
var color1=255;
var count=0,count1=0;
var click=0;
var timeperson,timeroom;
var roomstatus=new Array();
var room=new Array();
var location1=new Array();
var paint=function(){};
var updateIdleTime=function(){}
var painMeetingromm=function(roomnum){}
function thumbnail(){
    var PAINT_INTERVAL = 20;
	var IDLE_TIME_OUT = 3000;
	var PAINT_SLOW_INTERVAL = 2;

	var NAVPANEL_XRATIO = 0.8;
	var NAVPANEL_HEIGHT = 60;

	var NAVBUTTON_XOFFSET = 5;
	var NAVBUTTON_YOFFSET = 8;
	var NAVBUTTON_WIDTH = 20;
//	var NAVBUTTON_YRATIO = 0.8;
	
	var NAVBUTTON_ARROW_XOFFSET = 5;
	var NAVBUTTON_ARROW_YOFFSET = 15;

	var HL_OFFSET = 3;

	var THUMBNAIL_LENGTH = NAVPANEL_HEIGHT - NAVBUTTON_YOFFSET*2;
	var MIN_THUMBNAIL_LENGTH = 10;

	var NAVPANEL_COLOR = 'rgba(100, 100, 100, 0.2)';
	var NAVBUTTON_BACKGROUND = 'rgb(40, 40, 40)';
	var NAVBUTTON_COLOR = 'rgb(255, 255, 255)';
	var NAVBUTTON_HL_COLOR = 'rgb(100, 100, 100)';

	var ARROW_HEIGHT = 10;
	var BORDER_WRAPPER = 2;

	canvas = document.getElementById('myCanvas');
	context = canvas.getContext('2d');
//    var airview = document.getElementById('airview');
//    var context1 = airview.getContext('2d');
	var navRect;
	var lButtonRect;
	var rButtonRect;

	var imageLocations = [
		'楼层图1.png'
	];
	var imageCount = imageLocations.length;
	var images = new Array(imageCount);
	var imageRects = new Array(0);
	var loadedImages = false;
    for(var i=0;i<imageCount;i++){
        mark_pos[i]="";
        nav[i]="";
        room[i]=new Array();
        roomstatus[i]=new Array();
        location1[i]="";
    }

	var loopId;
	var loopInterval = PAINT_INTERVAL;
	var currentImage = 0;
	var firstImageIndex = 0;
	var thumbNailCount = 0;
	var maxThumbNailCount = 0;

	var idleTime = 0;

	var lastMousePos;
    for(var i=0;i<100;i++){
        room[currentImage][i]="";
        roomstatus[currentImage][i]="0";
    }   
	this.load = function() {
		//resize
		resize();
		window.onresize = resize;
		
		//event binding
		canvas.onclick = onMouseClick;
		canvas.onmousemove = onMouseMove;

		loadImages();		

		startLoop();
		updateIdleTime();
		img_mark = new Image();
		img_mark.src = "personInfo.png";
		room[currentImage][0]="416,280|492,303|477,363|393,336";
		room[currentImage][1]="482,409|603,447|582,510|461,471";
		room[currentImage][2]="603,447|726,488|707,550|582,510";
	}

	function getTime() {
		return new Date().getTime();
	}

	function updateIdleTime() {
		idleTime = getTime();
		if (loopInterval != PAINT_INTERVAL) {
			clearInterval(loopId);
			loopId = setInterval(mainLoop, PAINT_INTERVAL);
			loopInterval = PAINT_INTERVAL;
		}
	}

	function mainLoop() {
		if (loopInterval == PAINT_INTERVAL &&
			idleTime && getTime() - idleTime > IDLE_TIME_OUT) {
			clearInterval(loopId);
			loopId = setInterval(mainLoop, PAINT_SLOW_INTERVAL);
			loopInterval = PAINT_SLOW_INTERVAL;
		}

		paint();
	}

	function startLoop() {
		loopId = setInterval(mainLoop, PAINT_INTERVAL);
	}

	function resize() {
		var size = getScreenSize();
		canvas.width = size.width;
		canvas.height = size.height;
		paint();
	}

	function getScreenSize() {
		return { width: document.documentElement.clientWidth, height: document.documentElement.clientHeight-50};
	}
	
	function pointIsInRect(point, rect) {
		return (rect.x < point.x && point.x < rect.x + rect.width && 
				rect.y < point.y && point.y < rect.y + rect.height);
	}
    canvas.onclick = function (evt) { 
    var rect = canvas.getBoundingClientRect(); 
    alert((evt.clientX - rect.left * (canvas.width / rect.width))+"|"+(evt.clientY - rect.top * (canvas.height / rect.height))); 
    
    }


	function onMouseClick(event) {
		point = {x: event.clientX, y:event.clientY};
		lastMousePos = point;

		if (pointIsInRect(point, lButtonRect)) {
			nextPane(true);
		} else if (pointIsInRect(point, rButtonRect)) {
			nextPane(false);
		} else {
			var selectedIndex = findSelectImageIndex(point);
			if (selectedIndex != -1) {
				selectImage(selectedIndex);
			}
		}
		updateIdleTime();
	}

	function findSelectImageIndex(point) {
		for(var i = 0; i < imageRects.length; i++) {
			if (pointIsInRect(point, imageRects[i].rect))
				return i + firstImageIndex;
		}
		return -1;
	}

	function selectImage(index) {
		currentImage = index;
		paint();
	}

	function nextPane(previous) {
		if (previous) {
			firstImageIndex = firstImageIndex - maxThumbNailCount < 0? 0 : firstImageIndex - maxThumbNailCount;
		} else {
			firstImageIndex = firstImageIndex + maxThumbNailCount*2 - 1 > imageCount - 1? (imageCount - maxThumbNailCount > 0? imageCount - maxThumbNailCount: 0) : firstImageIndex + maxThumbNailCount;
			
		}
		currentImage = (firstImageIndex <= currentImage && currentImage <= firstImageIndex + maxThumbNailCount)? currentImage : firstImageIndex;
		paint();
	}

	function onMouseMove(event) {
		lastMousePos = {x:event.clientX, y:event.clientY};
		paint();
		updateIdleTime();
	}

	function loadImages() {
		var total = imageLocations.length;
		var imageCounter = 0;
		var onLoad = function(err, msg) {
			if (err) {
				console.log(msg);
			}
			imageCounter++;
			if (imageCounter == total) {
				loadedImages = true;
			}
		}

		for (var i = 0; i < imageLocations.length; i++) {
			var img = new Image();
			img.onload = function() { onLoad(false); };
			img.onerror = function() { onLoad(true, e);}; 
			img.src = imageLocations[i];
			images[i] = img;
		}
//		var w = document.body.scrollWidth*0.9;//设置canvas宽度
//        var h = document.body.scrollHeight*0.6;
var w = 1221;
var h = 545;
        canvas.setAttribute('width', w);
        canvas.setAttribute('height', h);
//        context1.fillRect(w-50,0,50,50);
	}
    
	function paint() {
		context.clearRect(0, 0, canvas.width, canvas.height);
		paintImage(currentImage);
        
        var paintInfo = {inLeftBtn:false, inRightBtn:false, inThumbIndex: null}

		if (lastMousePos && navRect && lButtonRect && rButtonRect) {
			if (pointIsInRect(lastMousePos, navRect)) {
				paintInfo.inLeftBtn = pointIsInRect(lastMousePos, lButtonRect);
				paintInfo.inRightBtn = pointIsInRect(lastMousePos, rButtonRect);
				if (!paintInfo.inLeftBtn && !paintInfo.inRightBtn) {
					var index = findSelectImageIndex(lastMousePos);
					if (index != -1) {
						paintInfo.inThumbIndex = index;
					}
				}
			}
		}
                //导航
		drawMark(imgX,imgY);	//做标记
		//painMeetingromm(3);
//        if(idleTime && getTime() - idleTime <= IDLE_TIME_OUT) 
         {
			//paintNavigator(paintInfo);
		}      

            if(location1[currentImage]!=""){
                var str=new Array();
                str=location1[currentImage].split("|");
                var strs_2 = new Array();
                strs_2 = str[0].split(",");

    //            context.globalAlpha=0.5;
   /*              if(navflag==1)
                {alert(1)
                	context.fillStyle='red';
                	
                }
                else*/
				//if(navflag)
					//drawnav();
             
                context.beginPath();
                context.save();

                context.moveTo(imgX+strs_2[0]*imgScale,imgY+strs_2[1]*imgScale); //alert(2) 
                context.save();          
               
                for(var j=1;j<str.length ; j++){
                    strs_2 = str[j].split(",");
                    context.lineTo(imgX+strs_2[0]*imgScale,imgY+strs_2[1]*imgScale);
                }
                context.closePath();
//                context.strokeStyle = "blue";//alert(1)  
                if(navflag){
                	context.fillStyle='red';  context.fill();
                }                 
                if(count%2)            
                    context.strokeStyle='blue';
                else
                    context.strokeStyle='yellow'; 
                context.lineWidth=2;
                

                                
                context.stroke();
                context.restore();
                context.restore();
            }	
    }
    function painMeetingromm(roomnum){
        meetingRoomStatus();
       for(var i=0;i<roomnum;i++)
        {
            if(room[currentImage][i]!=""&&room[currentImage][i]!=null){
                var str=new Array();
                str=room[currentImage][i].split("|");
                var strs_2 = new Array();
                strs_2 = str[0].split(",");
                if(roomstatus[currentImage][i]==0)
                    context.fillStyle='rgba(0, 255, 0, 0.7)';
                else
                    context.fillStyle='rgba(255, 0, 0, 0.7)';
    //            context.globalAlpha=0.5;
                context.beginPath();
                context.strokeStyle = "red";//alert(1)
                context.moveTo(imgX+strs_2[0]*imgScale,imgY+strs_2[1]*imgScale); //alert(2)           
                for(var j=1;j<str.length ; j++){
                    strs_2 = str[j].split(",");
                    context.lineTo(imgX+strs_2[0]*imgScale,imgY+strs_2[1]*imgScale);
                }
                context.closePath();
//                if(count1%2)            
 //                   context.strokeStyle='blue';
 //               else
//                    context.strokeStyle='yellow'; 
//                context.lineWidth=2;
                context.fill();
//                if(!navflag)
//                    context.stroke();
            }
        }    
    }
    function drawMark(x,y){
        var rect = canvas.getBoundingClientRect();
        if (mark_pos[currentImage]!= "")
        {//alert(mark_pos[currentImage])
//         alert(mark_pos[currentImage])           
             var strs_1 = new Array();
            strs_1 = mark_pos[currentImage].split("|");
            for (i = 0; i < 2 ; i++)
            {
                if (strs_1[i] != "")
                {
                    var strs_2 = new Array();
                    strs_2 = strs_1[i].split(",");
                    context.globalCompositeOperation = "source-over";
                    context.beginPath();
//             if(i>0)
//            context.drawImage(img_mark, strs_2[0] * imgScale + x-img_mark.width*0.45, strs_2[1] * imgScale + y-img_mark.height*0.9, img_mark.width, img_mark.height);
			if(navflag){
				$('#roominfobox').hide();
				var divObj=document.getElementById('infobox');
				$('#infobox').show();
				divObj.style.position='absolute';
				divObj.style.left = strs_2[0] * imgScale + x - img_mark.width * 0.35 + rect.left * (canvas.width / rect.width) + "px";
				divObj.style.top=strs_2[1] * imgScale + y-img_mark.height*1.2+rect.top * (canvas.height / rect.height)+"px";
			}
			else{
				$('#infobox').hide();
				var divObj=document.getElementById('roominfobox');
				$('#roominfobox').show();
				divObj.style.position='absolute';
				divObj.style.left = strs_2[0] * imgScale + x - img_mark.width * 0.45 + rect.left * (canvas.width / rect.width) + "px";
				divObj.style.top = strs_2[1] * imgScale + y - img_mark.height * 1.85 + rect.top * (canvas.height / rect.height) + "px";
				
			}
//                    for(var j=0;j<count%5;j++)
//                    {
////                        EvenCompEllipse(context, strs_2[0] * imgScale + x, strs_2[1]* imgScale + y, 4*(j+1), 2*(j+1)); 
//                    }                              
                 }


            }
        }        
    }
    function EvenCompEllipse(context, x, y, a, b)
    {
       context.save();
        
       var r = (a > b) ? a : b; 
       var ratioX = a / r;
       var ratioY = b / r;
       context.scale(ratioX, ratioY);
       context.beginPath();

       context.moveTo((x + a) / ratioX, y / ratioY);
       context.arc(x / ratioX, y / ratioY, r, 0, 2 * Math.PI);
       context.closePath();
       if(count%10<5)
        context.strokeStyle = "red";
       else
        context.strokeStyle = "green"
       context.lineWidth=2
       context.stroke();
       context.restore();
    };
    function drawnav(){
        if(nav[currentImage]!=""){	
            var strs_1 = new Array();
            strs_1=nav[currentImage].split('|');
            var strs_2 = new Array();
            strs_2 = strs_1[0].split(",");
            context.globalCompositeOperation = "source-over";

            context.beginPath();
            context.save();
            context.moveTo(imgX+strs_2[0]*imgScale,imgY+strs_2[1]*imgScale);   
            context.save();
             for (var j = 1; j < strs_1.length ; j++)
            {
                if (strs_1[j] != "")
                {
            
                    strs_2 = strs_1[j].split(",");
                    context.lineTo(imgX+strs_2[0]*imgScale,imgY+strs_2[1]*imgScale); 
                }
            }

            context.lineWidth = 5;
            context.strokeStyle =gradient;           
//			context.fillStyle = gradient;            
			context.stroke();
            context.restore();
            context.restore();
        }  
    }
	function paintLeftButton(navRect, color1) {
		//left button
		lButtonRect = {
			x: navRect.x + NAVBUTTON_XOFFSET,
			y: navRect.y + NAVBUTTON_YOFFSET,
			width: NAVBUTTON_WIDTH,
			height: navRect.height - NAVBUTTON_YOFFSET * 2
		}

		context.save();
		context.fillStyle = color1;
		context.fillRect(lButtonRect.x, lButtonRect.y, lButtonRect.width, lButtonRect.height);

		//left arrow
		context.save();
		context.fillStyle = NAVBUTTON_COLOR;
		context.beginPath();
		context.moveTo(lButtonRect.x + NAVBUTTON_ARROW_XOFFSET, lButtonRect.y + lButtonRect.height/2);
		context.lineTo(lButtonRect.x + lButtonRect.width - NAVBUTTON_ARROW_XOFFSET, lButtonRect.y + NAVBUTTON_ARROW_YOFFSET);
		context.lineTo(lButtonRect.x + lButtonRect.width - NAVBUTTON_ARROW_XOFFSET, lButtonRect.y + lButtonRect.height - NAVBUTTON_ARROW_YOFFSET);
		context.lineTo(lButtonRect.x + NAVBUTTON_ARROW_XOFFSET, lButtonRect.y + lButtonRect.height/2);
		context.closePath();
		context.fill();
		context.restore();

		context.restore();
	}

	function paintRightButton(navRect, color1) {
		rButtonRect = {
			x: navRect.x + navRect.width - NAVBUTTON_XOFFSET - lButtonRect.width,
			y: lButtonRect.y,
			width: lButtonRect.width,
			height: lButtonRect.height
		}

		context.save();
		context.fillStyle = color1;
		context.fillRect(rButtonRect.x, rButtonRect.y, rButtonRect.width, rButtonRect.height);

		//right button
		context.save();
		context.fillStyle = NAVBUTTON_COLOR;
		context.beginPath();
		context.moveTo(rButtonRect.x + NAVBUTTON_ARROW_XOFFSET, rButtonRect.y + NAVBUTTON_ARROW_YOFFSET);
		context.lineTo(rButtonRect.x + rButtonRect.width - NAVBUTTON_ARROW_XOFFSET, rButtonRect.y + rButtonRect.height/2);
		context.lineTo(rButtonRect.x + NAVBUTTON_ARROW_XOFFSET, rButtonRect.y + rButtonRect.height - NAVBUTTON_ARROW_YOFFSET);
		context.lineTo(rButtonRect.x + NAVBUTTON_ARROW_XOFFSET, rButtonRect.y + NAVBUTTON_ARROW_YOFFSET);
		context.closePath();
		context.fill();
		context.restore();

		context.restore();

	}

	function paintNavigator(paintInfo) {
		navRect = {
			x: canvas.width * (1-NAVPANEL_XRATIO)/2,
			y: canvas.height - NAVPANEL_HEIGHT,
			width: canvas.width * NAVPANEL_XRATIO,
			height: NAVPANEL_HEIGHT
		};
		
		//background
		context.save();
		context.fillStyle = NAVPANEL_COLOR;
		context.fillRect(navRect.x, navRect.y, navRect.width, navRect.height);
		context.restore();

		paintLeftButton(navRect, paintInfo && paintInfo.inLeftBtn? NAVBUTTON_HL_COLOR: NAVBUTTON_BACKGROUND);
		paintRightButton(navRect, paintInfo && paintInfo.inRightBtn? NAVBUTTON_HL_COLOR: NAVBUTTON_BACKGROUND);
		paintThumbNails(paintInfo? paintInfo.inThumbIndex:null);
	}

	function getSlicingSrcRect(rectSrc, rectDest) {
		var ratioDest = rectDest.width/rectDest.height;
		var ratioSrc = rectSrc.width/rectSrc.height;
		var sRect = {x:0, y:0, width:0, height:0};

		if (ratioSrc > ratioDest) {
			var ratio = rectSrc.height/rectDest.height;
			sRect.x = (rectSrc.width - rectDest.width*ratio)/2;
			sRect.y = 0;
			sRect.width = rectDest.width * ratio;
			sRect.height = rectSrc.height;
			return sRect;
		} else {
			var ratio = rectSrc.width/rectDest.width;
			sRect.x = 0;
			sRect.y = (rectSrc.height - rectDest.height*ratio)/2;
			sRect.width = rectDest.width;
			sRect.height = rectSrc.height * ratio;
			return sRect;
		}
	}

	function paintThumbNails(inThumbIndex) {
		if (!loadedImages)
			return;
		
		if(inThumbIndex != null) {
			inThumbIndex -= firstImageIndex;
		} else {
			inThumbIndex = -1;
		}

		var thumbnail_length = rButtonRect.x - lButtonRect.x - lButtonRect.width;
		maxThumbNailCount = Math.ceil(thumbnail_length / THUMBNAIL_LENGTH);
		var offset = (thumbnail_length - THUMBNAIL_LENGTH * maxThumbNailCount) / (maxThumbNailCount + 1);
		if (offset < MIN_THUMBNAIL_LENGTH) {
			maxThumbNailCount = Math.ceil(thumbnail_length/ (THUMBNAIL_LENGTH + MIN_THUMBNAIL_LENGTH));
			offset = (thumbnail_length - THUMBNAIL_LENGTH * maxThumbNailCount) / (maxThumbNailCount + 1);
		}

		thumbNailCount = maxThumbNailCount > imageCount - firstImageIndex? imageCount - firstImageIndex: maxThumbNailCount;

		imageRects = new Array(thumbNailCount);

		for (var i = 0; i < thumbNailCount; i++) {
			image = images[i+firstImageIndex];
			context.save();
			var x = lButtonRect.x + lButtonRect.width + (offset+THUMBNAIL_LENGTH)*i;
			srcRect = getSlicingSrcRect({width:image.width, height:image.height}, {width:THUMBNAIL_LENGTH, height: THUMBNAIL_LENGTH});
			imageRects[i] = {
				image:image, 
				rect: {
					x:x+offset, 
					y:inThumbIndex == i? navRect.y+NAVBUTTON_YOFFSET-HL_OFFSET: navRect.y+NAVBUTTON_YOFFSET, 
					height: THUMBNAIL_LENGTH, 
					width: THUMBNAIL_LENGTH
				}
			}

			if (inThumbIndex == i) {
			 if(idleTime && getTime() - idleTime <= IDLE_TIME_OUT)
				paintHighLightImage(srcRect, imageRects[i]);
			}

			context.translate(x, navRect.y);
 //           alert(srcRect.x)			
            context.drawImage(image, srcRect.x, srcRect.y, srcRect.width, srcRect.height, 
							  offset, imageRects[i].rect.y - navRect.y, 
							  THUMBNAIL_LENGTH, THUMBNAIL_LENGTH);

            context.restore();	
            }
	}

	function paintHighLightImage(srcRect, imageRect) {
		var ratio = imageRect.image.width == srcRect.width? THUMBNAIL_LENGTH/imageRect.image.width : THUMBNAIL_LENGTH/imageRect.image.height;
		ratio *= 1.5;
//        alert(ratio)
		var destRect = {
			x:imageRect.rect.x + imageRect.rect.width/2 - imageRect.image.width*ratio/2, 
			y:navRect.y - ARROW_HEIGHT - BORDER_WRAPPER - imageRect.image.height*ratio, 
			width: imageRect.image.width * ratio, 
			height: imageRect.image.height * ratio
		}

		var wrapperRect = {
			x: destRect.x - BORDER_WRAPPER, 
			y: destRect.y - BORDER_WRAPPER,
			width: destRect.width + BORDER_WRAPPER * 2,
			height: destRect.height + BORDER_WRAPPER * 2
		}

		var arrowWidth = ARROW_HEIGHT * Math.tan(30/180*Math.PI);

		context.save();
		context.fillStyle = 'white';
		context.translate(wrapperRect.x, wrapperRect.y);
		context.beginPath();
		context.moveTo(0, 0);
		context.lineTo(wrapperRect.width, 0);
		context.lineTo(wrapperRect.width, wrapperRect.height);
		context.lineTo(wrapperRect.width/2 + arrowWidth, wrapperRect.height);
		context.lineTo(wrapperRect.width/2, wrapperRect.height+ARROW_HEIGHT);
		context.lineTo(wrapperRect.width/2 - arrowWidth, wrapperRect.height);
		context.lineTo(0, wrapperRect.height);
		context.lineTo(0, 0);
		context.closePath();
		context.fill();
		context.drawImage(imageRect.image, BORDER_WRAPPER, BORDER_WRAPPER, destRect.width, destRect.height);
		if(imageRects[currentImage]==imageRect){
            if (mark_pos[currentImage] != "")
            {
        //         alert(mark_pos[currentImage])           
                var strs_1 = new Array();
                strs_1 = mark_pos[currentImage].split("|");
                for (var j = 0; j < strs_1.length ; j++)
                {
                    if (strs_1[j] != "")
                    {
                        var strs_2 = new Array();
                        strs_2 = strs_1[j].split(",");
         
    //                           context.globalCompositeOperation = "source-over";
    //                            context.beginPath(); 
    	context.drawImage(img_mark,  BORDER_WRAPPER+strs_2[0]*ratio-img_mark.width*0.45, BORDER_WRAPPER+strs_2[1]*ratio-img_mark.height*0.9, img_mark.width, img_mark.height);
                 
                    }
                }
            } 		
        }
		context.restore();
	}

	function getScaleRatio(rectSrc, rectDest) {
		var ratioDest = rectDest.width/rectDest.height;
		var ratioSrc = rectSrc.width/rectSrc.height;

		if (ratioSrc < ratioDest)
			return rectDest.height/rectSrc.height;
		else 
			return rectDest.width/rectSrc.width;
	}

	function paintImage(index) {
		if (!loadedImages)
			return;
		var image = images[index];
		var screen_h = canvas.height;
		var screen_w = canvas.width;
		var ratio = getScaleRatio({width:image.width, height:image.height}, {width:screen_w, height:screen_h});
		var img_h = image.height * ratio;
		var img_w = image.width * ratio;

//		context.drawImage(image, (screen_w - img_w)/2, (screen_h - img_h)/2, img_w, img_h);
        context.drawImage(image, 0, 0, image.width, image.height, imgX, imgY, image.width * imgScale, image.height * imgScale);
	}
//canvas.onmousewheel=canvas.onwheel=function(event){
//    var pos=windowToCanvas(canvas,event.clientX,event.clientY);
//    event.wheelDelta=event.wheelDelta?event.wheelDelta:(event.deltaY*(-40));
//    if(event.wheelDelta>0){
//        imgScale*=2;
//        imgX=imgX*2-pos.x;
//        imgY=imgY*2-pos.y;
//    }else{
//        imgScale/=2;
//        imgX=imgX*0.5+pos.x*0.5;
//        imgY=imgY*0.5+pos.y*0.5;
//    }
//    paint();
//}
canvas.ondblclick=function(event){
    click++;
    var pos=windowToCanvas(canvas,event.clientX,event.clientY);
//    event.wheelDelta=event.wheelDelta?event.wheelDelta:(event.deltaY*(-40));
    if(click%2){
        imgScale*=2;
        imgX=imgX*2-pos.x;
        imgY=imgY*2-pos.y;
    }else{
        imgScale/=2;
        imgX=imgX*0.5+pos.x*0.5;
        imgY=imgY*0.5+pos.y*0.5;
    }
    paint();    
}

function windowToCanvas(canvas,x,y){
    var bbox = canvas.getBoundingClientRect();
    return {
        x:x - bbox.left - (bbox.width - canvas.width) / 2,
        y:y - bbox.top - (bbox.height - canvas.height) / 2
    };
}
canvas.onmousedown=function(event){
    var pos=windowToCanvas(canvas,event.clientX,event.clientY);
    canvas.onmousemove=function(event){
        canvas.style.cursor="move";
        var pos1=windowToCanvas(canvas,event.clientX,event.clientY);
        var x=pos1.x-pos.x;
        var y=pos1.y-pos.y;
        pos=pos1;
        imgX+=x;
        imgY+=y;
        paint();
    }
    canvas.onmouseup=function(){
        canvas.onmousemove=null;
        canvas.onmouseup=null;
        canvas.style.cursor="default";
    }
}

}
function mark_image() {
    
    mark_pos[currentImage] += "|" + document.getElementById('Text1').value;
    var strs_1=document.getElementById('Text1').value;
    var strs_2 = new Array();
    strs_2 = strs_1.split(",");
        
    if(imgX+strs_2[0]*imgScale>790||(imgX+strs_2[0]*imgScale)<10)
        imgX=400-strs_2[0]*imgScale;
    if(imgY+strs_2[1]*imgScale>790||(imgY+strs_2[1]*imgScale)<10)
        imgY=400-strs_2[1]*imgScale;    
    updateIdleTime();   
    paint();

}

function mark_clear() {
    mark_pos[currentImage] = "";
    paint();
}
function navigate(){

//    nav[currentImage]=document.getElementById('Text1').value;

    paint();    


}

function searchPerson() {
//        $("#divMessagePanel").html("");
		var url=location.href;
//		alert(url.lastIndexOf('/'))
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/gis/gis01/Search_Entity_POS";
 //           var formativeData = '{"s_pos_x":"'+$("#Text2").val()+'","s_pos_y":"'+$("#Text3").val()+'","d_pos_x":"'+$("#Text4").val()+'","d_pos_y":"'+$("#Text5").val()+'"}';
		var id=$("#e7").select2("data").num;
//		alert(id)
        var formativeData='{"Str_Site":"fq","search_key":"'+id+'"}';
        $.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {
//            alert(1)
//            var a = eval_r(data);
 //           alert(1)
 //           alert(data.Str_Return );
                //count=0;
//                nav[currentImage]=data.Str_Return;
//                alert(data.length);
                location1[currentImage]=data[0].Str_Return;	//目标位置各顶点坐标
//                if($("#e7").val().indexOf("Meeting")>=0){
//                	navflag=0;
//                }
//             	else{
                	navflag=1;
//             	}
                if(count==0)
                var time1=setInterval(function (){animate();navigate();},200);
        var str=new Array();
        if(location1[currentImage]!="")
            str=location1[currentImage].split('|');//alert(location1[currentImage])
		url=location.href;
//		alert(url.lastIndexOf('/'))
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/gis/gis01/Navigation_ByPos";
		var s_pos_x=740,s_pos_y=400;
        var str1=new Array();
        str1=str[0].split(',');
        formativeData = '{"Str_Site":"fq","d_pos_x":"'+str1[0]+'","d_pos_y":"'+str1[1]+'","s_pos_x":"'+s_pos_x+'","s_pos_y":"'+s_pos_y+'"}';
//		alert(formativeData)
        $.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {

                nav[currentImage]=data.Str_Return;
				
                alert(nav[currentImage])
//                mark_pos[currentImage]=$("#Text2").val()+","+$("#Text3").val()+"|"+$("#Text4").val()+","+$("#Text5").val();
                mark_pos[currentImage]=s_pos_x+","+s_pos_y+"|"+str[0]+","+str[1];

				gradient = context.createLinearGradient(s_pos_x,s_pos_y,str[0], str[1]);
//				if(count==0)
				{
					clearInterval(timeroom);
					clearInterval(timeperson);
					timeperson=setInterval(function (){animate();navigate();},200);
				}
	//			animate();

			//　　context.fillRect(50,50,100,100);
 //               alert(nav[currentImage])
                
        //                $('#divMessagePanel').html("ok");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(1)  ;
                    alert(XMLHttpRequest.responseText);
//                $("#divMessagePanel").html("error");
            },
            cache: false
        });       /* */        

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(2+"person")  ;
                    alert(XMLHttpRequest.responseText);
//                $("#divMessagePanel").html("error");
            },
            cache: false
        });

    
} 　
function searchRoom(roomcode) {
//        $("#divMessagePanel").html("");
//		alert(roomcode)
		var url=location.href;
//		alert(url.lastIndexOf('/'))
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
		url+="/gis/gis01/Search_Entity_POS";
 //           var formativeData = '{"s_pos_x":"'+$("#Text2").val()+'","s_pos_y":"'+$("#Text3").val()+'","d_pos_x":"'+$("#Text4").val()+'","d_pos_y":"'+$("#Text5").val()+'"}';
		var id=$("#e6").select2("data").num;
//		alert(id)
		var formativeData='{"Str_Site":"fq","search_key":"'+roomcode+'"}';
		if(roomcode==undefined||roomcode=="")
			formativeData='{"Str_Site":"fq","search_key":"'+id+'"}';
//		alert(formativeData)
        $.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {
//            var a = eval_r(data);
 //           alert(1)
 //           alert(data.Str_Return );
                //count=0;
//                nav[currentImage]=data.Str_Return;
//                alert(data.length);
                location1[currentImage]=data[0].Str_Return;	//目标位置各顶点坐标
				mark_pos[currentImage]=data[0].Str_Return;

//             alert(1)
//               if($("#Text2").val().indexOf("Meeting")>=0){
                	navflag=0;
 //               }
//             	else{
//                	navflag=1;
//             	}
//                if(count==0)
				{
					clearInterval(timeroom);
					clearInterval(timeperson);
					timeroom=setInterval(function (){animate();navigate();},200);
				}
/*        var str=new Array();
        if(location1[currentImage]!="")
            str=location1[currentImage].split('|');
        var str1=new Array();
        str1=str[0].split(',');
        formativeData = '{"s_pos_x":"'+$("#Text2").val()+'","s_pos_y":"'+$("#Text3").val()+'","d_pos_x":"'+str1[0]+'","d_pos_y":"'+str1[1]+'"}';
        $.ajax({
            type: "post",
            url: "http://127.0.0.1:8088/gis/gis01/Navigation_ByPos",
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {

                nav[currentImage]=data.Str_Return;

                //alert(data[1].Str_Return)
//                mark_pos[currentImage]=$("#Text2").val()+","+$("#Text3").val()+"|"+$("#Text4").val()+","+$("#Text5").val();
                mark_pos[currentImage]=$("#Text2").val()+","+$("#Text3").val()+"|"+str1[0]+","+str1[1];

//				gradient = context.createLinearGradient($("#Text2").val(),$("#Text3").val(),$("#Text4").val(), $("#Text5").val());
				if(count==0)
				var time1=setInterval(function (){animate();navigate();},200);
	//			animate();

			//　　context.fillRect(50,50,100,100);
 //               alert(nav[currentImage])
                
        //                $('#divMessagePanel').html("ok");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(1)  ;
                    alert(XMLHttpRequest.responseText);
//                $("#divMessagePanel").html("error");
            },
            cache: false
        });        */        

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(2+"room")  ;
                    alert(XMLHttpRequest.responseText);
//                $("#divMessagePanel").html("error");
            },
            cache: false
        });

    
} 　
function meetingRoomStatus(){
        //var formativeData='{"search_key":"'+$("#Text1").val()+'"}';
		var url=location.href;
//		alert(url.lastIndexOf('/'))
		url=url.substring(0,url.lastIndexOf("/"));
		url=url.substring(0,url.lastIndexOf("/"));
//		alert(url)
		url+="/gis/gis01/Load_MeetingRoom_POS_Status";
        var formativeData='{"Str_Site":"fq","search_key":"3#3F"}';
        $.ajax({
            type: "post",
            url: url,
            contentType: 'application/json',
            data:formativeData,
            dataType: 'json',
            success: function(data) {  
                var roomnum=data.length;
                for(var i=0;i<data.length;i++){
                    room[currentImage][i]=data[i].Str_Point;  
                    roomstatus[currentImage][i]=data[i].Str_Status;
                }
                //navflag=0;
//                if(!count1)

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
 //                   alert(1)  ;
                    alert(XMLHttpRequest.responseText);
//                $("#divMessagePanel").html("error");
            },
            cache: false
        });
}
function suofang(v){
    if(v>0){
        imgScale*=2;
//        imgX=imgX*2-pos.x;
 //       imgY=imgY*2-pos.y;
    }else{
        imgScale/=2;
 //       imgX=imgX*0.5+pos.x*0.5;
 //       imgY=imgY*0.5+pos.y*0.5;
    }
    paint();    

}
function animate(){
	if(gradient!=null){
	gradient.addColorStop(0,"rgb("+color1+","+color1+",0)");
	gradient.addColorStop(0.5,"rgb("+color1+",0,"+color1+")");
　　gradient.addColorStop(1,"rgb(0,"+color1+","+color1+")");
	}
    count++;
	color1-=20;
	if(color1<=0)
		color1=255;
}	
	window.onload = function() {
//	   alert(1)
		thumb = new thumbnail();
		thumb.load();
	}
