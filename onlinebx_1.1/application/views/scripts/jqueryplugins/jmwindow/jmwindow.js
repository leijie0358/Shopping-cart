//家猫弹窗
var jm_window = {
    winBody: '',
    winHead: $('<div class="jm_win_head"></div>'),
    winBottom: $('<div style="width:100%;border-top:1px solid #D9E2E9;text-align:center;padding-top:6px;padding-bottom:10px; background-color:#EFEFEF;"></div>'),
    win: $('<div></div>'),
    bodyParent: null,
    fullDiv: $('<div style="background-color:#AAA;filter:alpha(opacity=60);-moz-opacity:0.6;opacity: 0.6;position:absolute;left:0;top:0;width:100%;z-index:9999;"></div>')
};
var jm_buttons = { OK: 1, YesOrNo: 2 };
//显示窗口
jm_window.show = function (params) {
    if (!params) return;
    var body = (params.body) ? (typeof (params.body) == "object" ? params.body : $("#" + params.body)) : ""; //body参数可以为对象或标签ID
    var oktext = params.oktext || '确定';
    var yestext = params.yestext || '是';
    var notext = params.notext || '否';
    var title = params.title || '';
    var headheight = params.headheight || 22;
    var height = params.height || 0;
    var width = params.width || 200;
    var left = params.left || '35%';
    var top = params.top || 100;

    this.close();
    if (params.button && params.button == jm_buttons.YesOrNo) {
        var yesbutton = $('<input type="button" class="jm_win_button" value="' + yestext + '" />');
        var nobutton = $('<input type="button" class="jm_win_button" value="' + notext + '" />');
        //点击是按钮
        yesbutton.click(function () {
            if (params.yes) params.yes();
        });
        //点击否按钮
        nobutton.click(function () {
            if (params.no) params.no();
            jm_window.close();
        });
        this.winBottom.html("");
        yesbutton.appendTo(this.winBottom);
        nobutton.appendTo(this.winBottom);
    }
    else {
        var okbutton = $('<input type="button" class="jm_win_button" value="' + oktext + '" />');
        //点击否按钮
        okbutton.click(function () {
            if (params.ok) params.ok();
            jm_window.close();
        });
        okbutton.appendTo(this.winBottom);
    }
    //窗口   
    //如果是加载外部窗口
    if (body != '') {
        this.winBody = body;
        this.winBody.css('display', '');
        this.bodyParent = 
        	(this.winBody[0].parentElement == null)
        	?this.winBody[0].parentNode
        	:this.winBody[0].parentElement;  
    } else {
        this.winBody = $('<div></div>');
        this.winBody.css('text-align', 'center').css('word-wrap', 'break-word').css('padding-left', '12px')
.css('padding-bottom', '12px').css('padding-right', '15px').css('padding-top', '10px').css('background-color', 'white');
        this.winBody.css('height', (height - headheight) + 'px')
        this.winBody.parent = null;
    }
    if (title != '') {
        this.winHead.css('cursor', 'move').css('padding-left', '12px').css('padding-top', '4px');
        this.winHead.css('height', headheight + 'px');
        this.winHead.html(title);

        //添加关闭按钮
        var winClosebutton = $("<a class='jm_win_close_button' style='float:right' href='#'>X</a>");
        winClosebutton.click(function () {
            jm_window.close();
        })
        this.winHead.prepend(winClosebutton);
        this.winHead.appendTo(this.win);
    }
    this.winBody.appendTo(this.win);

    if (params.button) {
        this.winBottom.appendTo(this.win);
    }

    if (params.content) this.winBody.html(params.content);

    this.win.css('position', 'absolute').css('border-style', 'solid').css("border-color", "#21343E").css("border-width", "1px").css("font-size", "14px").css("line-height", "18px")
    .css('width', width + 'px').css('background-color', '#fafafa').css('left', left).css('top', top).css('z-index', '10000');
    if (height > 0) this.win.css('height', height + 'px')

    if (params.modal) {
        this.fullDiv.css('height', '100%');
        this.fullDiv.appendTo('body');
    }
    this.win.appendTo('body');
    JMDragDown.Register(this.win[0], this.winHead[0]);

	return this.win;
}
//关闭
jm_window.close = function () {
    if (this.bodyParent) {
        this.winBody.css('display', 'none');
        this.winBody.appendTo(this.bodyParent);
        this.bodyParent = null;
    }
    this.fullDiv.remove();
    this.win.html('');
this.winBottom.html('');
    this.win.remove();
}

