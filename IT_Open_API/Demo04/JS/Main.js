var now_floor_id, now_entity_id, last_floor_id, last_entity_id, site
var count_div_status = 10
var gb_color_free = '#9FCD87'
var gb_color_busy = '#DF8080'

function load_defalut_floor() {
    site = "FQ";
    last_floor_id = now_floor_id = 3;
    last_entity_id = now_entity_id = 3;
    load_floor(now_floor_id, now_entity_id);
    init_div_table_meetingroom_status();
    
}

function init_div_table_meetingroom_status() {
    for (var i = 1; i <= count_div_status; i++) {
        draw_div_table_meetingroom_status('div_status_' + format_div_status_id(i));
    }
    refreshStatus();
}

function format_div_status_id(p_id) {
    if (p_id<10) {
        return '0' + p_id;
    }else{
    return p_id;
    }
}

function show_div(div_id) {
    var div = document.getElementById(div_id);
    div.style.display = 'inline';
}

function hide_div(div_id) {
    var div = document.getElementById(div_id);
    div.style.display = 'none';
}

function change_floor(tmp_floor, tmp_entity) {
    //show_floor();
    last_floor_id = now_floor_id;
    last_entity_id = now_entity_id;
    now_floor_id = get_floor_id(now_floor_id + tmp_floor);
    now_entity_id = get_entity_id(now_entity_id + tmp_entity);
    load_floor(now_floor_id, now_entity_id);
    windows_onload();
}

function set_active_flag(tmp_floor, tmp_entity, tmp_flag) {
    tmp_li = document.getElementById("li_" + tmp_floor);
    tmp_li.className = tmp_flag;
}

function load_floor(floor_id, entity_id) {
    //show_floor();
    var lbl_nowfloor_02 = document.getElementById("lbl_nowfloor_02");
    var obj_lbl_floor_10 = document.getElementById("lbl_floor_10");
    var obj_lbl_floor_09 = document.getElementById("lbl_floor_09");
    var obj_lbl_floor_08 = document.getElementById("lbl_floor_08");
    var obj_lbl_floor_07 = document.getElementById("lbl_floor_07");
    var obj_lbl_floor_06 = document.getElementById("lbl_floor_06");
    var obj_lbl_floor_05 = document.getElementById("lbl_floor_05");
    var obj_lbl_floor_04 = document.getElementById("lbl_floor_04");
    var obj_lbl_floor_03 = document.getElementById("lbl_floor_03");
    var obj_img_btn_changeentity = document.getElementById("img_btn_changeentity");
    

    lbl_nowfloor_02.innerHTML = entity_id + "#" + floor_id + "F";
    obj_img_btn_changeentity.src = "images/1-4_1.png";
    obj_lbl_floor_10.style.color = "#ffffff";
    obj_lbl_floor_09.style.color = "#ffffff";
    obj_lbl_floor_08.style.color = "#ffffff";
    obj_lbl_floor_07.style.color = "#ffffff";
    obj_lbl_floor_06.style.color = "#ffffff";
    obj_lbl_floor_05.style.color = "#ffffff";
    obj_lbl_floor_04.style.color = "#ffffff";
    obj_lbl_floor_03.style.color = "#ffffff";
    switch (floor_id) {
        case 10:
            obj_lbl_floor_10.style.color = "#ffff00";
            break;
        case 09:
            obj_lbl_floor_09.style.color = "#ffff00";
            break;
        case 08:
            obj_lbl_floor_08.style.color = "#ffff00";
            break;
        case 07:
            obj_lbl_floor_07.style.color = "#ffff00";
            break;
        case 06:
            obj_lbl_floor_06.style.color = "#ffff00";
            break;
        case 05:
            obj_lbl_floor_05.style.color = "#ffff00";
            break;
        case 04:
            obj_lbl_floor_04.style.color = "#ffff00";
            break;
        case 03:
            obj_lbl_floor_03.style.color = "#ffff00";
            break;
    }
}

function get_entity_text(entity_id) {
    if (entity_id > 4) {
        return (entity_id - 4) + "#";
    } else {
        return entity_id + "#";
    }
}

function get_floor_text(floor_id, floor_id_tmp) {
    if (floor_id == floor_id_tmp) {
        return floor_id + "F    当前层";
    } else {
        return floor_id + "F";
    }
}

function get_entity_id(entity_id) {
    if (entity_id < 1) {
        return entity_id + 4;
    }
    if (entity_id > 4) {
        return entity_id - 4;
    }
    return entity_id;
}

function get_floor_id(floor_id) {
    if (floor_id == 2) {
        return 10;
    }
    if (floor_id == 11) {
        return 3;
    }
    return floor_id;
}



