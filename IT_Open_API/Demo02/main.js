var canvas,context;
var img,
    imgIsLoaded,
    imgX=0,
    imgY=0,
    imgScale = 1;
var img_mark;
var mark_pos="";


(function int() {
    canvas=document.getElementById('canvas');
    context=canvas.getContext('2d');
    canvas.width = document.body.clientWidth;
    canvas.height = document.body.clientHeight;
    loadImg();
})();

function loadImg(){
    img_mark = new Image();
    img = new Image();
    img.onload=function(){
        imgIsLoaded=true;
        drawImage();
    }
    img.src = "map.jpg";
    img_mark.src = "gps.png";
}

function drawImage() {
    context.clearRect(0,0,canvas.width,canvas.height);
    context.drawImage(img, 0, 0, img.width, img.height, imgX, imgY, img.width * imgScale, img.height * imgScale);

    if (mark_pos != "")
    {
        var strs_1 = new Array();
        strs_1 = mark_pos.split("|");
        for (i = 0; i < strs_1.length ; i++)
        {
            if (strs_1[i] != "")
            {
                var strs_2 = new Array();
                strs_2 = strs_1[i].split(",");
                context.globalCompositeOperation = "source-over";
                context.beginPath();
                context.drawImage(img_mark, strs_2[0] * imgScale + imgX, strs_2[1] * imgScale + imgY, img_mark.width, img_mark.height);
            }
        }
    }
}

function drawImage_resize() {
    canvas.width = document.body.clientWidth;
    canvas.height = document.body.clientHeight-29;
    loadImg();
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
        drawImage();
    }
    canvas.onmouseup=function(){
        canvas.onmousemove=null;
        canvas.onmouseup=null;
        canvas.style.cursor="default";
    }
}
canvas.onmousewheel=canvas.onwheel=function(event){
    var pos=windowToCanvas(canvas,event.clientX,event.clientY);
    event.wheelDelta=event.wheelDelta?event.wheelDelta:(event.deltaY*(-40));
    if(event.wheelDelta>0){
        imgScale*=2;
        imgX=imgX*2-pos.x;
        imgY=imgY*2-pos.y;
    }else{
        imgScale/=2;
        imgX=imgX*0.5+pos.x*0.5;
        imgY=imgY*0.5+pos.y*0.5;
    }
    drawImage();
}

function windowToCanvas(canvas,x,y){
    var bbox = canvas.getBoundingClientRect();
    return {
        x:x - bbox.left - (bbox.width - canvas.width) / 2,
        y:y - bbox.top - (bbox.height - canvas.height) / 2
    };
}

function suofang(event){
    var pos=windowToCanvas(canvas,800,800);
    if(event>0){
        imgScale*=2;
        imgX=imgX*2-pos.x;
        imgY=imgY*2-pos.y;
    }else{
        imgScale/=2;
        imgX=imgX*0.5+pos.x*0.5;
        imgY=imgY*0.5+pos.y*0.5;
    }
    drawImage();
}

function mark_image() {
    var strs_2 = new Array();
    strs_2 = document.getElementById('Text1').value.split(",");
    imgX = canvas.width/2 - strs_2[0];
    imgY = canvas.height/2 - strs_2[1];
    mark_pos += "|" + document.getElementById('Text1').value;
    drawImage();
}

function mark_clear() {
    mark_pos = "";
    drawImage();
}

function screenInfo() {
    var s = "";
    s += "\r\n网页可见区域宽：" + document.body.clientWidth;
    s += "\r\n网页可见区域高：" + document.body.clientHeight;
    s += "\r\n网页可见区域宽：" + document.body.offsetWidth + " (包括边线的宽)";
    s += "\r\n网页可见区域高：" + document.body.offsetHeight + " (包括边线的宽)";
    s += "\r\n网页正文全文宽：" + document.body.scrollWidth;
    s += "\r\n网页正文全文高：" + document.body.scrollHeight;
    s += "\r\n网页被卷去的高：" + document.body.scrollTop;
    s += "\r\n网页被卷去的左：" + document.body.scrollLeft;
    s += "\r\n网页正文部分上：" + window.screenTop;
    s += "\r\n网页正文部分左：" + window.screenLeft;
    s += "\r\n屏幕分辨率的高：" + window.screen.height;
    s += "\r\n屏幕分辨率的宽：" + window.screen.width;
    s += "\r\n屏幕可用工作区高度：" + window.screen.availHeight;
    s += "\r\n屏幕可用工作区宽度：" + window.screen.availWidth;
    alert(s);
}

canvas.onclick = function (evt) {
    var rect = canvas.getBoundingClientRect();
    alert((evt.clientX - rect.left * (canvas.width / rect.width))+"|"+(evt.clientY - rect.top * (canvas.height / rect.height)));
}

function sendAJAX() {

    $.ajax({
        type: "POST",
        url: "Http://172.16.136.99:8095/gis/gis01/Navigation_ByPos",
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        data: '{"s_pos_x":"740","s_pos_y":"395","d_pos_x":"600","d_pos_y":"600"}',
        success: function (data) {
            alert(data.Str_Return);
        },
        error: function () {
            alert("2");
        }
    });
}