var JMDragDown = function () {

    //客户端当前屏幕尺寸(忽略滚动条)
    var _clientWidth;
    var _clientHeight;

    //拖拽控制区
    var _controlObj;
    //拖拽对象
    var _dragObj;
    //拖动状态
    var _flag = false;

    //拖拽对象的当前位置
    var _dragObjCurrentLocation;

    //鼠标最后位置
    var _mouseLastLocation;

    var getElementDocument = function (element) {
        return element.ownerDocument || element.document;
    };

    //鼠标按下
    var dragMouseDownHandler = function (evt) {

        if (_dragObj) {

            evt = evt || window.event;

            //获取客户端屏幕尺寸
            _clientWidth = document.body.clientWidth;
            _clientHeight = document.documentElement.scrollHeight;

            //iframe遮罩
            $("#jm_dialog_mb1").css("display", "");

            //标记
            _flag = true;

            //拖拽对象位置初始化
            _dragObjCurrentLocation = {
                x: $(_dragObj).offset().left,
                y: $(_dragObj).offset().top
            };

            //鼠标最后位置初始化
            _mouseLastLocation = {
                x: evt.screenX,
                y: evt.screenY
            };

            //注：mousemove与mouseup下件均针对document注册，以解决鼠标离开_controlObj时事件丢失问题
            //注册事件(鼠标移动)			
            $(document).bind("mousemove", dragMouseMoveHandler);
            //注册事件(鼠标松开)
            $(document).bind("mouseup", dragMouseUpHandler);

            //取消事件的默认动作
            if (evt.preventDefault)
                evt.preventDefault();
            else
                evt.returnValue = false;
        }
    };

    //鼠标移动
    var dragMouseMoveHandler = function (evt) {
        if (_flag) {

            evt = evt || window.event;

            //当前鼠标的x,y座标
            var _mouseCurrentLocation = {
                x: evt.screenX,
                y: evt.screenY
            };

            //拖拽对象座标更新(变量)
            _dragObjCurrentLocation.x = _dragObjCurrentLocation.x + (_mouseCurrentLocation.x - _mouseLastLocation.x);
            _dragObjCurrentLocation.y = _dragObjCurrentLocation.y + (_mouseCurrentLocation.y - _mouseLastLocation.y);

            //将鼠标最后位置赋值为当前位置
            _mouseLastLocation = _mouseCurrentLocation;

            //拖拽对象座标更新(位置)
            $(_dragObj).css("left", _dragObjCurrentLocation.x + "px");
            $(_dragObj).css("top", _dragObjCurrentLocation.y + "px");

            //取消事件的默认动作
            if (evt.preventDefault)
                evt.preventDefault();
            else
                evt.returnValue = false;
        }
    };

    //鼠标松开
    var dragMouseUpHandler = function (evt) {
        if (_flag) {
            evt = evt || window.event;

            //取消iframe遮罩
            $("#jm_dialog_mb1").css("display", "none");

            //注销鼠标事件(mousemove mouseup)
            cleanMouseHandlers();

            //标记
            _flag = false;

        }
    };

    //注销鼠标事件(mousemove mouseup)
    var cleanMouseHandlers = function () {
        if (_controlObj) {
            $(_controlObj.document).unbind("mousemove");
            $(_controlObj.document).unbind("mouseup");
        }
    };

    return {
        //注册拖拽(参数为dom对象)
        Register: function (dragObj, controlObj) {
            //赋值
            _dragObj = dragObj;
            _controlObj = controlObj;
            //注册事件(鼠标按下)
            $(_controlObj).bind("mousedown", dragMouseDownHandler);
        }
    }

} ();