function windows_onload() {
    var oPlay = document.getElementById('play');
    var oOl = oPlay.getElementsByTagName('ol')[0];
    var aLi1 = oOl.getElementsByTagName('li');
    var oUl = oPlay.getElementsByTagName('ul')[0];
    var aLi2 = oUl.getElementsByTagName('li');
    var i = iNum = direction = 0;
    var times = null;
    var play = null;
    show();
    for (i = 0; i < aLi1.length; i++) {
        aLi1[i].index = i;
        aLi1[i].onclick = function () {
            iNum = this.index;
            show();
        };
    }

    //按钮点击后调用的函数
    function show() {
        startMove((3 - now_floor_id) * 545);
    }

    //自动播放转向
    function autoPlay() {
        if (iNum >= aLi1.length - 1) {
            direction = 1;
        }
        else if (iNum <= 0) {
            direction = 0;
        }
        if (direction == 0) {
            iNum++;
        }
        else if (direction == 1) {
            iNum--;
        }
        show();
    }
    //自动播放
    //play = setInterval(autoPlay, 3000);
    //鼠标移入展示区停止自动播放
    oPlay.onmouseover = function () {
        clearInterval(play);
    };
    //鼠标移出展示区开启自动播放
    oPlay.onmouseout = function () {
        //play = setInterval(autoPlay, 3000);
    };

    function startMove(iTarget) {
        times = setInterval(function () {
            doMove(iTarget);
        }, 30);
    }

    function doMove(iTarget) {
        var iSpeed = (iTarget - oUl.offsetTop) / 10;
        iSpeed = iSpeed > 0 ? Math.ceil(iSpeed) : Math.floor(iSpeed);
        if (oUl.offsetTop == iTarget) {
            clearInterval(times);
            hide_div('div_lock');
        }
        else {
            oUl.style.top = oUl.offsetTop + iSpeed + 'px';
        }
    }
};

function show_gis() {
    var odiv_canvas = document.getElementById('div_canvas');
    var oPlay = document.getElementById('play');
    odiv_canvas.style.display = "";
    oPlay.style.display = "none";
}

function show_floor() {
    var odiv_canvas = document.getElementById('div_canvas');
    var oPlay = document.getElementById('play');
    oPlay.style.display = "";
    odiv_canvas.style.display = "none";
//    $('#roominfobox').hide();
//    $('#infobox').hide();
}

function show_meetingroom_status() {
    var obj_btn_meetingroom_status = document.getElementById("btn_meetingroom_status");
    if (obj_btn_meetingroom_status.src.indexOf("btn_bg_04.png") != -1) {
        obj_btn_meetingroom_status.src = "images/btn_bg_05.png";
    } else {
        obj_btn_meetingroom_status.src = "images/btn_bg_04.png";
    }

}

function change_entity(p_entity_id) {
    last_entity_id = now_entity_id;
    now_entity_id = p_entity_id;
    load_floor(now_floor_id, now_entity_id);
    windows_onload();
    hide_div("div_change_entity");
}

function chooseradio(obj) {
    document.getElementById("test").innerHTML = obj.value;
}

function showTime() {
    time = new Date();
    hours = time.getHours();
    minutes = time.getMinutes();
    seconds = time.getSeconds();
    year = time.getFullYear();      /*getyear()在IE以外的浏览器中会出问题，建议使用getFullYear()在所有浏览器中通用。*/
    month = time.getMonth() + 1;
    date = time.getDate();
    day = time.getDay();
    dayArray = new Array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六");
    // 如果分或秒是个位数，则在十位补0
    if (minutes <= 9)
        minutes = "0" + minutes;
    if (seconds <= 9)
        seconds = "0" + seconds;

//    theTime = " " + year + "年" + month + "月" + date + " "
//                     + dayArray[day] + " " + hours + ":" + minutes + ":" + seconds;
    theTime = hours + ":" + minutes + ":" + seconds;
    DT.innerHTML = theTime;

    setTimeout("showTime()", 1000);
}

function refreshStatus() {
    //alert($("#slider").slider("value") + "|" + get_td_value("div_status_01_td01") + "|" + $("#div_status_01_td01").css("backgroundColor"));
    if (site == "FQ") {
        var url = location.href;
        url = url.substring(0, url.lastIndexOf("/"));
        url = url.substring(0, url.lastIndexOf("/"));
        url += "/Exchange/Exchange01/Get_MeetingRoom_MainInfo_byKey";
        var formativeData = '{"Str_Site":"' + site + '","Str_SearchKey":"' + now_entity_id + '#' + now_floor_id + 'F"}';
        $.ajax({
            type: "post",
            url: url,
            contentType: 'text/json',
            data: formativeData,
            dataType: 'json',
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    var tmp_Value01 = data[i].Str_Value01;
                    tmp_Value01 = tmp_Value01.substring(tmp_Value01.indexOf(" "), tmp_Value01.lastIndexOf(" "));
                    set_td_value('div_status_' + format_div_status_id(i + 1) + '_td01', data[i].Str_Value02 + '人');
                    set_td_value('div_status_' + format_div_status_id(i + 1) + '_td02', tmp_Value01);
                    load_div_status_time('div_status_' + format_div_status_id(i + 1), $("#slider").slider("value"));
                    load_div_status_schedule('div_status_' + format_div_status_id(i + 1),data[i].Str_Key, time.getFullYear() + "/" + (time.getMonth() + 1) + "/" + time.getDate(), format_div_status_time($("#slider").slider("value").toString()), "4");
                    set_div_location('div_status_' + format_div_status_id(i + 1), data[i].Str_Value03, data[i].Str_Value04);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("refreshStatus Err: " + XMLHttpRequest.responseText);
            },
            cache: false
        });
    }
}

function load_div_status_schedule(p_div_id,p_meetingroom_address, p_date, p_time, p_duration) {
    var url = location.href;
    url = url.substring(0, url.lastIndexOf("/"));
    url = url.substring(0, url.lastIndexOf("/"));
    url += "/Exchange/Exchange01/Get_Appointment_Schedule_by_MeetingRoom_StartTime_Duration";
    var formativeData = '{"Str_Date":"' + p_date + '","Str_Duration":"' + p_duration + '","Str_MeetingRoom_Address":"' + p_meetingroom_address + '","Str_MeetingRoom_List":"","Str_SearchKey":"","Str_Site":"' + site + '","Str_StartTime":"' + p_time + '"}';
    $.ajax({
        type: "post",
        url: url,
        contentType: 'text/json',
        data: formativeData,
        dataType: 'json',
        success: function (data) {
            for (var i = 0; i < data.length; i++) {
                //alert(p_div_id + "_" + format_div_status_id(3 + i));
                if (data[i].Str_Value == "Free") {
                    set_obj_bgcolor(p_div_id + "_td" + format_div_status_id(3 + i), gb_color_free);
                } else {
                    set_obj_bgcolor(p_div_id + "_td" + format_div_status_id(3 + i), gb_color_busy);
                }
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("refreshStatus Err: " + XMLHttpRequest.responseText);
        },
        cache: false
    });
}

function set_obj_bgcolor(p_id,p_color) {
    document.getElementById(p_id).style.background = p_color;
}

function get_td_value(p_id) {
    return document.getElementById(p_id).innerHTML;
}

function set_td_value(p_id, p_value) {
    document.getElementById(p_id).innerHTML = p_value;
}

function load_div_status_time(p_id,p_time) {
    set_td_value(p_id + '_td03', format_div_status_time(p_time.toString()));
    set_td_value(p_id + '_td05', format_div_status_time((p_time + 1).toString()));
    set_td_value(p_id + '_td07', format_div_status_time((p_time + 2).toString()));
    set_td_value(p_id + '_td09', format_div_status_time((p_time + 3).toString()));
}

function format_div_status_time(p_time) {
    if (p_time.indexOf(".")==-1) {
        return p_time+":00";
    }else{
        return p_time.substring(0, p_time.indexOf("."))+":30";
    }
}

var amount_0, amount_1

$(document).ready(function () {
    // 隐藏与显示的切换
    //            $("button").click(function () {
    //                $("#test").toggle(2000);
    //            });

    // 上下滑动的切换
    $("#btn_meetingroom_status").click(function () {
        var obj_btn_meetingroom_status = document.getElementById("btn_meetingroom_status");
        if (obj_btn_meetingroom_status.src.indexOf("btn_bg_04.png") == -1) {
            for (var i = 1; i <= count_div_status; i++) {
                if (get_td_value('div_status_' + format_div_status_id(i) + "_td01") != "") {
                    $("#div_status_" + format_div_status_id(i)).animate({ height: '240px' }, 200);
                    $("#div_status_" + format_div_status_id(i)).show();
                }
            }

            $("#div_timeline").animate({ width: '90%' }, 200);
            $("#div_timeline").show();
        } else {
            for (var i = 1; i <= count_div_status; i++) {
                $("#div_status_" + format_div_status_id(i)).animate({ height: '0px' }, 200);
                $("#div_status_" + format_div_status_id(i)).hide(200);
            }
            $("#div_timeline").animate({ width: '0%' }, 200);
            $("#div_timeline").hide(200);
        }
    });
});

$(function () {
    $("#slider").slider({
        min: 9,
        max: 14,
        step: 0.5,
        change: refreshStatus

    });
    $("#slider").slider("value", 14);

});

function show_search_div(p_div_id) {
    $("#div_search_main").show();
    switch (p_div_id) {
        case 1:
            $("#home").show();
            $("#home").removeClass().addClass("tab-pane fade in active");
            $("#li_home").removeClass().addClass("active");
            $("#ios").hide();
            $("#ios").removeClass().addClass("tab-pane fade");
            $("#li_ios").removeClass();
            $("#jmeter").hide();
            $("#jmeter").removeClass().addClass("tab-pane fade");
            $("#li_jmeter").removeClass();
            break;
        case 2:
            $("#ios").show();
            $("#ios").removeClass().addClass("tab-pane fade in active");
            $("#li_ios").removeClass().addClass("active");
            $("#home").hide();
            $("#home").removeClass().addClass("tab-pane fade");
            $("#li_home").removeClass();
            $("#jmeter").hide();
            $("#jmeter").removeClass().addClass("tab-pane fade");
            $("#li_jmeter").removeClass();
            break;
        case 3:
            $("#jmeter").show();
            $("#jmeter").removeClass().addClass("tab-pane fade in active");
            $("#li_jmeter").removeClass().addClass("active");
            $("#home").hide();
            $("#home").removeClass().addClass("tab-pane fade");
            $("#li_home").removeClass();
            $("#ios").hide();
            $("#ios").removeClass().addClass("tab-pane fade");
            $("#li_ios").removeClass();
            break;
    }
}

function draw_div_table_meetingroom_status(p_div_id) {
    //alert(get_td_value(p_div_id));
    var tmp_html = "";
    tmp_html += '<table style="width:100%; height:100%;">';
    tmp_html += '<tr style="height:10%">';
    tmp_html += '<td id="' + p_div_id + '_td01" style="width:100%; background:#999999; color:#FFFFFF;"></td>';
    tmp_html += '</tr>';
    tmp_html += '<tr style="height:10%; ">';
    tmp_html += '<td id="' + p_div_id + '_td02" style="background:#999999; color:#FFFFFF;"></td>';
    tmp_html += '</tr>';
    tmp_html += '<tr style="height:10%; ">';
    tmp_html += '<td id="' + p_div_id + '_td03" style="background:#DF8080; color:#FFFFFF; border-bottom-style: groove; border-bottom-width: thin; border-bottom-color: #FFFFFF;"></td>';
    tmp_html += '</tr>';
    tmp_html += '<tr style="height:10%; ">';
    tmp_html += '<td id="' + p_div_id + '_td04" style="background:#DF8080; color:#FFFFFF; border-bottom-style: groove; border-bottom-width: thin; border-bottom-color: #FFFFFF;"></td>';
    tmp_html += '</tr>';
    tmp_html += '<tr style="height:10%; ">';
    tmp_html += '<td id="' + p_div_id + '_td05" style="background:#9FCD87; color:#FFFFFF; border-bottom-style: groove; border-bottom-width: thin; border-bottom-color: #FFFFFF;"></td>';
    tmp_html += '</tr>';
    tmp_html += '<tr style="height:10%; ">';
    tmp_html += '<td id="' + p_div_id + '_td06" style="background:#9FCD87; color:#FFFFFF; border-bottom-style: groove; border-bottom-width: thin; border-bottom-color: #FFFFFF;"></td>';
    tmp_html += '</tr>';
    tmp_html += '<tr style="height:10%; ">';
    tmp_html += '<td  id="' + p_div_id + '_td07" style="background:#DF8080; color:#FFFFFF; border-bottom-style: groove; border-bottom-width: thin; border-bottom-color: #FFFFFF;"></td>';
    tmp_html += '</tr>';
    tmp_html += '<tr style="height:10%; ">';
    tmp_html += '<td  id="' + p_div_id + '_td08" style="background:#DF8080; color:#FFFFFF; border-bottom-style: groove; border-bottom-width: thin; border-bottom-color: #FFFFFF;"></td>';
    tmp_html += '</tr>';
    tmp_html += '<tr style="height:10%; ">';
    tmp_html += '<td  id="' + p_div_id + '_td09" style="background:#9FCD87; color:#FFFFFF; border-bottom-style: groove; border-bottom-width: thin; border-bottom-color: #FFFFFF;"></td>';
    tmp_html += '</tr>';
    tmp_html += '<tr style="height:10%; ">';
    tmp_html += '<td  id="' + p_div_id + '_td10" style="background:#9FCD87; color:#FFFFFF;"></td>';
    tmp_html += '</tr>';
    tmp_html += '</table>';
    set_td_value(p_div_id, tmp_html);
    //alert(get_td_value(p_div_id));
}

function set_div_location(divid, coordinateX, coordinateY) {
    var divObj = document.getElementById(divid);
    divObj.style.left = coordinateX + "px";
    divObj.style.top = coordinateY + "px";
}